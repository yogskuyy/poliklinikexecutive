# Dashboard Poliklinik Eksekutif (Laravel)

Sistem Dashboard Manajemen Poliklinik Eksekutif modern dengan fokus pada visual mewah, pergerakan halus (*smooth fluid motions*), palet warna cerah bergradasi (*vibrant multi-color gradients*), serta integrasi data jadwal dokter dan alur kunjungan pasien prioritas per poliklinik.

---

## 🌟 Fitur Utama

1. **Jadwal Dokter Eksekutif**:
   - Pemetaan jadwal dokter spesialis & konsultan berdasarkan hari (Senin - Sabtu), shift (Pagi, Siang, Sore), dan jam praktek.
   - Indikator kapasitas dan kuota pasien terisi secara *real-time*.
   - Toggle status siaga dokter langsung dari dashboard (*Sedang Praktek*, *Istirahat*, *Selesai*).
   - Profil dokter dilengkapi foto beresolusi tinggi, nomor STR, sub-spesialisasi, rating pasien, dan nomor ruang suite eksekutif.

2. **Data Pasien per Poli (Prioritas & Real-Time)**:
   - Filter instan per Poli melalui tombol kategori interaktif dengan animasi gradien.
   - Tabel alur pelayanan: Nomor Antrian VIP (`EX-JTG-001`, dsb.), Identitas Pasien, Nomor Rekam Medis (RM), Dokter Pemeriksa, Jam Janji, Tanda Vital (Tensi & Suhu Tubuh), serta Penjamin/Asuransi (*Prudential Black Card, Mandiri Inhealth Diamond, Allianz Platinum, Self-Pay*).
   - Pengubah status alur instan: *Menunggu Antrian* ➔ *Sedang Diperiksa* ➔ *Farmasi VIP* ➔ *Selesai Konsultasi*.
   - Fitur pencarian cepat (*live search debounced*) berdasarkan Nama, Nomor RM, atau Nomor Antrian.
   - Modal detail rekam medis pasien dengan riwayat keluhan dan catatan medis dokter.

3. **Statistik & Visual Analytics**:
   - 4 Kartu KPI Eksekutif dengan animasi perhitungan angka (*smooth counter*):
     - Total Kunjungan Pasien Hari Ini (+ perbandingan kemarin)
     - Pasien Sedang Konsultasi Dokter (dengan indikator detak *pulsing*)
     - Pasien Menunggu di Executive Lounge
     - Dokter Spesialis Siaga Praktek
   - Grafik Interaktif Distribusi Pasien per Poliklinik (Chart.js dengan gradien warna cerah).
   - Grafik Donat Komposisi Status Pelayanan Pasien Hari Ini.

4. **Desain & Animasi Modern**:
   - Tipografi elegan: **Plus Jakarta Sans** & **Outfit**.
   - *Ambient Gradient Mesh Background* untuk efek luminous dan mewah.
   - Transisi *Cubic-Bezier Spring* (`cubic-bezier(0.16, 1, 0.3, 1)`) pada *hover*, *tab switching*, dan *modal dialog*.
   - Modal pendaftaran pasien eksekutif dengan validasi instan dan feedback notifikasi *floating toast*.

---

## 🏥 Daftar 8 Poliklinik Eksekutif

1. **Poli Jantung & Pembuluh Darah Eksekutif** (Kode: `JTG`) - Gradien Merah/Rose
2. **Poli Penyakit Dalam VIP** (Kode: `INT`) - Gradien Royal Indigo/Violet
3. **Poli Anak & Tumbuh Kembang Eksekutif** (Kode: `ANK`) - Gradien Emerald/Cyan
4. **Poli Mata & Bedah Refraktif** (Kode: `MTA`) - Gradien Sky/Blue
5. **Poli Gigi & Mulut Spesialistik** (Kode: `GGI`) - Gradien Amber/Orange
6. **Poli Kebidanan & Kandungan (Fetomaternal)** (Kode: `OBG`) - Gradien Fuchsia/Pink
7. **Poli Kulit & Estetika Medis Eksekutif** (Kode: `KLT`) - Gradien Purple/Violet
8. **Poli Saraf & Neurologi Intervensi** (Kode: `SRF`) - Gradien Electric Blue

---

## 🚀 Cara Menjalankan Aplikasi

Aplikasi telah dikonfigurasi menggunakan SQLite sehingga siap dijalankan tanpa perlu konfigurasi database server tambahan:

```bash
# 1. Masuk ke direktori proyek
cd d:\poliklinikexecutive

# 2. Jalankan server Laravel (jika belum berjalan)
php artisan serve --port=8000
```

Buka peramban (browser) Anda di:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 📁 Struktur Direktori Penting

- [app/Http/Controllers/DashboardController.php](file:///d:/poliklinikexecutive/app/Http/Controllers/DashboardController.php) - Controller logika dashboard, filtering, statistik & API.
- [resources/views/dashboard.blade.php](file:///d:/poliklinikexecutive/resources/views/dashboard.blade.php) - Antarmuka Blade interaktif, styling Tailwind, Chart.js, animasi & modal.
- [app/Models/](file:///d:/poliklinikexecutive/app/Models/) - Model Eloquent (`Poli`, `Doctor`, `DoctorSchedule`, `Patient`, `PatientVisit`).
- [database/migrations/](file:///d:/poliklinikexecutive/database/migrations/) - Skema tabel database.
- [database/seeders/PoliklinikSeeder.php](file:///d:/poliklinikexecutive/database/seeders/PoliklinikSeeder.php) - Data contoh realistis dokter, jadwal, dan pasien eksekutif.
