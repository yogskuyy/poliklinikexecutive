<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DashboardSetting;

class DashboardSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaultRunningTexts = [
            [
                'id' => 1,
                'icon' => 'fa-solid fa-crown',
                'color' => 'text-amber-400',
                'text' => '<strong>Selamat Datang di Poliklinik Eksekutif VIP Suite.</strong> Pelayanan medis prioritas dengan kenyamanan premium.'
            ],
            [
                'id' => 2,
                'icon' => 'fa-solid fa-bell',
                'color' => 'text-cyan-400',
                'text' => 'Pasien prioritas harap memperhatikan panggilan nomor antrian pada layar display & pengumuman suara perawat.'
            ],
            [
                'id' => 3,
                'icon' => 'fa-solid fa-mug-hot',
                'color' => 'text-emerald-400',
                'text' => 'Minuman selamat datang dan hidangan ringan tersedia gratis di Executive Lounge Lantai 2.'
            ],
            [
                'id' => 4,
                'icon' => 'fa-solid fa-prescription-bottle-medical',
                'color' => 'text-rose-400',
                'text' => 'Fasilitas Pengambilan Obat & Farmasi Prioritas dapat diakses tepat di samping Lounge Suite.'
            ],
            [
                'id' => 5,
                'icon' => 'fa-solid fa-handshake-angle',
                'color' => 'text-indigo-400',
                'text' => 'Untuk bantuan pendampingan khusus atau kursi roda, silakan hubungi staf Hospitality Desk kami.'
            ],
        ];

        $settings = [
            'show_video' => '1',
            'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-doctor-checking-a-patient-in-a-hospital-room-41584-large.mp4',
            'video_title' => 'Edukasi Kesehatan: Gaya Hidup Sehat & Pencegahan Penyakit Jantung',
            'show_running_text' => '1',
            'running_text_label' => 'PENGUMUMAN',
            'running_text_speed' => '75s',
            'running_text_items' => $defaultRunningTexts,
            'hospital_name' => 'POLIKLINIK EKSEKUTIF',
            'hospital_subtitle' => 'Sistem Monitoring Terintegrasi & Alur Pasien Prioritas',
            'hospital_badge' => 'VIP SUITE',
            'auto_refresh_seconds' => '30',
            'show_analytics' => '0',
        ];

        foreach ($settings as $key => $val) {
            DashboardSetting::set($key, $val, 'display');
        }
    }
}
