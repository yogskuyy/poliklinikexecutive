<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poli;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\PatientVisit;
use App\Models\DashboardSetting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Web Dashboard: Tampilan Web Lengkap untuk Desktop / Resepsionis / Manajemen
     */
    public function index(Request $request)
    {
        $data = $this->getDashboardData($request);
        return view('dashboard', $data);
    }

    /**
     * TV Display Mode: Tampilan Khusus Layar TV Ruang Tunggu Pasien (100vh Full Screen)
     */
    public function tvDisplay(Request $request)
    {
        $data = $this->getDashboardData($request);
        return view('tv', $data);
    }

    /**
     * Shared data query for both Web and TV views
     */
    private function getDashboardData(Request $request): array
    {
        $selectedPoliId = $request->query('poli_id');
        $selectedDay = $request->query('day', $this->getCurrentIndonesianDay());
        $selectedStatus = $request->query('status');

        // Patient Visits query (Prioritaskan kunjungan hari ini, jika hari baru belum ada data maka fallback ke tanggal kunjungan aktif)
        $hasTodayVisits = PatientVisit::whereDate('tanggal_kunjungan', Carbon::today())->exists();
        $activeDate = $hasTodayVisits ? Carbon::today() : (PatientVisit::max('tanggal_kunjungan') ?? Carbon::today());

        $polis = Poli::withCount([
            'doctors',
            'visits' => function ($query) use ($activeDate) {
                $query->whereDate('tanggal_kunjungan', $activeDate);
            }
        ])->get();

        // Doctor Schedules query
        $schedulesQuery = DoctorSchedule::with(['doctor.poli'])
            ->where('status_aktif', true);

        if ($selectedDay && $selectedDay !== 'Semua') {
            $schedulesQuery->where('hari', $selectedDay);
        }

        if ($selectedPoliId && $selectedPoliId !== 'all') {
            $schedulesQuery->whereHas('doctor', function($q) use ($selectedPoliId) {
                $q->where('poli_id', $selectedPoliId);
            });
        }

        $schedules = $schedulesQuery->orderBy('jam_mulai', 'asc')->get();

        // Doctors list
        $doctorsQuery = Doctor::with(['poli', 'schedules']);
        if ($selectedPoliId && $selectedPoliId !== 'all') {
            $doctorsQuery->where('poli_id', $selectedPoliId);
        }
        $doctors = $doctorsQuery->get();

        $visitsQuery = PatientVisit::with(['patient', 'poli', 'doctor'])
            ->whereDate('tanggal_kunjungan', $activeDate);

        if ($selectedPoliId && $selectedPoliId !== 'all') {
            $visitsQuery->where('poli_id', $selectedPoliId);
        }

        if ($selectedStatus && $selectedStatus !== 'all') {
            $visitsQuery->where('status', $selectedStatus);
        }

        $visits = $visitsQuery->orderBy('jam_janji', 'asc')->get();

        // Statistics
        $totalPasienHariIni = PatientVisit::whereDate('tanggal_kunjungan', $activeDate)->count();
        $pasienSedangDiperiksa = PatientVisit::whereDate('tanggal_kunjungan', $activeDate)->where('status', 'sedang_diperiksa')->count();
        $pasienMenunggu = PatientVisit::whereDate('tanggal_kunjungan', $activeDate)->where('status', 'menunggu')->count();
        $pasienSelesai = PatientVisit::whereDate('tanggal_kunjungan', $activeDate)->where('status', 'selesai')->count();
        $dokterPraktekCount = Doctor::where('status_praktek', 'praktek')->count();
        $totalDokter = Doctor::count();

        // Chart Data: Pasien per Poli
        $poliChartLabels = [];
        $poliChartData = [];
        $poliChartColors = [
            '#FF416C', '#6366F1', '#10B981', '#0EA5E9',
            '#F59E0B', '#EC4899', '#8B5CF6', '#3B82F6'
        ];

        foreach ($polis as $poli) {
            $count = PatientVisit::whereDate('tanggal_kunjungan', $activeDate)
                ->where('poli_id', $poli->id)
                ->count();
            $poliChartLabels[] = $poli->kode_poli;
            $poliChartData[] = $count;
        }

        // Hourly visit distribution (08:00 - 17:00)
        $hourlyLabels = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
        $hourlyData = [3, 6, 4, 2, 1, 2, 3, 1, 0, 0];

        $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Load Dynamic Dashboard Settings
        $settings = DashboardSetting::allKeyValues();
        $settings['show_video'] = $settings['show_video'] ?? '1';
        $settings['video_url'] = $settings['video_url'] ?? 'https://assets.mixkit.co/videos/preview/mixkit-doctor-checking-a-patient-in-a-hospital-room-41584-large.mp4';
        $settings['video_title'] = $settings['video_title'] ?? 'Edukasi Kesehatan: Gaya Hidup Sehat & Pencegahan Penyakit Jantung';
        $settings['show_running_text'] = $settings['show_running_text'] ?? '1';
        $settings['running_text_label'] = $settings['running_text_label'] ?? 'PENGUMUMAN';
        $settings['running_text_speed'] = $settings['running_text_speed'] ?? '75s';
        $settings['hospital_name'] = $settings['hospital_name'] ?? 'POLIKLINIK EKSEKUTIF';
        $settings['hospital_subtitle'] = $settings['hospital_subtitle'] ?? 'Sistem Monitoring Terintegrasi & Alur Pasien Prioritas';
        $settings['hospital_badge'] = $settings['hospital_badge'] ?? 'VIP SUITE';
        $settings['show_analytics'] = $settings['show_analytics'] ?? '0';

        $runningTextItems = $settings['running_text_items'] ?? [];
        if (!is_array($runningTextItems) || empty($runningTextItems)) {
            $runningTextItems = [
                ['icon' => 'fa-solid fa-crown', 'color' => 'text-amber-400', 'text' => '<strong>Selamat Datang di Poliklinik Eksekutif VIP Suite.</strong> Pelayanan medis prioritas dengan kenyamanan premium.'],
                ['icon' => 'fa-solid fa-bell', 'color' => 'text-cyan-400', 'text' => 'Pasien prioritas harap memperhatikan panggilan nomor antrian pada layar display & pengumuman suara perawat.'],
                ['icon' => 'fa-solid fa-mug-hot', 'color' => 'text-emerald-400', 'text' => 'Minuman selamat datang dan hidangan ringan tersedia gratis di Executive Lounge Lantai 2.'],
                ['icon' => 'fa-solid fa-prescription-bottle-medical', 'color' => 'text-rose-400', 'text' => 'Fasilitas Pengambilan Obat & Farmasi Prioritas dapat diakses tepat di samping Lounge Suite.'],
                ['icon' => 'fa-solid fa-handshake-angle', 'color' => 'text-indigo-400', 'text' => 'Untuk bantuan pendampingan khusus atau kursi roda, silakan hubungi staf Hospitality Desk kami.']
            ];
        }

        return compact(
            'polis',
            'schedules',
            'doctors',
            'visits',
            'totalPasienHariIni',
            'pasienSedangDiperiksa',
            'pasienMenunggu',
            'pasienSelesai',
            'dokterPraktekCount',
            'totalDokter',
            'poliChartLabels',
            'poliChartData',
            'poliChartColors',
            'hourlyLabels',
            'hourlyData',
            'selectedPoliId',
            'selectedDay',
            'selectedStatus',
            'daysOfWeek',
            'settings',
            'runningTextItems'
        );
    }

    public function apiVisits(Request $request)
    {
        $poliId = $request->query('poli_id');
        $status = $request->query('status');
        $search = $request->query('search');

        $hasTodayVisits = PatientVisit::whereDate('tanggal_kunjungan', Carbon::today())->exists();
        $activeDate = $hasTodayVisits ? Carbon::today() : (PatientVisit::max('tanggal_kunjungan') ?? Carbon::today());

        $query = PatientVisit::with(['patient', 'poli', 'doctor'])
            ->whereDate('tanggal_kunjungan', $activeDate);

        if ($poliId && $poliId !== 'all') {
            $query->where('poli_id', $poliId);
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('patient', function($pq) use ($search) {
                    $pq->where('nama_lengkap', 'like', "%{$search}%")
                       ->orWhere('no_rm', 'like', "%{$search}%");
                })->orWhere('nomor_antrian', 'like', "%{$search}%");
            });
        }

        $visits = $query->orderBy('jam_janji', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $visits
        ]);
    }

    public function storeVisit(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'usia' => 'required|integer|min:0|max:120',
            'no_telepon' => 'required|string|max:25',
            'tipe_layanan' => 'required|in:VVIP,VIP,Eksekutif Premium',
            'asuransi' => 'required|string|max:100',
            'poli_id' => 'required|exists:polis,id',
            'doctor_id' => 'required|exists:doctors,id',
            'jam_janji' => 'required',
            'tingkat_urgensi' => 'required|in:Normal,Prioritas,VIP Urgent',
            'keluhan_utama' => 'required|string',
            'tensi_darah' => 'nullable|string',
            'suhu_tubuh' => 'nullable|numeric'
        ]);

        // Create or find patient
        $noRm = 'RM-EK-' . date('Y') . '-' . str_pad(rand(100, 999), 4, '0', STR_PAD_LEFT);
        $patient = Patient::create([
            'no_rm' => $noRm,
            'nama_lengkap' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'usia' => $validated['usia'],
            'no_telepon' => $validated['no_telepon'],
            'tipe_layanan' => $validated['tipe_layanan'],
            'asuransi' => $validated['asuransi'],
        ]);

        $poli = Poli::findOrFail($validated['poli_id']);
        $countToday = PatientVisit::whereDate('tanggal_kunjungan', Carbon::today())->where('poli_id', $poli->id)->count() + 1;
        $queueNumber = 'EX-' . $poli->kode_poli . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);

        $visit = PatientVisit::create([
            'patient_id' => $patient->id,
            'poli_id' => $validated['poli_id'],
            'doctor_id' => $validated['doctor_id'],
            'nomor_antrian' => $queueNumber,
            'tanggal_kunjungan' => Carbon::today(),
            'jam_janji' => $validated['jam_janji'],
            'keluhan_utama' => $validated['keluhan_utama'],
            'status' => 'menunggu',
            'tingkat_urgensi' => $validated['tingkat_urgensi'],
            'tensi_darah' => $validated['tensi_darah'] ?? '120/80',
            'suhu_tubuh' => $validated['suhu_tubuh'] ?? 36.5,
            'catatan_dokter' => 'Pendaftaran baru melalui Executive Counter.'
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pasien eksekutif berhasil didaftarkan!',
                'data' => $visit->load(['patient', 'poli', 'doctor'])
            ]);
        }

        return redirect()->back()->with('success', 'Pasien eksekutif berhasil didaftarkan dengan No. Antrian ' . $queueNumber);
    }

    public function updateVisitStatus(Request $request, $id)
    {
        $visit = PatientVisit::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:menunggu,sedang_diperiksa,farmasi,selesai,batal'
        ]);

        $visit->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status kunjungan pasien berhasil diperbarui!',
            'status' => $visit->status,
            'badge' => $visit->status_badge
        ]);
    }

    public function updateDoctorStatus(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $validated = $request->validate([
            'status_praktek' => 'required|in:praktek,istirahat,selesai,belum_mulai,cuti'
        ]);

        $doctor->update(['status_praktek' => $validated['status_praktek']]);

        return response()->json([
            'success' => true,
            'message' => 'Status dokter ' . $doctor->nama_lengkap . ' berhasil diubah menjadi ' . $doctor->status_label,
            'status_praktek' => $doctor->status_praktek,
            'status_label' => $doctor->status_label
        ]);
    }

    private function getCurrentIndonesianDay(): string
    {
        $dayNum = date('N'); // 1 (Mon) - 7 (Sun)
        $map = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];
        return $map[$dayNum] ?? 'Senin';
    }
}
