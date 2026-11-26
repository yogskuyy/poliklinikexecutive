<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DashboardSetting;
use App\Models\Poli;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\PatientVisit;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the Admin Management Dashboard
     */
    public function index(Request $request)
    {
        $settings = DashboardSetting::allKeyValues();

        // If settings are not seeded yet, fallback to defaults
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
        if (!is_array($runningTextItems)) {
            $runningTextItems = [];
        }

        // Data Models
        $polis = Poli::withCount(['doctors', 'visits'])->get();
        $doctors = Doctor::with(['poli', 'schedules'])->get();
        $schedules = DoctorSchedule::with('doctor.poli')->orderBy('jam_mulai')->get();
        
        $todayVisits = PatientVisit::with(['patient', 'poli', 'doctor'])
            ->whereDate('tanggal_kunjungan', Carbon::today())
            ->orderBy('jam_janji', 'asc')
            ->get();

        $patients = Patient::latest()->take(30)->get();

        // Statistics
        $totalPasienHariIni = $todayVisits->count();
        $pasienSedangDiperiksa = $todayVisits->where('status', 'sedang_diperiksa')->count();
        $pasienMenunggu = $todayVisits->where('status', 'menunggu')->count();
        $pasienSelesai = $todayVisits->where('status', 'selesai')->count();
        $dokterPraktekCount = $doctors->where('status_praktek', 'praktek')->count();

        return view('admin.index', compact(
            'settings',
            'runningTextItems',
            'polis',
            'doctors',
            'schedules',
            'todayVisits',
            'patients',
            'totalPasienHariIni',
            'pasienSedangDiperiksa',
            'pasienMenunggu',
            'pasienSelesai',
            'dokterPraktekCount'
        ));
    }

    /**
     * Update Dashboard TV & Display Settings
     */
    public function updateSettings(Request $request)
    {
        // Toggle Video display: checkbox present or explicit '1'/'0'
        $showVideo = $request->has('show_video') ? ($request->input('show_video') ? '1' : '0') : '0';
        DashboardSetting::set('show_video', $showVideo, 'display');

        if ($request->filled('video_url')) {
            DashboardSetting::set('video_url', trim($request->input('video_url')), 'display');
        }
        if ($request->filled('video_title')) {
            DashboardSetting::set('video_title', trim($request->input('video_title')), 'display');
        }

        // Toggle Running Text
        $showRunningText = $request->has('show_running_text') ? ($request->input('show_running_text') ? '1' : '0') : '0';
        DashboardSetting::set('show_running_text', $showRunningText, 'display');

        if ($request->filled('running_text_label')) {
            DashboardSetting::set('running_text_label', trim($request->input('running_text_label')), 'display');
        }
        if ($request->filled('running_text_speed')) {
            DashboardSetting::set('running_text_speed', trim($request->input('running_text_speed')), 'display');
        }

        // Toggle Analytics & Bottom Charts on TV
        $showAnalytics = $request->has('show_analytics') ? ($request->input('show_analytics') ? '1' : '0') : '0';
        DashboardSetting::set('show_analytics', $showAnalytics, 'display');

        // Branding
        if ($request->filled('hospital_name')) {
            DashboardSetting::set('hospital_name', trim($request->input('hospital_name')), 'branding');
        }
        if ($request->filled('hospital_subtitle')) {
            DashboardSetting::set('hospital_subtitle', trim($request->input('hospital_subtitle')), 'branding');
        }
        if ($request->filled('hospital_badge')) {
            DashboardSetting::set('hospital_badge', trim($request->input('hospital_badge')), 'branding');
        }

        // Running Text raw lines if provided
        if ($request->has('running_text_raw')) {
            $raw = trim($request->input('running_text_raw'));
            $lines = array_filter(array_map('trim', explode("\n", $raw)));
            $items = [];
            $icons = ['fa-solid fa-crown', 'fa-solid fa-bell', 'fa-solid fa-mug-hot', 'fa-solid fa-prescription-bottle-medical', 'fa-solid fa-handshake-angle', 'fa-solid fa-circle-info'];
            $colors = ['text-amber-400', 'text-cyan-400', 'text-emerald-400', 'text-rose-400', 'text-indigo-400', 'text-sky-400'];

            $i = 0;
            foreach ($lines as $line) {
                if (!empty($line)) {
                    $items[] = [
                        'id' => $i + 1,
                        'icon' => $icons[$i % count($icons)],
                        'color' => $colors[$i % count($colors)],
                        'text' => $line
                    ];
                    $i++;
                }
            }
            if (!empty($items)) {
                DashboardSetting::set('running_text_items', $items, 'display');
            }
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan tampilan dashboard berhasil diperbarui!',
                'settings' => DashboardSetting::allKeyValues()
            ]);
        }

        return redirect()->route('admin.index')->with('success', 'Pengaturan dashboard TV berhasil disimpan!');
    }

    /**
     * Manage Running Text Items (Add/Remove)
     */
    public function updateRunningText(Request $request)
    {
        $action = $request->input('action', 'save_all');

        if ($action === 'add') {
            $text = trim($request->input('text'));
            if (!$text) {
                return response()->json(['success' => false, 'message' => 'Teks pengumuman tidak boleh kosong.'], 422);
            }

            $currentItems = DashboardSetting::get('running_text_items', []);
            if (!is_array($currentItems)) $currentItems = [];

            $newId = count($currentItems) ? max(array_column($currentItems, 'id')) + 1 : 1;
            $currentItems[] = [
                'id' => $newId,
                'icon' => $request->input('icon', 'fa-solid fa-circle-info'),
                'color' => $request->input('color', 'text-cyan-400'),
                'text' => $text
            ];

            DashboardSetting::set('running_text_items', $currentItems, 'display');

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman baru berhasil ditambahkan ke running text!',
                'items' => $currentItems
            ]);
        }

        if ($action === 'delete') {
            $idToDelete = (int)$request->input('id');
            $currentItems = DashboardSetting::get('running_text_items', []);
            if (!is_array($currentItems)) $currentItems = [];

            $filtered = array_values(array_filter($currentItems, fn($it) => ($it['id'] ?? 0) !== $idToDelete));
            DashboardSetting::set('running_text_items', $filtered, 'display');

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil dihapus!',
                'items' => $filtered
            ]);
        }

        // Default: save entire items array or raw text
        if ($request->has('items')) {
            $items = $request->input('items');
            DashboardSetting::set('running_text_items', $items, 'display');
            return response()->json(['success' => true, 'message' => 'Running text berhasil diperbarui!', 'items' => $items]);
        }

        return redirect()->route('admin.index')->with('success', 'Running text berhasil diperbarui!');
    }

    /**
     * Add Patient & Queue to Today's Visits
     */
    public function storePatient(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'poli_id' => 'required|exists:polis,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $poli = Poli::findOrFail($request->poli_id);

        // Find or create Patient
        $noRm = $request->input('no_rm') ?: 'RM-' . rand(100000, 999999);
        $patient = Patient::firstOrCreate(
            ['no_rm' => $noRm],
            [
                'nama' => $request->nama_pasien,
                'jenis_kelamin' => $request->input('jenis_kelamin', 'L'),
                'tanggal_lahir' => $request->input('tanggal_lahir', '1985-05-15'),
                'no_telepon' => $request->input('no_telepon', '0812' . rand(10000000, 99999999)),
                'tipe_pasien' => $request->input('tipe_pasien', 'VIP')
            ]
        );

        // Count visits for this poli today to generate queue number
        $todayPoliCount = PatientVisit::whereDate('tanggal_kunjungan', Carbon::today())
            ->where('poli_id', $poli->id)
            ->count() + 1;
        $noAntrian = $poli->kode_poli . '-' . str_pad($todayPoliCount, 3, '0', STR_PAD_LEFT);

        $visit = PatientVisit::create([
            'patient_id' => $patient->id,
            'poli_id' => $poli->id,
            'doctor_id' => $request->doctor_id,
            'no_antrian' => $noAntrian,
            'tanggal_kunjungan' => Carbon::today(),
            'jam_janji' => $request->input('jam_janji', Carbon::now()->format('H:i')),
            'status' => $request->input('status', 'menunggu'),
            'tipe_layanan' => $request->input('tipe_layanan', 'VIP'),
            'catatan' => $request->input('catatan', 'Pasien Prioritas Eksekutif')
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Pasien {$patient->nama} berhasil didaftarkan ke {$poli->nama_poli} dengan No. Antrian {$noAntrian}!",
                'visit' => $visit->load(['patient', 'poli', 'doctor'])
            ]);
        }

        return redirect()->route('admin.index')->with('success', "Pasien {$patient->nama} berhasil didaftarkan dengan antrian {$noAntrian}!");
    }

    /**
     * Update visit status (menunggu, sedang_diperiksa, selesai, batal)
     */
    public function updateVisitStatus(Request $request, $id)
    {
        $visit = PatientVisit::findOrFail($id);
        $newStatus = $request->input('status');

        $visit->status = $newStatus;
        if ($newStatus === 'sedang_diperiksa') {
            $visit->jam_masuk_poli = Carbon::now()->format('H:i:s');
        } elseif ($newStatus === 'selesai') {
            $visit->jam_selesai = Carbon::now()->format('H:i:s');
        }
        $visit->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Status antrian {$visit->no_antrian} diubah menjadi " . ucfirst(str_replace('_', ' ', $newStatus)),
                'visit' => $visit
            ]);
        }

        return redirect()->route('admin.index')->with('success', "Status antrian {$visit->no_antrian} diperbarui.");
    }

    /**
     * Update Doctor Practice Status
     */
    public function updateDoctorStatus(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->status_praktek = $request->input('status_praktek', 'praktek');
        $doctor->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Status praktek dr. {$doctor->nama_dokter} berhasil diubah menjadi " . ucfirst($doctor->status_praktek),
                'doctor' => $doctor
            ]);
        }

        return redirect()->route('admin.index')->with('success', "Status praktek dr. {$doctor->nama_dokter} diperbarui.");
    }

    /**
     * Store new Doctor
     */
    public function storeDoctor(Request $request)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'poli_id' => 'required|exists:polis,id'
        ]);

        $doctor = Doctor::create([
            'nama_dokter' => $request->nama_dokter,
            'spesialisasi' => $request->spesialisasi,
            'poli_id' => $request->poli_id,
            'gelar' => $request->input('gelar', 'Sp.A / Sp.JP'),
            'no_sip' => $request->input('no_sip', 'SIP/' . rand(100, 999) . '/RS-EKS/2026'),
            'status_praktek' => $request->input('status_praktek', 'praktek'),
            'foto' => $request->input('foto', 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=400&auto=format&fit=crop'),
            'kuota_harian' => $request->input('kuota_harian', 15),
            'rating' => 4.9
        ]);

        // Default schedules
        $days = ['Senin', 'Rabu', 'Jumat'];
        foreach ($days as $day) {
            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'hari' => $day,
                'jam_mulai' => '09:00',
                'jam_selesai' => '13:00',
                'ruangan' => 'Suite ' . rand(1, 8),
                'kuota' => 15,
                'status_aktif' => true
            ]);
        }

        return redirect()->route('admin.index')->with('success', "Dokter {$doctor->nama_dokter} berhasil ditambahkan!");
    }
}
