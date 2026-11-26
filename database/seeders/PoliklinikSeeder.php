<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poli;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\PatientVisit;
use Carbon\Carbon;

class PoliklinikSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Poli Eksekutif
        $polisData = [
            [
                'nama_poli' => 'Poli Jantung & Pembuluh Darah Eksekutif',
                'kode_poli' => 'JTG',
                'icon' => 'fa-heart-pulse',
                'warna_gradien' => 'linear-gradient(135deg, #FF416C 0%, #FF4B2B 100%)',
                'warna_badge' => 'bg-rose-50 text-rose-700 border-rose-200',
                'lokasi_ruangan' => 'Gedung Eksekutif Lt. 3, Suite 301-303',
                'deskripsi' => 'Layanan kardiologi eksekutif komprehensif didukung Echocardiography 4D, Treadmill Stress Test, dan Ruang Konsultasi Privat.',
                'kuota_harian' => 25,
            ],
            [
                'nama_poli' => 'Poli Penyakit Dalam VIP',
                'kode_poli' => 'INT',
                'icon' => 'fa-stethoscope',
                'warna_gradien' => 'linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%)',
                'warna_badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                'lokasi_ruangan' => 'Gedung Eksekutif Lt. 2, Suite 201-204',
                'deskripsi' => 'Diagnosis mendalam penyakit metabolik, gastroenterohepatologi, dan endokrin dengan akses laboratorium prioritas.',
                'kuota_harian' => 30,
            ],
            [
                'nama_poli' => 'Poli Anak & Tumbuh Kembang Eksekutif',
                'kode_poli' => 'ANK',
                'icon' => 'fa-baby',
                'warna_gradien' => 'linear-gradient(135deg, #10B981 0%, #06B6D4 100%)',
                'warna_badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'lokasi_ruangan' => 'Gedung Eksekutif Lt. 2, Kids Luxury Zone',
                'deskripsi' => 'Klinik anak ramah anak dengan playground higienis, vaksinasi impor terstandar, dan skrining tumbuh kembang.',
                'kuota_harian' => 25,
            ],
            [
                'nama_poli' => 'Poli Mata & Bedah Refraktif',
                'kode_poli' => 'MTA',
                'icon' => 'fa-eye',
                'warna_gradien' => 'linear-gradient(135deg, #0EA5E9 0%, #3B82F6 100%)',
                'warna_badge' => 'bg-sky-50 text-sky-700 border-sky-200',
                'lokasi_ruangan' => 'Gedung Eksekutif Lt. 3, Suite 305',
                'deskripsi' => 'Pemeriksaan oftalmologi modern dengan Optical Coherence Tomography (OCT) & konsultasi penanganan katarak premium.',
                'kuota_harian' => 20,
            ],
            [
                'nama_poli' => 'Poli Gigi & Mulut Spesialistik',
                'kode_poli' => 'GGI',
                'icon' => 'fa-tooth',
                'warna_gradien' => 'linear-gradient(135deg, #F59E0B 0%, #D97706 100%)',
                'warna_badge' => 'bg-amber-50 text-amber-700 border-amber-200',
                'lokasi_ruangan' => 'Gedung Eksekutif Lt. 4, Dental Lounge',
                'deskripsi' => 'Perawatan estetika gigi, ortodonti, implantologi & bedah mulut dengan dental chair berteknologi mutakhir bebas nyeri.',
                'kuota_harian' => 20,
            ],
            [
                'nama_poli' => 'Poli Kebidanan & Kandungan (Fetomaternal)',
                'kode_poli' => 'OBG',
                'icon' => 'fa-person-breastfeeding',
                'warna_gradien' => 'linear-gradient(135deg, #EC4899 0%, #D946EF 100%)',
                'warna_badge' => 'bg-pink-50 text-pink-700 border-pink-200',
                'lokasi_ruangan' => 'Gedung Eksekutif Lt. 3, Suite Suite Ibu & Janin',
                'deskripsi' => 'Pemeriksaan USG 5D HD-Live, skrining kelainan genetik janin, dan pendampingan kehamilan privat dengan obgyn terkemuka.',
                'kuota_harian' => 22,
            ],
            [
                'nama_poli' => 'Poli Kulit & Estetika Medis Eksekutif',
                'kode_poli' => 'KLT',
                'icon' => 'fa-wand-magic-sparkles',
                'warna_gradien' => 'linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%)',
                'warna_badge' => 'bg-purple-50 text-purple-700 border-purple-200',
                'lokasi_ruangan' => 'Gedung Eksekutif Lt. 4, Glow Spa Clinic',
                'deskripsi' => 'Terapi laser dermatologi, anti-aging lanjutan, dan perawatan dermatologi klinis dengan privasi optimal.',
                'kuota_harian' => 20,
            ],
            [
                'nama_poli' => 'Poli Saraf & Neurologi Intervensi',
                'kode_poli' => 'SRF',
                'icon' => 'fa-brain',
                'warna_gradien' => 'linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%)',
                'warna_badge' => 'bg-blue-50 text-blue-700 border-blue-200',
                'lokasi_ruangan' => 'Gedung Eksekutif Lt. 2, Suite 208',
                'deskripsi' => 'Pusat diagnosis stroke, vertigo, nyeri tulang belakang, dan gangguan saraf dengan fasilitas EMG & EEG modern.',
                'kuota_harian' => 18,
            ],
        ];

        $polis = [];
        foreach ($polisData as $p) {
            $polis[$p['kode_poli']] = Poli::create($p);
        }

        // 2. Data Dokter Eksekutif
        $doctorsData = [
            [
                'poli_id' => $polis['JTG']->id,
                'nama_lengkap' => 'Prof. dr. Raden Arya Wijaya, Sp.JP(K), FIHA',
                'nip_str' => 'STR: 31.1.1.100.2.19.088234',
                'spesialisasi' => 'Spesialis Jantung & Pembuluh Darah (Konsultan Kardiologi Intervensi)',
                'foto_url' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'praktek',
                'nomor_kontak' => '+62 811-9234-8801',
                'ruang_praktek' => 'Executive Suite 301',
                'rating' => 4.9,
                'pengalaman_tahun' => 18,
            ],
            [
                'poli_id' => $polis['JTG']->id,
                'nama_lengkap' => 'dr. Felicia Salim, Sp.JP(K), FAsCC',
                'nip_str' => 'STR: 31.2.1.200.1.20.091455',
                'spesialisasi' => 'Spesialis Jantung & Pembuluh Darah (Aritmia & Elektrofisiologi)',
                'foto_url' => 'https://images.unsplash.com/photo-1594824813578-831e505ba1e4?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'istirahat',
                'nomor_kontak' => '+62 812-4433-2211',
                'ruang_praktek' => 'Executive Suite 302',
                'rating' => 4.8,
                'pengalaman_tahun' => 12,
            ],
            [
                'poli_id' => $polis['INT']->id,
                'nama_lengkap' => 'dr. Hendra Gunawan, Sp.PD-KGEH, FINASIM',
                'nip_str' => 'STR: 31.1.1.300.3.18.045612',
                'spesialisasi' => 'Spesialis Penyakit Dalam (Konsultan Gastroenterohepatologi)',
                'foto_url' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'praktek',
                'nomor_kontak' => '+62 813-8877-6655',
                'ruang_praktek' => 'Executive Suite 201',
                'rating' => 4.9,
                'pengalaman_tahun' => 15,
            ],
            [
                'poli_id' => $polis['INT']->id,
                'nama_lengkap' => 'dr. Melani Kusuma, Sp.PD-KEMD',
                'nip_str' => 'STR: 31.2.1.400.2.21.077890',
                'spesialisasi' => 'Spesialis Penyakit Dalam (Konsultan Endokrin, Metabolik & Diabetes)',
                'foto_url' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'belum_mulai',
                'nomor_kontak' => '+62 811-1928-3746',
                'ruang_praktek' => 'Executive Suite 202',
                'rating' => 4.9,
                'pengalaman_tahun' => 11,
            ],
            [
                'poli_id' => $polis['ANK']->id,
                'nama_lengkap' => 'dr. Amanda Clarissa, Sp.A(K), M.Biomed',
                'nip_str' => 'STR: 31.2.1.500.1.17.065431',
                'spesialisasi' => 'Spesialis Anak (Konsultan Tumbuh Kembang & Pediatri Sosial)',
                'foto_url' => 'https://images.unsplash.com/photo-1594824813689-f53835a7fc4d?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'praktek',
                'nomor_kontak' => '+62 812-9988-7711',
                'ruang_praktek' => 'Kids Luxury Suite 205',
                'rating' => 5.0,
                'pengalaman_tahun' => 14,
            ],
            [
                'poli_id' => $polis['MTA']->id,
                'nama_lengkap' => 'dr. Baskoro Adji, Sp.M(K), FICO',
                'nip_str' => 'STR: 31.1.1.600.4.16.034521',
                'spesialisasi' => 'Spesialis Mata (Konsultan Kornea, Lensa & Bedah Refraktif)',
                'foto_url' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'praktek',
                'nomor_kontak' => '+62 813-1122-3344',
                'ruang_praktek' => 'Executive Suite 305',
                'rating' => 4.8,
                'pengalaman_tahun' => 16,
            ],
            [
                'poli_id' => $polis['GGI']->id,
                'nama_lengkap' => 'drg. Kevin Pradana, Sp.KG(K)',
                'nip_str' => 'STR: 31.1.2.700.2.19.098765',
                'spesialisasi' => 'Spesialis Konservasi Gigi & Estetika Rekonstruksi',
                'foto_url' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'praktek',
                'nomor_kontak' => '+62 811-8899-0011',
                'ruang_praktek' => 'Dental Lounge Suite 401',
                'rating' => 4.9,
                'pengalaman_tahun' => 9,
            ],
            [
                'poli_id' => $polis['OBG']->id,
                'nama_lengkap' => 'dr. Citra Dewi Prameswari, Sp.OG(K)-KFM',
                'nip_str' => 'STR: 31.2.1.800.1.15.023419',
                'spesialisasi' => 'Spesialis Kebidanan & Kandungan (Konsultan Fetomaternal)',
                'foto_url' => 'https://images.unsplash.com/photo-1651008376811-b90baee60c1f?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'praktek',
                'nomor_kontak' => '+62 812-7766-5544',
                'ruang_praktek' => 'Suite Ibu & Janin 308',
                'rating' => 5.0,
                'pengalaman_tahun' => 17,
            ],
            [
                'poli_id' => $polis['KLT']->id,
                'nama_lengkap' => 'dr. Natasha Belinda, Sp.D.V.E, FINSDV',
                'nip_str' => 'STR: 31.2.1.900.3.20.089012',
                'spesialisasi' => 'Spesialis Dermatologi, Venereologi & Estetika Laser',
                'foto_url' => 'https://images.unsplash.com/photo-1594824813580-e8893962b80f?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'praktek',
                'nomor_kontak' => '+62 813-3344-5566',
                'ruang_praktek' => 'Glow Spa Suite 405',
                'rating' => 4.9,
                'pengalaman_tahun' => 10,
            ],
            [
                'poli_id' => $polis['SRF']->id,
                'nama_lengkap' => 'dr. Dimas Surya Nugraha, Sp.N(K), FICA',
                'nip_str' => 'STR: 31.1.1.000.5.18.012398',
                'spesialisasi' => 'Spesialis Neurologi (Konsultan Neurovaskular & Stroke)',
                'foto_url' => 'https://images.unsplash.com/photo-1622902046580-2b47f47f5471?q=80&w=400&auto=format&fit=crop',
                'status_praktek' => 'selesai',
                'nomor_kontak' => '+62 811-4455-6677',
                'ruang_praktek' => 'Executive Suite 208',
                'rating' => 4.8,
                'pengalaman_tahun' => 13,
            ]
        ];

        $doctors = [];
        foreach ($doctorsData as $d) {
            $doctors[] = Doctor::create($d);
        }

        // 3. Data Jadwal Dokter (Doctor Schedules)
        $schedules = [
            // Prof. Arya (Jantung)
            ['doctor_id' => $doctors[0]->id, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'shift' => 'Pagi', 'kuota_pasien' => 15, 'terisi' => 14, 'catatan' => 'Sesi Konsultasi Intervensi Prioritas'],
            ['doctor_id' => $doctors[0]->id, 'hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'shift' => 'Pagi', 'kuota_pasien' => 15, 'terisi' => 11, 'catatan' => 'Pemeriksaan Echocardiography Eksekutif'],
            ['doctor_id' => $doctors[0]->id, 'hari' => 'Jumat', 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'shift' => 'Siang', 'kuota_pasien' => 12, 'terisi' => 9, 'catatan' => 'Evaluasi Pasca Kateterisasi'],

            // dr. Felicia (Jantung)
            ['doctor_id' => $doctors[1]->id, 'hari' => 'Selasa', 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'shift' => 'Siang', 'kuota_pasien' => 15, 'terisi' => 8, 'catatan' => 'Klinik Holter & Gangguan Irama Jantung'],
            ['doctor_id' => $doctors[1]->id, 'hari' => 'Kamis', 'jam_mulai' => '09:00', 'jam_selesai' => '13:00', 'shift' => 'Pagi', 'kuota_pasien' => 15, 'terisi' => 12, 'catatan' => 'Konsultasi Privat Pacemaker'],
            ['doctor_id' => $doctors[1]->id, 'hari' => 'Sabtu', 'jam_mulai' => '08:30', 'jam_selesai' => '12:30', 'shift' => 'Pagi', 'kuota_pasien' => 10, 'terisi' => 10, 'catatan' => 'Weekend Executive Screening'],

            // dr. Hendra (Penyakit Dalam)
            ['doctor_id' => $doctors[2]->id, 'hari' => 'Senin', 'jam_mulai' => '08:30', 'jam_selesai' => '12:30', 'shift' => 'Pagi', 'kuota_pasien' => 18, 'terisi' => 16, 'catatan' => 'Konsultasi Digestif & Liver'],
            ['doctor_id' => $doctors[2]->id, 'hari' => 'Selasa', 'jam_mulai' => '08:30', 'jam_selesai' => '12:30', 'shift' => 'Pagi', 'kuota_pasien' => 18, 'terisi' => 15, 'catatan' => 'Skrining Endoskopi VIP'],
            ['doctor_id' => $doctors[2]->id, 'hari' => 'Kamis', 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'shift' => 'Siang', 'kuota_pasien' => 15, 'terisi' => 13, 'catatan' => 'Evaluasi Penyakit Metabolik Kronis'],

            // dr. Melani (Penyakit Dalam)
            ['doctor_id' => $doctors[3]->id, 'hari' => 'Rabu', 'jam_mulai' => '14:00', 'jam_selesai' => '18:00', 'shift' => 'Siang', 'kuota_pasien' => 16, 'terisi' => 12, 'catatan' => 'Manajemen Diabetes Komprehensif'],
            ['doctor_id' => $doctors[3]->id, 'hari' => 'Jumat', 'jam_mulai' => '09:00', 'jam_selesai' => '12:00', 'shift' => 'Pagi', 'kuota_pasien' => 12, 'terisi' => 7, 'catatan' => 'Pemeriksaan Tiroid & Hormon'],

            // dr. Amanda (Anak)
            ['doctor_id' => $doctors[4]->id, 'hari' => 'Senin', 'jam_mulai' => '09:00', 'jam_selesai' => '13:00', 'shift' => 'Pagi', 'kuota_pasien' => 16, 'terisi' => 15, 'catatan' => 'Tumbuh Kembang & Skrining Sensori'],
            ['doctor_id' => $doctors[4]->id, 'hari' => 'Rabu', 'jam_mulai' => '09:00', 'jam_selesai' => '13:00', 'shift' => 'Pagi', 'kuota_pasien' => 16, 'terisi' => 14, 'catatan' => 'Vaksinasi Terjadwal Bebas Antre'],
            ['doctor_id' => $doctors[4]->id, 'hari' => 'Sabtu', 'jam_mulai' => '09:00', 'jam_selesai' => '14:00', 'shift' => 'Pagi', 'kuota_pasien' => 20, 'terisi' => 19, 'catatan' => 'Weekend Kids VIP Care'],

            // dr. Baskoro (Mata)
            ['doctor_id' => $doctors[5]->id, 'hari' => 'Selasa', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'shift' => 'Pagi', 'kuota_pasien' => 14, 'terisi' => 11, 'catatan' => 'Pemeriksaan Retina & Glaukoma'],
            ['doctor_id' => $doctors[5]->id, 'hari' => 'Kamis', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'shift' => 'Pagi', 'kuota_pasien' => 14, 'terisi' => 13, 'catatan' => 'Screening Lasik & Kornea'],

            // drg. Kevin (Gigi)
            ['doctor_id' => $doctors[6]->id, 'hari' => 'Senin', 'jam_mulai' => '10:00', 'jam_selesai' => '15:00', 'shift' => 'Siang', 'kuota_pasien' => 10, 'terisi' => 8, 'catatan' => 'Restorasi Estetika & Veneer'],
            ['doctor_id' => $doctors[6]->id, 'hari' => 'Rabu', 'jam_mulai' => '10:00', 'jam_selesai' => '15:00', 'shift' => 'Siang', 'kuota_pasien' => 10, 'terisi' => 9, 'catatan' => 'Endodontik Mikroskopik'],
            ['doctor_id' => $doctors[6]->id, 'hari' => 'Jumat', 'jam_mulai' => '13:30', 'jam_selesai' => '18:00', 'shift' => 'Siang', 'kuota_pasien' => 8, 'terisi' => 7, 'catatan' => 'Perawatan Periodontal VIP'],

            // dr. Citra Dewi (Kandungan)
            ['doctor_id' => $doctors[7]->id, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '13:00', 'shift' => 'Pagi', 'kuota_pasien' => 15, 'terisi' => 14, 'catatan' => 'USG 5D HD-Live & Fetomaternal'],
            ['doctor_id' => $doctors[7]->id, 'hari' => 'Kamis', 'jam_mulai' => '13:00', 'jam_selesai' => '18:00', 'shift' => 'Siang', 'kuota_pasien' => 15, 'terisi' => 15, 'catatan' => 'Antenatal Care High-Risk Pregnancy'],

            // dr. Natasha (Kulit)
            ['doctor_id' => $doctors[8]->id, 'hari' => 'Selasa', 'jam_mulai' => '11:00', 'jam_selesai' => '16:00', 'shift' => 'Siang', 'kuota_pasien' => 12, 'terisi' => 10, 'catatan' => 'Laser Rejuvenation & Skin Health'],
            ['doctor_id' => $doctors[8]->id, 'hari' => 'Jumat', 'jam_mulai' => '11:00', 'jam_selesai' => '16:00', 'shift' => 'Siang', 'kuota_pasien' => 12, 'terisi' => 11, 'catatan' => 'Aesthetic Protocol & Peel'],

            // dr. Dimas (Saraf)
            ['doctor_id' => $doctors[9]->id, 'hari' => 'Senin', 'jam_mulai' => '07:30', 'jam_selesai' => '11:30', 'shift' => 'Pagi', 'kuota_pasien' => 14, 'terisi' => 14, 'catatan' => 'Klinik Memori & Pasca Stroke'],
            ['doctor_id' => $doctors[9]->id, 'hari' => 'Rabu', 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'shift' => 'Siang', 'kuota_pasien' => 12, 'terisi' => 8, 'catatan' => 'Manajemen Nyeri Saraf Intervensi'],
        ];

        foreach ($schedules as $s) {
            DoctorSchedule::create($s);
        }

        // 4. Data Pasien Eksekutif
        $patientsData = [
            ['no_rm' => 'RM-EK-2026-0012', 'nama_lengkap' => 'Bambang Trihatmojo, S.E., M.B.A', 'nik' => '3171012304650001', 'jenis_kelamin' => 'L', 'usia' => 58, 'no_telepon' => '0812-1002-3344', 'tipe_layanan' => 'VVIP', 'asuransi' => 'Prudential Black Card Infinite'],
            ['no_rm' => 'RM-EK-2026-0015', 'nama_lengkap' => 'Ny. Ratna Galih Hartono', 'nik' => '3172024508720002', 'jenis_kelamin' => 'P', 'usia' => 49, 'no_telepon' => '0811-9876-1234', 'tipe_layanan' => 'VVIP', 'asuransi' => 'Mandiri Inhealth Diamond VIP'],
            ['no_rm' => 'RM-EK-2026-0021', 'nama_lengkap' => 'Ananda Michelle Andrea (Anak)', 'nik' => '3173031201190003', 'jenis_kelamin' => 'P', 'usia' => 6, 'no_telepon' => '0813-8899-7711', 'tipe_layanan' => 'VIP', 'asuransi' => 'Allianz Platinum Health'],
            ['no_rm' => 'RM-EK-2026-0028', 'nama_lengkap' => 'Ir. H. Dwi Cahyono, M.T.', 'nik' => '3174042807620004', 'jenis_kelamin' => 'L', 'usia' => 62, 'no_telepon' => '0812-3344-5566', 'tipe_layanan' => 'VVIP', 'asuransi' => 'BCA Life VIP Executive'],
            ['no_rm' => 'RM-EK-2026-0033', 'nama_lengkap' => 'Clarissa Valerie Tanujaya', 'nik' => '3175051909940005', 'jenis_kelamin' => 'P', 'usia' => 29, 'no_telepon' => '0817-2233-4455', 'tipe_layanan' => 'Eksekutif Premium', 'asuransi' => 'Pribadi / Self-Pay'],
            ['no_rm' => 'RM-EK-2026-0045', 'nama_lengkap' => 'Drs. Hendriawan Sastronegoro', 'nik' => '3171060905590006', 'jenis_kelamin' => 'L', 'usia' => 65, 'no_telepon' => '0811-5566-7788', 'tipe_layanan' => 'VIP', 'asuransi' => 'AIA Premier Heritage'],
            ['no_rm' => 'RM-EK-2026-0052', 'nama_lengkap' => 'Jessica Nathania Pranata', 'nik' => '3172071403910007', 'jenis_kelamin' => 'P', 'usia' => 33, 'no_telepon' => '0812-7788-9900', 'tipe_layanan' => 'VVIP', 'asuransi' => 'AXA Mandiri Elite Care'],
            ['no_rm' => 'RM-EK-2026-0061', 'nama_lengkap' => 'Kalingga Wardhana, B.Eng', 'nik' => '3173082211870008', 'jenis_kelamin' => 'L', 'usia' => 37, 'no_telepon' => '0818-4455-6677', 'tipe_layanan' => 'VIP', 'asuransi' => 'Great Eastern Prestige'],
            ['no_rm' => 'RM-EK-2026-0067', 'nama_lengkap' => 'dr. Sarah Danubrata (Keluarga Medis)', 'nik' => '3174090506890009', 'jenis_kelamin' => 'P', 'usia' => 35, 'no_telepon' => '0813-9900-1122', 'tipe_layanan' => 'VVIP', 'asuransi' => 'Manulife MiTreasure Ultimate'],
            ['no_rm' => 'RM-EK-2026-0074', 'nama_lengkap' => 'Nicholas Gunawan', 'nik' => '3175101112980010', 'jenis_kelamin' => 'L', 'usia' => 26, 'no_telepon' => '0819-3322-1100', 'tipe_layanan' => 'Eksekutif Premium', 'asuransi' => 'Pribadi / Self-Pay'],
            ['no_rm' => 'RM-EK-2026-0083', 'nama_lengkap' => 'Hj. Siti Nurhaliza Siregar', 'nik' => '3171112908550011', 'jenis_kelamin' => 'P', 'usia' => 69, 'no_telepon' => '0812-8877-4433', 'tipe_layanan' => 'VVIP', 'asuransi' => 'Prudential Black Card Infinite'],
            ['no_rm' => 'RM-EK-2026-0091', 'nama_lengkap' => 'Farhan Alatas, S.Kom, M.M.', 'nik' => '3172121704850012', 'jenis_kelamin' => 'L', 'usia' => 39, 'no_telepon' => '0813-6655-4433', 'tipe_layanan' => 'VIP', 'asuransi' => 'Mandiri Inhealth Diamond VIP'],
            ['no_rm' => 'RM-EK-2026-0105', 'nama_lengkap' => 'Ananda Aluna Sagita (Anak)', 'nik' => '3173130409200013', 'jenis_kelamin' => 'P', 'usia' => 4, 'no_telepon' => '0811-2244-6688', 'tipe_layanan' => 'VIP', 'asuransi' => 'Allianz Platinum Health'],
            ['no_rm' => 'RM-EK-2026-0118', 'nama_lengkap' => 'Stefanus Gunardi', 'nik' => '3174141602780014', 'jenis_kelamin' => 'L', 'usia' => 46, 'no_telepon' => '0815-9988-2233', 'tipe_layanan' => 'Eksekutif Premium', 'asuransi' => 'BCA Life VIP Executive'],
            ['no_rm' => 'RM-EK-2026-0129', 'nama_lengkap' => 'drg. Maya Rosalin (Dokter Tamu)', 'nik' => '3175152810840015', 'jenis_kelamin' => 'P', 'usia' => 40, 'no_telepon' => '0812-3344-9988', 'tipe_layanan' => 'VVIP', 'asuransi' => 'Pribadi / Self-Pay'],
            ['no_rm' => 'RM-EK-2026-0137', 'nama_lengkap' => 'Reza Rahardian Suwandi', 'nik' => '3171161208920016', 'jenis_kelamin' => 'L', 'usia' => 32, 'no_telepon' => '0813-7766-3322', 'tipe_layanan' => 'VIP', 'asuransi' => 'Prudential Black Card Infinite'],
            ['no_rm' => 'RM-EK-2026-0144', 'nama_lengkap' => 'Devi Permatasari, S.H.', 'nik' => '3172172106880017', 'jenis_kelamin' => 'P', 'usia' => 36, 'no_telepon' => '0818-0099-8877', 'tipe_layanan' => 'VIP', 'asuransi' => 'AXA Mandiri Elite Care'],
            ['no_rm' => 'RM-EK-2026-0152', 'nama_lengkap' => 'K.H. Ahmad Dahlan Basri', 'nik' => '3173180301500018', 'jenis_kelamin' => 'L', 'usia' => 74, 'no_telepon' => '0811-3322-5544', 'tipe_layanan' => 'VVIP', 'asuransi' => 'Mandiri Inhealth Diamond VIP'],
        ];

        $patients = [];
        foreach ($patientsData as $p) {
            $patients[] = Patient::create($p);
        }

        // 5. Data Kunjungan Pasien Hari Ini per Poli (Patient Visits)
        $today = Carbon::today()->toDateString();

        $visits = [
            // Poli Jantung
            [
                'patient_id' => $patients[0]->id,
                'poli_id' => $polis['JTG']->id,
                'doctor_id' => $doctors[0]->id,
                'nomor_antrian' => 'EX-JTG-001',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '08:15',
                'keluhan_utama' => 'Kontrol rutin hipertensi grade 2 dan evaluasi irama jantung pasca pemasangan stent.',
                'status' => 'sedang_diperiksa',
                'tingkat_urgensi' => 'VIP Urgent',
                'tensi_darah' => '135/88',
                'suhu_tubuh' => 36.6,
                'catatan_dokter' => 'Pemeriksaan EKG menunjukkan sinus ritme stabil. Dosis ACE inhibitor disesuaikan.',
            ],
            [
                'patient_id' => $patients[3]->id,
                'poli_id' => $polis['JTG']->id,
                'doctor_id' => $doctors[0]->id,
                'nomor_antrian' => 'EX-JTG-002',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '08:45',
                'keluhan_utama' => 'Rasa sesak dan dada tertekan saat aktivitas sedang (treadmill).',
                'status' => 'menunggu',
                'tingkat_urgensi' => 'Prioritas',
                'tensi_darah' => '142/92',
                'suhu_tubuh' => 36.8,
                'catatan_dokter' => 'Menunggu antrian pemeriksaan di Executive Lounge Jantung.',
            ],
            [
                'patient_id' => $patients[10]->id,
                'poli_id' => $polis['JTG']->id,
                'doctor_id' => $doctors[0]->id,
                'nomor_antrian' => 'EX-JTG-003',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '09:30',
                'keluhan_utama' => 'Skrining kardiologi eksekutif tahunan dan uji kalsium arteri jantung.',
                'status' => 'menunggu',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '128/80',
                'suhu_tubuh' => 36.5,
                'catatan_dokter' => 'Jadwal echocardiography lanjutan pukul 10:00.',
            ],
            [
                'patient_id' => $patients[15]->id,
                'poli_id' => $polis['JTG']->id,
                'doctor_id' => $doctors[1]->id,
                'nomor_antrian' => 'EX-JTG-004',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '09:45',
                'keluhan_utama' => 'Jantung berdebar tiba-tiba di malam hari (palpitasi berkala).',
                'status' => 'selesai',
                'tingkat_urgensi' => 'Prioritas',
                'tensi_darah' => '120/78',
                'suhu_tubuh' => 36.7,
                'catatan_dokter' => 'Pemasangan Holter monitor 24 jam berhasil dilakukan. Edukasi gaya hidup.',
            ],

            // Poli Penyakit Dalam
            [
                'patient_id' => $patients[1]->id,
                'poli_id' => $polis['INT']->id,
                'doctor_id' => $doctors[2]->id,
                'nomor_antrian' => 'EX-INT-001',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '08:30',
                'keluhan_utama' => 'Nyeri lambung kronis berulang, kembung dan mual menetap selama 2 minggu.',
                'status' => 'sedang_diperiksa',
                'tingkat_urgensi' => 'Prioritas',
                'tensi_darah' => '118/75',
                'suhu_tubuh' => 36.9,
                'catatan_dokter' => 'Pemeriksaan USG abdomen atas. Rencana endoskopi gastroskopi esok pagi.',
            ],
            [
                'patient_id' => $patients[5]->id,
                'poli_id' => $polis['INT']->id,
                'doctor_id' => $doctors[2]->id,
                'nomor_antrian' => 'EX-INT-002',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '09:00',
                'keluhan_utama' => 'Evaluasi kadar HbA1c dan profil lipid kuartal 4.',
                'status' => 'farmasi',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '130/82',
                'suhu_tubuh' => 36.4,
                'catatan_dokter' => 'HbA1c membaik (6.4%). Resep obat glukosa regulator diproses ke farmasi VIP.',
            ],
            [
                'patient_id' => $patients[11]->id,
                'poli_id' => $polis['INT']->id,
                'doctor_id' => $doctors[2]->id,
                'nomor_antrian' => 'EX-INT-003',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '09:30',
                'keluhan_utama' => 'Konsultasi hasil lab fungsi ginjal dan asam urat tinggi.',
                'status' => 'menunggu',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '125/82',
                'suhu_tubuh' => 36.7,
                'catatan_dokter' => 'Pasien telah tiba di ruang tunggu privat Suite 201.',
            ],

            // Poli Anak
            [
                'patient_id' => $patients[2]->id,
                'poli_id' => $polis['ANK']->id,
                'doctor_id' => $doctors[4]->id,
                'nomor_antrian' => 'EX-ANK-001',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '09:00',
                'keluhan_utama' => 'Skrining tumbuh kembang usia 6 tahun dan imunisasi PCV booster.',
                'status' => 'sedang_diperiksa',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '95/60',
                'suhu_tubuh' => 36.6,
                'catatan_dokter' => 'Tumbuh kembang optimal di persentil 75. Vaksinasi terlaksana dengan nyaman.',
            ],
            [
                'patient_id' => $patients[12]->id,
                'poli_id' => $polis['ANK']->id,
                'doctor_id' => $doctors[4]->id,
                'nomor_antrian' => 'EX-ANK-002',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '09:30',
                'keluhan_utama' => 'Batuk alergi persisten dan pilek sensitif cuaca dingin.',
                'status' => 'menunggu',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '90/60',
                'suhu_tubuh' => 37.1,
                'catatan_dokter' => 'Bermain di Kids Luxury Zone sambil menunggu panggilan dokter.',
            ],

            // Poli Mata
            [
                'patient_id' => $patients[7]->id,
                'poli_id' => $polis['MTA']->id,
                'doctor_id' => $doctors[5]->id,
                'nomor_antrian' => 'EX-MTA-001',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '08:45',
                'keluhan_utama' => 'Konsultasi kelayakan prosedur ReLEx SMILE Pro / Femto Lasik.',
                'status' => 'selesai',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '120/80',
                'suhu_tubuh' => 36.5,
                'catatan_dokter' => 'Ketebalan kornea memenuhi syarat (545 um). Tindakan dijadwalkan pekan depan.',
            ],
            [
                'patient_id' => $patients[13]->id,
                'poli_id' => $polis['MTA']->id,
                'doctor_id' => $doctors[5]->id,
                'nomor_antrian' => 'EX-MTA-002',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '09:15',
                'keluhan_utama' => 'Mata kering akut akibat paparan layar monitor berdurasi panjang.',
                'status' => 'sedang_diperiksa',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '122/80',
                'suhu_tubuh' => 36.6,
                'catatan_dokter' => 'Pemberian tetes preservative-free dan terapi IPL kelenjar Meibom.',
            ],

            // Poli Gigi Spesialistik
            [
                'patient_id' => $patients[4]->id,
                'poli_id' => $polis['GGI']->id,
                'doctor_id' => $doctors[6]->id,
                'nomor_antrian' => 'EX-GGI-001',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '10:00',
                'keluhan_utama' => 'Pemasangan Porcelain Veneer gigi anterior rahang atas.',
                'status' => 'sedang_diperiksa',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '115/76',
                'suhu_tubuh' => 36.4,
                'catatan_dokter' => 'Shade BL2 disetujui pasien. Prosedur penempelan semen resin berjalan lancar.',
            ],
            [
                'patient_id' => $patients[9]->id,
                'poli_id' => $polis['GGI']->id,
                'doctor_id' => $doctors[6]->id,
                'nomor_antrian' => 'EX-GGI-002',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '10:45',
                'keluhan_utama' => 'Pembersihan karang gigi ultrasonik & Zoom Advanced Teeth Whitening.',
                'status' => 'menunggu',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '120/78',
                'suhu_tubuh' => 36.5,
                'catatan_dokter' => 'Menunggu di Dental Lounge Suite 401.',
            ],

            // Poli Obgyn
            [
                'patient_id' => $patients[6]->id,
                'poli_id' => $polis['OBG']->id,
                'doctor_id' => $doctors[7]->id,
                'nomor_antrian' => 'EX-OBG-001',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '08:30',
                'keluhan_utama' => 'Pemeriksaan antenatal rutin usia gestasi 28 minggu & USG 5D HD-Live.',
                'status' => 'selesai',
                'tingkat_urgensi' => 'VIP Urgent',
                'tensi_darah' => '115/70',
                'suhu_tubuh' => 36.6,
                'catatan_dokter' => 'Pertumbuhan janin sesuai kurva, cairan ketuban cukup, plasenta normal.',
            ],
            [
                'patient_id' => $patients[8]->id,
                'poli_id' => $polis['OBG']->id,
                'doctor_id' => $doctors[7]->id,
                'nomor_antrian' => 'EX-OBG-002',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '09:15',
                'keluhan_utama' => 'Skrining ginekologi preventif Pap Smear Liquid-Based & HPV DNA.',
                'status' => 'sedang_diperiksa',
                'tingkat_urgensi' => 'Prioritas',
                'tensi_darah' => '120/75',
                'suhu_tubuh' => 36.7,
                'catatan_dokter' => 'Pengambilan sampel serviks berhasil tanpa komplikasi.',
            ],
            [
                'patient_id' => $patients[16]->id,
                'poli_id' => $polis['OBG']->id,
                'doctor_id' => $doctors[7]->id,
                'nomor_antrian' => 'EX-OBG-003',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '10:00',
                'keluhan_utama' => 'Konsultasi fertilitas dan evaluasi cadangan ovarium (Anti-Mullerian Hormone).',
                'status' => 'menunggu',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '118/74',
                'suhu_tubuh' => 36.5,
                'catatan_dokter' => 'Pasien telah registrasi di konter VVIP Suite Ibu.',
            ],

            // Poli Kulit & Estetika
            [
                'patient_id' => $patients[14]->id,
                'poli_id' => $polis['KLT']->id,
                'doctor_id' => $doctors[8]->id,
                'nomor_antrian' => 'EX-KLT-001',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '11:15',
                'keluhan_utama' => 'Terapi Pico Laser untuk melasma dan stimulasi kolagen anti-aging.',
                'status' => 'sedang_diperiksa',
                'tingkat_urgensi' => 'Normal',
                'tensi_darah' => '112/72',
                'suhu_tubuh' => 36.5,
                'catatan_dokter' => 'Aplikasi anestesi topikal selesai. Sesi laser berlangsung.',
            ],

            // Poli Saraf
            [
                'patient_id' => $patients[17]->id,
                'poli_id' => $polis['SRF']->id,
                'doctor_id' => $doctors[9]->id,
                'nomor_antrian' => 'EX-SRF-001',
                'tanggal_kunjungan' => $today,
                'jam_janji' => '08:00',
                'keluhan_utama' => 'Pusing berputar hebat mendadak (Benign Paroxysmal Positional Vertigo).',
                'status' => 'selesai',
                'tingkat_urgensi' => 'VIP Urgent',
                'tensi_darah' => '138/85',
                'suhu_tubuh' => 36.8,
                'catatan_dokter' => 'Maneuver Epley berhasil dilakukan, nistagmus mereda. Resep betahistine.',
            ],
        ];

        foreach ($visits as $v) {
            PatientVisit::create($v);
        }
    }
}
