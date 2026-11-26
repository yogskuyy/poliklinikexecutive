<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Admin &amp; Pengaturan — Poliklinik Eksekutif</title>

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Pro / Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
            min-height: 100vh;
        }
        .smooth-transition {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .tab-btn.active {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px -1px rgba(79, 70, 229, 0.35);
        }
        .tab-btn:not(.active) {
            background: #ffffff;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .tab-btn:not(.active):hover {
            background: #f8fafc;
            color: #1e293b;
        }
        .toggle-checkbox:checked {
            right: 0;
            border-color: #4f46e5;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #4f46e5;
        }
    </style>
</head>
<body class="text-slate-800 antialiased font-sans selection:bg-indigo-500 selection:text-white pb-16">

    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
            
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-600 to-cyan-500 flex items-center justify-center text-white shadow-md shadow-indigo-500/20">
                    <i class="fa-solid fa-sliders text-xl"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="font-display font-extrabold text-lg sm:text-xl text-slate-900 tracking-tight">Panel Admin &amp; Pengaturan</h1>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-indigo-100 text-indigo-700 border border-indigo-200">
                            Dashboard TV
                        </span>
                    </div>
                    <p class="text-xs text-slate-500">Kelola siaran video, pengumuman running text, serta alur data poliklinik</p>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 border border-slate-200 text-xs text-slate-700 font-semibold">
                    <i class="fa-solid fa-user-shield text-indigo-600"></i>
                    <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
                </div>

                <!-- Buka Layar TV Ruang Tunggu (/tv) -->
                <a href="{{ route('tv.display') }}" target="_blank" 
                   title="Buka Siaran TV Ruang Tunggu Pasien (100vh Full Screen)"
                   class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-500/20 flex items-center gap-2 smooth-transition">
                    <i class="fa-solid fa-tv text-xs"></i>
                    <span class="hidden md:inline">Layar TV (/tv)</span>
                    <span class="md:hidden">TV</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-80"></i>
                </a>

                <!-- Buka Web Dashboard (/) -->
                <a href="{{ route('dashboard') }}" target="_blank" 
                   title="Buka Web Dashboard Utama"
                   class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 hover:text-indigo-600 font-bold text-xs shadow-xs flex items-center gap-2 smooth-transition">
                    <i class="fa-solid fa-desktop text-xs text-indigo-500"></i>
                    <span class="hidden md:inline">Web Dashboard (/)</span>
                    <span class="md:hidden">Web</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-80"></i>
                </a>

                <a href="{{ route('logout') }}" title="Logout dari Panel Admin"
                   class="w-9 h-9 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 flex items-center justify-center smooth-transition shadow-xs">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </a>
            </div>

        </div>
    </header>

    <!-- Main Admin Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">

        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="glass-card p-4 rounded-2xl shadow-xs border border-slate-200 flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Antrian Hari Ini</span>
                    <span class="text-2xl font-black text-slate-900 font-display">{{ $totalPasienHariIni }}</span>
                    <span class="text-[10px] text-emerald-600 font-semibold block">Pasien Eksekutif</span>
                </div>
            </div>

            <div class="glass-card p-4 rounded-2xl shadow-xs border border-slate-200 flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Dokter Sedang Praktek</span>
                    <span class="text-2xl font-black text-slate-900 font-display">{{ $dokterPraktekCount }} <span class="text-xs text-slate-400 font-normal">/ {{ count($doctors) }} Dr</span></span>
                    <span class="text-[10px] text-cyan-600 font-semibold block">Siaga di Suite</span>
                </div>
            </div>

            <div class="glass-card p-4 rounded-2xl shadow-xs border border-slate-200 flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl {{ ($settings['show_video'] ?? '1') == '1' ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Status Video TV</span>
                    <span class="text-sm font-black {{ ($settings['show_video'] ?? '1') == '1' ? 'text-rose-600' : 'text-slate-500' }} block mt-0.5">
                        {{ ($settings['show_video'] ?? '1') == '1' ? '● Aktif Tampil' : '○ Dinonaktifkan' }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-medium">Bisa di-toggle on/off</span>
                </div>
            </div>

            <div class="glass-card p-4 rounded-2xl shadow-xs border border-slate-200 flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl {{ ($settings['show_running_text'] ?? '1') == '1' ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Status Running Text</span>
                    <span class="text-sm font-black {{ ($settings['show_running_text'] ?? '1') == '1' ? 'text-amber-600' : 'text-slate-500' }} block mt-0.5">
                        {{ ($settings['show_running_text'] ?? '1') == '1' ? '● Aktif Bergerak' : '○ Dinonaktifkan' }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-medium">{{ count($runningTextItems) }} Teks Pengumuman</span>
                </div>
            </div>
        </div>

        <!-- Tab Navigation Bar -->
        <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2">
            <button onclick="switchTab('tab-tv')" id="btn-tab-tv" class="tab-btn active px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 smooth-transition whitespace-nowrap">
                <i class="fa-solid fa-tv text-sm"></i>
                <span>Pengaturan Tampilan TV (Video &amp; Running Text)</span>
            </button>
            <button onclick="switchTab('tab-pasien')" id="btn-tab-pasien" class="tab-btn px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 smooth-transition whitespace-nowrap">
                <i class="fa-solid fa-clipboard-user text-sm"></i>
                <span>Kelola Pasien &amp; Antrian Hari Ini</span>
            </button>
            <button onclick="switchTab('tab-dokter')" id="btn-tab-dokter" class="tab-btn px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 smooth-transition whitespace-nowrap">
                <i class="fa-solid fa-user-doctor text-sm"></i>
                <span>Status &amp; Jadwal Dokter</span>
            </button>
            <button onclick="switchTab('tab-poli')" id="btn-tab-poli" class="tab-btn px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 smooth-transition whitespace-nowrap">
                <i class="fa-solid fa-hospital text-sm"></i>
                <span>Daftar Poliklinik Eksekutif</span>
            </button>
        </div>

        <!-- ==================== TAB 1: PENGATURAN TAMPILAN TV & RUNNING TEXT ==================== -->
        <div id="tab-tv" class="tab-content space-y-6">

            <!-- Banner Info TV -->
            <div class="p-4 rounded-2xl bg-indigo-50/80 border border-indigo-200/80 text-indigo-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-tv"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">Pengaturan Khusus Layar TV Ruang Tunggu Pasien</h4>
                        <p class="text-xs text-slate-600">Semua pengaturan di tab ini langsung diterapkan pada siaran <strong>Layar TV (/tv)</strong> yang dipasang di ruang tunggu pasien.</p>
                    </div>
                </div>
                <a href="{{ route('tv.display') }}" target="_blank" class="shrink-0 px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold flex items-center justify-center gap-1.5 smooth-transition shadow-xs">
                    <i class="fa-solid fa-expand text-xs"></i>
                    <span>Buka Layar TV (/tv)</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" id="formTvSettings" class="space-y-6">
                @csrf

                <!-- Card 1: Pengaturan Video TV -->
                <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-video"></i>
                            </div>
                            <div>
                                <h3 class="font-display font-bold text-base text-slate-900">Pengaturan Siaran Video TV</h3>
                                <p class="text-xs text-slate-500">Atur apakah video ditampilkan di layar TV serta tentukan link videonya</p>
                            </div>
                        </div>

                        <!-- TOGGLE SWITCH: TAMPILKAN VIDEO -->
                        <div class="flex items-center gap-3 p-2 px-3 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="text-xs font-bold text-slate-700">Tampilkan Video di TV:</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_video" value="1" id="toggleShowVideo" 
                                       class="sr-only peer" {{ ($settings['show_video'] ?? '1') == '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-hidden rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-5 space-y-4" id="videoSettingInputs">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                                    <span>Link / URL Video:</span>
                                    <span class="text-[10px] font-extrabold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                                        <i class="fa-brands fa-youtube mr-1"></i> Mendukung YouTube &amp; MP4
                                    </span>
                                </label>
                                <input type="text" name="video_url" id="adminVideoUrl" value="{{ $settings['video_url'] ?? '' }}" 
                                       placeholder="https://www.youtube.com/watch?v=... atau https://domain.com/video.mp4"
                                       class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden font-medium text-slate-800">
                                <p class="text-[11px] text-slate-500 mt-1">Cukup copy link video YouTube apa saja dan paste di sini.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Siaran Video (Ditampilkan pada Display TV):</label>
                                <input type="text" name="video_title" id="adminVideoTitle" value="{{ $settings['video_title'] ?? '' }}" 
                                       placeholder="Edukasi Kesehatan: Gaya Hidup Sehat &amp; Profil Poliklinik"
                                       class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden font-medium text-slate-800">
                                <p class="text-[11px] text-slate-500 mt-1">Judul yang tertera di sudut kiri bawah layar siaran video.</p>
                            </div>
                        </div>

                        <!-- Contoh Cepat Video -->
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            <span class="text-[11px] text-slate-500 font-bold">Pilih Contoh:</span>
                            <button type="button" onclick="setAdminVideoPreset('https://www.youtube.com/watch?v=wXhTHyIgQ_U', 'Edukasi Pencegahan Serangan Jantung & Stroke')"
                                    class="text-[11px] font-semibold px-2.5 py-1 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg border border-rose-200 smooth-transition flex items-center gap-1.5">
                                <i class="fa-brands fa-youtube text-rose-600"></i> Contoh YouTube Jantung
                            </button>
                            <button type="button" onclick="setAdminVideoPreset('https://assets.mixkit.co/videos/preview/mixkit-doctor-checking-a-patient-in-a-hospital-room-41584-large.mp4', 'Layanan Konsultasi Dokter Spesialis VIP')"
                                    class="text-[11px] font-semibold px-2.5 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg border border-indigo-200 smooth-transition flex items-center gap-1.5">
                                <i class="fa-solid fa-file-video text-indigo-600"></i> Contoh Video MP4 HD
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Pengaturan Running Text Pengumuman -->
                <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>
                            <div>
                                <h3 class="font-display font-bold text-base text-slate-900">Pengaturan Running Text (Teks Pengumuman Berjalan)</h3>
                                <p class="text-xs text-slate-500">Ubah tulisan teks berjalan, tambahkan informasi baru, dan atur kecepatan putarnya</p>
                            </div>
                        </div>

                        <!-- TOGGLE SWITCH: TAMPILKAN RUNNING TEXT -->
                        <div class="flex items-center gap-3 p-2 px-3 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="text-xs font-bold text-slate-700">Tampilkan Running Text:</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_running_text" value="1" id="toggleShowRunningText" 
                                       class="sr-only peer" {{ ($settings['show_running_text'] ?? '1') == '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-hidden rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-5 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Label Banner Pengumuman:</label>
                                <input type="text" name="running_text_label" value="{{ $settings['running_text_label'] ?? 'PENGUMUMAN' }}" 
                                       placeholder="Contoh: PENGUMUMAN / INFORMASI PASIEN"
                                       class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-hidden font-medium text-slate-800">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kecepatan Gerak Running Text:</label>
                                <select name="running_text_speed" class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-hidden font-medium text-slate-800">
                                    <option value="90s" {{ ($settings['running_text_speed'] ?? '75s') == '90s' ? 'selected' : '' }}>Sangat Tenang / Lambat (90 detik per putaran)</option>
                                    <option value="75s" {{ ($settings['running_text_speed'] ?? '75s') == '75s' ? 'selected' : '' }}>Standar TV Display (75 detik per putaran) — Disarankan</option>
                                    <option value="60s" {{ ($settings['running_text_speed'] ?? '75s') == '60s' ? 'selected' : '' }}>Sedang (60 detik per putaran)</option>
                                    <option value="45s" {{ ($settings['running_text_speed'] ?? '75s') == '45s' ? 'selected' : '' }}>Cepat (45 detik per putaran)</option>
                                </select>
                            </div>
                        </div>

                        <!-- DAFTAR TEKS PENGUMUMAN DALAM TEXTAREA (1 BARIS = 1 PENGUMUMAN) -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-800">
                                    Isi Tulisan Teks Berjalan (Satu Baris = Satu Pesan Pengumuman):
                                </label>
                                <span class="text-[10px] text-slate-500 font-semibold">Tanda bintang dua (**teks**) membuat teks tebal</span>
                            </div>
                            
                            @php
                                $rawRunningText = "";
                                foreach ($runningTextItems as $it) {
                                    $rawRunningText .= strip_tags(str_replace(['<strong>', '</strong>'], ['**', '**'], $it['text'] ?? '')) . "\n";
                                }
                            @endphp
                            
                            <textarea name="running_text_raw" rows="6" 
                                      placeholder="Ketik pesan pengumuman di sini. Setiap baris baru akan dipisahkan dengan tanda titik (•) berulang secara mulus."
                                      class="w-full text-xs font-medium rounded-2xl border border-slate-200 p-4 focus:ring-2 focus:ring-amber-500 focus:outline-hidden text-slate-800 leading-relaxed">{{ trim($rawRunningText) }}</textarea>
                            
                            <p class="text-[11px] text-slate-500 mt-1">
                                <i class="fa-solid fa-lightbulb text-amber-500 mr-1"></i> Anda dapat mengganti, menambah, atau menghapus kalimat apa saja di atas. Sistem akan otomatis memutar pesan tersebut secara looping tanpa jeda di TV.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2.5: Pengaturan Mode 1 Layar TV & Analitik -->
                <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-chart-column"></i>
                            </div>
                            <div>
                                <h3 class="font-display font-bold text-base text-slate-900">Grafik Distribusi Pasien &amp; Tabel Bawah TV</h3>
                                <p class="text-xs text-slate-500">
                                    Aktifkan jika ingin menampilkan grafik distribusi pasien dan tabel di bawah TV. <strong>Nonaktifkan</strong> agar tampilan TV pas <strong>1 layar penuh (100vh bersih tanpa scroll)</strong>.
                                </p>
                            </div>
                        </div>

                        <!-- TOGGLE SWITCH: TAMPILKAN ANALITIK -->
                        <div class="flex items-center gap-3 p-2 px-3 rounded-2xl bg-slate-50 border border-slate-200 shrink-0">
                            <span class="text-xs font-bold text-slate-700">Tampilkan di TV:</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_analytics" value="1" id="toggleShowAnalytics" 
                                       class="sr-only peer" {{ ($settings['show_analytics'] ?? '0') == '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-hidden rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Identitas Poliklinik & Branding TV -->
                <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200">
                    <div class="flex items-center gap-3 pb-5 border-b border-slate-100">
                        <div class="w-10 h-10 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-hospital"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-base text-slate-900">Identitas Layanan &amp; Header TV</h3>
                            <p class="text-xs text-slate-500">Nama fasilitas dan judul yang tampil di pojok kiri atas dashboard</p>
                        </div>
                    </div>

                    <div class="pt-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Fasilitas:</label>
                            <input type="text" name="hospital_name" value="{{ $settings['hospital_name'] ?? 'POLIKLINIK EKSEKUTIF' }}" 
                                   class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden font-bold text-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Badge Layanan:</label>
                            <input type="text" name="hospital_badge" value="{{ $settings['hospital_badge'] ?? 'VIP SUITE' }}" 
                                   class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden font-bold text-amber-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Sub-judul / Tagline:</label>
                            <input type="text" name="hospital_subtitle" value="{{ $settings['hospital_subtitle'] ?? 'Sistem Monitoring Terintegrasi & Alur Pasien Prioritas' }}" 
                                   class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden font-medium text-slate-700">
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan Pengaturan -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs smooth-transition">
                        Batal
                    </a>
                    <button type="submit" class="px-7 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-extrabold text-xs shadow-lg shadow-indigo-500/25 flex items-center gap-2 smooth-transition">
                        <i class="fa-solid fa-floppy-disk text-sm"></i>
                        <span>Simpan Pengaturan Dashboard TV</span>
                    </button>
                </div>
            </form>

        </div>

        <!-- ==================== TAB 2: KELOLA PASIEN & ANTRIAN HARI INI ==================== -->
        <div id="tab-pasien" class="tab-content hidden space-y-6">
            
            <!-- Quick Add Patient Card -->
            <div class="glass-card rounded-3xl p-6 shadow-xs border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-base text-slate-900">Daftarkan Pasien Baru Hari Ini</h3>
                            <p class="text-xs text-slate-500">Pasien otomatis mendapatkan nomor antrian sesuai poli yang dituju</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.patients.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pasien:</label>
                        <input type="text" name="nama_pasien" required placeholder="Contoh: Bpk. Hendra Gunawan" 
                               class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Poliklinik:</label>
                        <select name="poli_id" id="selectPoliAdmin" required class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                            @foreach($polis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_poli }} ({{ $p->kode_poli }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Dokter Spesialis:</label>
                        <select name="doctor_id" required class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}">dr. {{ $d->nama_dokter }} ({{ $d->spesialisasi }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tipe Layanan:</label>
                        <select name="tipe_layanan" class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                            <option value="VVIP">VVIP Priority</option>
                            <option value="VIP" selected>VIP Suite</option>
                            <option value="Platinum">Platinum Executive</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md smooth-transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-plus"></i> Tambah Antrian
                        </button>
                    </div>
                </form>
            </div>

            <!-- Today's Queue Table -->
            <div class="glass-card rounded-3xl p-6 shadow-xs border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <h3 class="font-display font-bold text-base text-slate-900">
                        Daftar Antrian Kunjungan Pasien Hari Ini ({{ count($todayVisits) }} Pasien)
                    </h3>
                    <span class="text-xs text-slate-500">Klik tombol aksi untuk mengubah alur antrian di TV</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                <th class="pb-3 px-3">No. Antrian</th>
                                <th class="pb-3 px-3">Pasien</th>
                                <th class="pb-3 px-3">Poliklinik</th>
                                <th class="pb-3 px-3">Dokter</th>
                                <th class="pb-3 px-3">Status Saat Ini</th>
                                <th class="pb-3 px-3 text-right">Ubah Status Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($todayVisits as $v)
                            <tr class="hover:bg-slate-50/80 smooth-transition">
                                <td class="py-3 px-3 font-mono font-black text-slate-900">
                                    <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        {{ $v->no_antrian }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-bold text-slate-800">{{ $v->patient->nama ?? 'Pasien' }}</div>
                                    <span class="text-[10px] text-slate-400">{{ $v->patient->no_rm ?? '-' }} &bull; {{ $v->tipe_layanan }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="font-semibold text-slate-700">{{ $v->poli->nama_poli ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="font-medium text-slate-600">dr. {{ $v->doctor->nama_dokter ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    @if($v->status === 'sedang_diperiksa')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 border border-emerald-200 animate-pulse">
                                            ● SEDANG DIPERIKSA
                                        </span>
                                    @elseif($v->status === 'menunggu')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                            MENUNGGU DI LOUNGE
                                        </span>
                                    @elseif($v->status === 'selesai')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                            SELESAI
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-600">
                                            BATAL
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        @if($v->status !== 'sedang_diperiksa')
                                        <form action="{{ route('admin.visits.status', $v->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="sedang_diperiksa">
                                            <button type="submit" title="Panggil ke Suite Dokter" class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-bold text-[10px] hover:bg-emerald-700 smooth-transition">
                                                <i class="fa-solid fa-stethoscope"></i> Masuk Suite
                                            </button>
                                        </form>
                                        @endif

                                        @if($v->status !== 'selesai')
                                        <form action="{{ route('admin.visits.status', $v->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" title="Tandai Selesai" class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold text-[10px] hover:bg-slate-200 smooth-transition">
                                                <i class="fa-solid fa-check"></i> Selesai
                                            </button>
                                        </form>
                                        @endif

                                        @if($v->status !== 'menunggu')
                                        <form action="{{ route('admin.visits.status', $v->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="menunggu">
                                            <button type="submit" title="Kembalikan ke Menunggu" class="px-2 py-1 rounded-lg bg-amber-50 text-amber-700 font-bold text-[10px] hover:bg-amber-100 smooth-transition">
                                                Lounge
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-slate-400">Belum ada data kunjungan pasien hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- ==================== TAB 3: STATUS & JADWAL DOKTER ==================== -->
        <div id="tab-dokter" class="tab-content hidden space-y-6">
            <div class="glass-card rounded-3xl p-6 shadow-xs border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                    <div>
                        <h3 class="font-display font-bold text-base text-slate-900">Kelola Status Praktek Dokter Spesialis</h3>
                        <p class="text-xs text-slate-500">Status langsung ditampilkan pada kartu dokter di TV Display</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($doctors as $doc)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-white shadow-xs flex flex-col justify-between">
                        <div class="flex items-start gap-3.5 mb-3">
                            <img src="{{ $doc->foto }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shrink-0">
                            <div>
                                <h4 class="font-bold text-xs text-slate-900">dr. {{ $doc->nama_dokter }}</h4>
                                <p class="text-[10px] text-indigo-600 font-semibold">{{ $doc->spesialisasi }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $doc->poli->nama_poli ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status:</span>
                            <form action="{{ route('admin.doctors.status', $doc->id) }}" method="POST" class="inline">
                                @csrf
                                <select name="status_praktek" onchange="this.form.submit()" 
                                        class="text-[11px] font-bold rounded-lg border border-slate-200 px-2 py-1 focus:ring-1 focus:ring-indigo-500
                                               {{ $doc->status_praktek === 'praktek' ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : '' }}
                                               {{ $doc->status_praktek === 'istirahat' ? 'bg-amber-50 text-amber-700 border-amber-300' : '' }}
                                               {{ $doc->status_praktek === 'selesai' ? 'bg-slate-100 text-slate-600' : '' }}
                                               {{ $doc->status_praktek === 'cuti' ? 'bg-rose-50 text-rose-600 border-rose-300' : '' }}">
                                    <option value="praktek" {{ $doc->status_praktek === 'praktek' ? 'selected' : '' }}>● Praktek (On-Duty)</option>
                                    <option value="istirahat" {{ $doc->status_praktek === 'istirahat' ? 'selected' : '' }}>☕ Istirahat</option>
                                    <option value="selesai" {{ $doc->status_praktek === 'selesai' ? 'selected' : '' }}>✓ Selesai</option>
                                    <option value="cuti" {{ $doc->status_praktek === 'cuti' ? 'selected' : '' }}>✖ Cuti</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ==================== TAB 4: DAFTAR POLIKLINIK ==================== -->
        <div id="tab-poli" class="tab-content hidden space-y-6">
            <div class="glass-card rounded-3xl p-6 shadow-xs border border-slate-200">
                <div class="pb-4 border-b border-slate-100 mb-5">
                    <h3 class="font-display font-bold text-base text-slate-900">8 Unit Poliklinik Eksekutif</h3>
                    <p class="text-xs text-slate-500">Unit poli yang ditampilkan secara berputar (carousel) pada TV Display</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($polis as $poli)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-white shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 font-bold text-xs flex items-center justify-center font-mono">
                                {{ $poli->kode_poli }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                                {{ $poli->ruangan ?? 'Lantai 2' }}
                            </span>
                        </div>
                        <h4 class="font-bold text-xs text-slate-800 leading-snug">{{ $poli->nama_poli }}</h4>
                        <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>{{ $poli->doctors_count }} Dokter</span>
                            <span class="font-bold text-indigo-600">{{ $poli->visits_count }} Pasien Hari Ini</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </main>

    <script>
        // Tab switching logic
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

            const target = document.getElementById(tabId);
            if (target) {
                target.classList.remove('hidden');
            }
            const activeBtn = document.getElementById('btn-' + tabId);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }
        }

        // Quick Preset for Video in Admin
        function setAdminVideoPreset(url, title) {
            document.getElementById('adminVideoUrl').value = url;
            document.getElementById('adminVideoTitle').value = title;
        }

        // Auto toggle inputs visibility
        const toggleShowVideo = document.getElementById('toggleShowVideo');
        const videoSettingInputs = document.getElementById('videoSettingInputs');
        if (toggleShowVideo && videoSettingInputs) {
            toggleShowVideo.addEventListener('change', () => {
                if (toggleShowVideo.checked) {
                    videoSettingInputs.style.opacity = '1';
                    videoSettingInputs.style.pointerEvents = 'auto';
                } else {
                    videoSettingInputs.style.opacity = '0.5';
                }
            });
        }
    </script>
</body>
</html>
