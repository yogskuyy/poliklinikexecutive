<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Executive Clinic Hub - Poliklinik Eksekutif</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS with custom configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        executive: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            900: '#4c1d95',
                        }
                    },
                    boxShadow: {
                        'glow-primary': '0 10px 30px -5px rgba(99, 102, 241, 0.35)',
                        'glow-emerald': '0 10px 30px -5px rgba(16, 185, 129, 0.35)',
                        'glow-rose': '0 10px 30px -5px rgba(244, 63, 94, 0.35)',
                        'glow-amber': '0 10px 30px -5px rgba(245, 158, 11, 0.35)',
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
                    }
                }
            }
        }
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Modern Smooth Easing & Micro-animations */
        * {
            scroll-behavior: smooth;
        }

        body {
            background-color: #f8fafc;
            color: #0f172a;
            overflow-x: hidden;
        }

        /* Ambient Glow Mesh */
        .ambient-mesh {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 0;
            background: 
                radial-gradient(circle at 10% 15%, rgba(99, 102, 241, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 85% 20%, rgba(236, 72, 153, 0.08) 0%, transparent 45%),
                radial-gradient(circle at 50% 80%, rgba(6, 182, 212, 0.07) 0%, transparent 50%),
                radial-gradient(circle at 90% 90%, rgba(139, 92, 246, 0.08) 0%, transparent 40%);
        }

        /* Glassmorphism Card Style */
        .glass-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 35px -5px rgba(15, 23, 42, 0.04), 0 2px 8px -1px rgba(15, 23, 42, 0.02);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -8px rgba(99, 102, 241, 0.12), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
            border-color: rgba(165, 180, 252, 0.5);
        }

        /* Smooth Fluid Transitions */
        .smooth-transition {
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .poli-pill {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .poli-pill:hover {
            transform: translateY(-2px) scale(1.02);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animated Pulse Ring */
        @keyframes subtlePulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.9;
            }
            50% {
                transform: scale(1.15);
                opacity: 0.4;
            }
        }
        .pulse-live {
            animation: subtlePulse 2s infinite ease-in-out;
        }

        /* Gradient Text Helper */
        .gradient-text-indigo {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-text-amber {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Modal Animation */
        .modal-enter {
            opacity: 0;
            transform: scale(0.95) translateY(10px);
        }
        .modal-enter-active {
            opacity: 1;
            transform: scale(1) translateY(0);
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Running Text Seamless Infinite Loop (Slow & Calm for TV Display) */
        @keyframes seamlessMarquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        .marquee-track {
            display: flex;
            width: max-content;
            animation: seamlessMarquee 58s linear infinite;
            will-change: transform;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }

        /* Carousel Card Styling (Zero clipping & exact fitting) */
        .poli-carousel-card {
            box-sizing: border-box;
            flex-shrink: 0;
            overflow: hidden;
            word-break: break-word;
        }
    </style>
</head>
<body class="min-h-screen overflow-y-auto pb-16 flex flex-col font-sans antialiased bg-slate-50 relative selection:bg-indigo-500 selection:text-white">

    <!-- Ambient Mesh Gradient Background -->
    <div class="ambient-mesh"></div>

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-200/80 shadow-xs shrink-0 h-18 sm:h-20 flex items-center">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 2xl:px-12">
            <div class="flex items-center justify-between">
                
                <!-- Logo & Brand Title -->
                <div class="flex items-center gap-2.5 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-glow-primary p-0.5 shrink-0"
                         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);">
                        <div class="w-full h-full bg-white rounded-[10px] sm:rounded-[14px] flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-hospital-user text-lg sm:text-2xl" style="background: linear-gradient(135deg, #4f46e5, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-base sm:text-xl lg:text-2xl font-display font-extrabold tracking-tight text-slate-900 leading-tight">
                            {{ $settings['hospital_name'] ?? 'POLIKLINIK EKSEKUTIF' }}
                        </h1>
                        <p class="hidden sm:block text-xs text-slate-500 font-medium">{{ $settings['hospital_subtitle'] ?? 'Sistem Monitoring Terintegrasi & Alur Pasien Prioritas' }}</p>
                    </div>
                </div>

                <!-- Center: Live Clock & Date Display -->
                <div class="hidden md:flex items-center gap-3 px-4 py-2 rounded-2xl bg-slate-100/80 border border-slate-200/60 shadow-inner">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-xs">
                        <i class="fa-regular fa-clock text-sm"></i>
                    </div>
                    <div>
                        <div id="liveClock" class="text-sm font-bold text-slate-800 tracking-wider">00:00:00 WIB</div>
                        <div id="liveDate" class="text-[11px] text-slate-500 font-medium">Memuat tanggal...</div>
                    </div>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-2.5">
                    <!-- Tombol Buka Layar TV Ruang Tunggu (/tv) -->
                    <a href="{{ route('tv.display') }}" target="_blank" 
                       title="Buka Siaran Khusus Layar TV Ruang Tunggu Pasien (100vh Full Screen)"
                       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold text-xs shadow-md shadow-indigo-500/20 smooth-transition">
                        <i class="fa-solid fa-tv text-xs"></i>
                        <span class="hidden sm:inline">Layar TV Ruang Tunggu</span>
                        <span class="sm:hidden">Layar TV</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-80"></i>
                    </a>

                    <!-- Refresh Button -->
                    <button onclick="window.location.reload();" 
                            title="Segarkan Data Display"
                            class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50/50 flex items-center justify-center smooth-transition shadow-xs">
                        <i class="fa-solid fa-rotate text-sm"></i>
                    </button>

                    @guest
                    <!-- Jika Belum Login -->
                    <a href="{{ route('login') }}" 
                       title="Portal Login Petugas & Admin"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50/50 text-xs font-semibold smooth-transition shadow-xs">
                        <i class="fa-solid fa-lock text-[11px]"></i>
                        <span>Login Admin / Petugas</span>
                    </a>
                    @endguest

                    @auth
                    <!-- Jika Sudah Login -->
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.index') }}" 
                       title="Buka Panel Pengaturan Admin"
                       class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white smooth-transition shadow-md shadow-indigo-500/20 text-xs font-bold">
                        <i class="fa-solid fa-sliders text-xs"></i>
                        <span>Panel Admin</span>
                    </a>
                    @else
                    <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold">
                        <i class="fa-solid fa-user text-slate-400"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    @endif

                    <!-- Tombol Tambah Pasien untuk Petugas & Admin -->
                    <button onclick="openRegisterModal()" 
                            class="group relative inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-white font-semibold text-xs shadow-glow-primary overflow-hidden smooth-transition hover:shadow-indigo-500/40 hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);">
                        <span class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
                        <i class="fa-solid fa-user-plus text-xs relative z-10"></i>
                        <span class="relative z-10 hidden sm:inline">Daftar Pasien</span>
                        <span class="relative z-10 sm:hidden">+</span>
                    </button>

                    <!-- Tombol Keluar (Logout) -->
                    <a href="{{ route('logout') }}" title="Keluar / Logout ({{ Auth::user()->name }})" 
                       class="w-10 h-10 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 flex items-center justify-center smooth-transition shadow-xs">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container: Tampilan Web Dashboard Operasional Lengkap -->
    <main class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 2xl:px-12 py-5 sm:py-6 relative z-10 flex-1">

        <!-- Section 1: 4 KPI Cards (Responsive 1-Col Mobile, 2-Col Tablet, 4-Col Desktop Grid) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-5 mb-6">
            
            <!-- KPI 1: Total Pasien -->
            <div class="glass-card p-5 sm:p-6 rounded-3xl relative overflow-hidden group flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Kunjungan Hari Ini</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-glow-primary"
                         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                        <i class="fa-solid fa-users text-lg"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl sm:text-4xl font-display font-black text-slate-900 counter" data-target="{{ $totalPasienHariIni }}">{{ $totalPasienHariIni }}</span>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">+14% vs kemarin</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Layanan VVIP, VIP &amp; Platinum</p>
                </div>
            </div>

            <!-- KPI 2: Diperiksa -->
            <div class="glass-card p-5 sm:p-6 rounded-3xl relative overflow-hidden group flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Sedang Konsultasi Dokter</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white relative shadow-xs"
                         style="background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);">
                        <i class="fa-solid fa-user-doctor text-lg"></i>
                        <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-cyan-500 border-2 border-white"></span>
                        </span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl sm:text-4xl font-display font-black text-slate-900 counter" data-target="{{ $pasienSedangDiperiksa }}">{{ $pasienSedangDiperiksa }}</span>
                        <span class="text-xs font-bold text-cyan-700 bg-cyan-50 px-2 py-0.5 rounded-full border border-cyan-200">Aktif di Suite</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Waktu rata-rata 18.5 mnt/pasien</p>
                </div>
            </div>

            <!-- KPI 3: Menunggu -->
            <div class="glass-card p-5 sm:p-6 rounded-3xl relative overflow-hidden group flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Menunggu di Lounge</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-glow-amber"
                         style="background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);">
                        <i class="fa-solid fa-mug-hot text-lg"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl sm:text-4xl font-display font-black text-slate-900 counter" data-target="{{ $pasienMenunggu }}">{{ $pasienMenunggu }}</span>
                        <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">Executive Lounge</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Estimasi tunggu &lt; 10 menit</p>
                </div>
            </div>

            <!-- KPI 4: Dokter Aktif -->
            <div class="glass-card p-5 sm:p-6 rounded-3xl relative overflow-hidden group flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Dokter Aktif Praktek</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-glow-emerald"
                         style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fa-solid fa-hospital-user text-lg"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl sm:text-4xl font-display font-black text-slate-900 counter" data-target="{{ $dokterPraktekCount }}">{{ $dokterPraktekCount }}</span>
                        <span class="text-xs font-semibold text-slate-500">dari {{ $totalDokter }} Dokter Eksekutif</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 font-medium text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check text-[10px] mr-1"></i> 100% On-Duty Tepat Waktu</p>
                </div>
            </div>

        </div>

        <!-- Section 2: Pilih Poliklinik Spesialis Eksekutif (8 Poli Aktif Full Grid Seperti Gambar 1) -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3.5">
                <div class="flex items-center gap-2.5">
                    <h3 class="text-base sm:text-lg font-display font-extrabold text-slate-900">
                        Pilih Poliklinik Spesialis Eksekutif
                    </h3>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                        {{ $polis->count() }} Poli Aktif
                    </span>
                </div>
                <button onclick="filterByPoli('all')" 
                        id="btnResetPoli"
                        class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-white hover:bg-indigo-50 px-3.5 py-2 rounded-xl border border-slate-200 hover:border-indigo-300 smooth-transition flex items-center gap-1.5 shadow-xs">
                    <i class="fa-solid fa-list-ul text-xs"></i>
                    <span>Tampilkan Semua Poli</span>
                </button>
            </div>
            <p class="text-xs text-slate-500 mb-4 -mt-2">Klik salah satu poli di bawah untuk menyaring data pasien dan jadwal dokter secara langsung</p>

            <!-- 8 Poli Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-3.5">
                @foreach($polis as $poli)
                    <div onclick="filterByPoli('{{ $poli->id }}', this)" 
                         data-poli-id="{{ $poli->id }}"
                         class="poli-pill cursor-pointer p-3.5 xl:p-4 rounded-3xl glass-card flex flex-col items-center justify-between text-center relative border border-slate-200/80 hover:border-indigo-400 group select-none min-h-[160px] {{ $selectedPoliId == $poli->id ? 'ring-2 ring-indigo-500 bg-indigo-50/40 shadow-glow-primary' : '' }}">
                        
                        <!-- Gradient Icon Circle -->
                        <div class="w-12 h-12 xl:w-14 xl:h-14 rounded-2xl flex items-center justify-center text-white text-xl xl:text-2xl mb-2 shadow-xs group-hover:scale-110 smooth-transition shrink-0"
                             style="background: {{ $poli->warna_gradien }};">
                            <i class="fa-solid {{ $poli->icon }}"></i>
                        </div>

                        <!-- Poli Code & Name -->
                        <div class="w-full px-1 overflow-hidden">
                            <span class="text-xs xl:text-sm font-black text-slate-900 group-hover:text-indigo-600 block">
                                {{ $poli->kode_poli }}
                            </span>
                            <span class="text-[11px] xl:text-xs text-slate-500 line-clamp-2 leading-tight mt-1 font-semibold block min-h-[28px]">
                                {{ str_replace('Poli ', '', $poli->nama_poli) }}
                            </span>
                        </div>

                        <!-- Visitor Badge -->
                        <div class="mt-2 text-xs font-bold px-3 py-1 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200/60 group-hover:bg-indigo-100 group-hover:border-indigo-300 smooth-transition shrink-0">
                            <i class="fa-solid fa-users text-[10px] mr-1 text-indigo-500"></i>{{ $poli->visits_count }} Pasien
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section 3: Dual Interactive Visual Analytics (Distribution & Trend) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 mt-6">
            
            <!-- Left Chart: Distribusi Pasien Per Poli (Bar Chart) -->
            <div class="lg:col-span-2 glass-card p-6 rounded-3xl">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-display font-bold text-slate-900 text-base flex items-center gap-2">
                            <i class="fa-solid fa-chart-column text-indigo-500"></i>
                            Distribusi Pasien Hari Ini per Poliklinik
                        </h3>
                        <p class="text-xs text-slate-500">Alokasi beban kunjungan dokter spesialis di unit eksekutif</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                        Live Metrics
                    </span>
                </div>
                <div class="h-64 relative">
                    <canvas id="poliDistributionChart"></canvas>
                </div>
            </div>

            <!-- Right Chart: Status Kunjungan Pasien (Doughnut Chart) -->
            <div class="glass-card p-6 rounded-3xl">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-display font-bold text-slate-900 text-base flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-rose-500"></i>
                            Status Pasien Hari Ini
                        </h3>
                        <p class="text-xs text-slate-500">Progres alur pelayanan eksekutif</p>
                    </div>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700">Realtime</span>
                </div>
                <div class="h-52 relative flex items-center justify-center">
                    <canvas id="statusDoughnutChart"></canvas>
                </div>
                <!-- Mini Legends -->
                <div class="grid grid-cols-2 gap-2 mt-4 pt-3 border-t border-slate-100 text-xs">
                    <div class="flex items-center gap-2 text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-indigo-500"></span> Diperiksa: <strong>{{ $pasienSedangDiperiksa }}</strong>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span> Menunggu: <strong>{{ $pasienMenunggu }}</strong>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Selesai: <strong>{{ $pasienSelesai }}</strong>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-cyan-500"></span> Farmasi: <strong>{{ $totalPasienHariIni - $pasienSedangDiperiksa - $pasienMenunggu - $pasienSelesai }}</strong>
                    </div>
                </div>
            </div>

        </div>

        <!-- Section 4: Main Navigation Tabs (Data Pasien vs Jadwal Dokter) -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-4">
                
                <!-- View Switcher Tabs -->
                <div class="flex items-center gap-2 bg-slate-100/90 p-1.5 rounded-2xl border border-slate-200">
                    <button onclick="switchTab('patients')" 
                            id="tabBtnPatients"
                            class="px-5 py-2.5 rounded-xl font-semibold text-sm smooth-transition flex items-center gap-2 bg-white text-indigo-600 shadow-xs">
                        <i class="fa-solid fa-bed-pulse"></i>
                        <span>Data Pasien per Poli</span>
                        <span id="tabBadgePatients" class="px-2 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-700 font-bold">
                            {{ $visits->count() }}
                        </span>
                    </button>
                    <button onclick="switchTab('schedules')" 
                            id="tabBtnSchedules"
                            class="px-5 py-2.5 rounded-xl font-semibold text-sm smooth-transition flex items-center gap-2 text-slate-600 hover:text-slate-900">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Jadwal Dokter Eksekutif</span>
                        <span class="px-2 py-0.5 rounded-full text-xs bg-slate-200 text-slate-700 font-bold">
                            {{ $schedules->count() }} Sesi
                        </span>
                    </button>
                </div>

                <!-- Right Tooling (Search & Day Filter) -->
                <div class="flex items-center gap-3">
                    <!-- Live Search Input -->
                    <div class="relative w-full sm:w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" 
                               id="patientSearchInput"
                               placeholder="Cari Nama / No RM / Antrian..." 
                               class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-white/90 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent smooth-transition">
                    </div>

                    <!-- Filter Status Dropdown -->
                    <select id="statusFilterSelect" onchange="filterVisitsByStatus(this.value)"
                            class="text-xs rounded-xl border border-slate-200 bg-white/90 py-2 px-3 text-slate-700 font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-hidden smooth-transition">
                        <option value="all">Semua Status</option>
                        <option value="sedang_diperiksa">Sedang Diperiksa</option>
                        <option value="menunggu">Menunggu Antrian</option>
                        <option value="farmasi">Pengambilan Obat</option>
                        <option value="selesai">Selesai Konsultasi</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- ==================== TAB 1: DATA PASIEN PER POLI ==================== -->
        <div id="tabContentPatients" class="smooth-transition">
            
            <!-- Table Card Container -->
            <div class="glass-card rounded-3xl overflow-hidden shadow-xs">
                
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-white/50">
                    <div>
                        <h3 class="font-display font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>Daftar Pasien Eksekutif Hari Ini</span>
                            <span id="activePoliTitle" class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">
                                Semua Poli Eksekutif
                            </span>
                        </h3>
                        <p class="text-xs text-slate-500">Alur pelayanan rawat jalan VIP dengan sistem antrian prioritas real-time</p>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-indigo-500 animate-pulse"></span> Sedang Diperiksa</span>
                        <span class="inline-flex items-center gap-1.5 ml-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Menunggu</span>
                        <span class="inline-flex items-center gap-1.5 ml-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Selesai</span>
                    </div>
                </div>

                <!-- Patient Responsive Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/70 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                <th class="py-3.5 px-5">No. Antrian</th>
                                <th class="py-3.5 px-4">Data Pasien</th>
                                <th class="py-3.5 px-4">Poli Tujuan</th>
                                <th class="py-3.5 px-4">Dokter Spesialis</th>
                                <th class="py-3.5 px-4">Jam Janji & Vital</th>
                                <th class="py-3.5 px-4">Layanan / Asuransi</th>
                                <th class="py-3.5 px-4">Status Layanan</th>
                                <th class="py-3.5 px-5 text-right">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody id="patientTableBody" class="divide-y divide-slate-100 text-xs">
                            @forelse($visits as $visit)
                                @php
                                    $badge = $visit->status_badge;
                                    $initials = strtoupper(substr($visit->patient->nama_lengkap, 0, 2));
                                @endphp
                                <tr class="hover:bg-indigo-50/30 smooth-transition patient-row" 
                                    data-poli-id="{{ $visit->poli_id }}"
                                    data-status="{{ $visit->status }}"
                                    data-id="{{ $visit->id }}">
                                    
                                    <!-- No. Antrian -->
                                    <td class="py-4 px-5 whitespace-nowrap">
                                        <div class="inline-flex items-center px-3 py-1.5 rounded-xl font-display font-extrabold text-sm text-white shadow-xs"
                                             style="background: {{ $visit->poli->warna_gradien ?? 'linear-gradient(135deg, #4f46e5, #7c3aed)' }};">
                                            {{ $visit->nomor_antrian }}
                                        </div>
                                    </td>

                                    <!-- Patient Data -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-xs text-indigo-700 bg-indigo-100 border border-indigo-200 shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 text-sm patient-name hover:text-indigo-600 smooth-transition">
                                                    {{ $visit->patient->nama_lengkap }}
                                                </div>
                                                <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                                    <span class="patient-rm font-mono text-slate-600 font-semibold">{{ $visit->patient->no_rm }}</span>
                                                    <span>•</span>
                                                    <span>{{ $visit->patient->usia }} thn ({{ $visit->patient->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }})</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Poli Tujuan -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl text-xs font-semibold {{ $visit->poli->warna_badge }}">
                                            <i class="fa-solid {{ $visit->poli->icon }}"></i>
                                            <span>{{ $visit->poli->nama_poli }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">
                                            {{ $visit->poli->lokasi_ruangan }}
                                        </div>
                                    </td>

                                    <!-- Dokter Pemeriksa -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            <img src="{{ $visit->doctor->foto_url ?? 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=100' }}" 
                                                 alt="{{ $visit->doctor->nama_lengkap }}" 
                                                 class="w-8 h-8 rounded-full object-cover border border-slate-200">
                                            <div>
                                                <div class="font-semibold text-slate-800 line-clamp-1">
                                                    {{ $visit->doctor->nama_lengkap }}
                                                </div>
                                                <div class="text-[10px] text-indigo-600 font-medium">
                                                    {{ $visit->doctor->ruang_praktek }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Jam Janji & Tanda Vital -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock text-slate-400 text-xs"></i>
                                            {{ substr($visit->jam_janji, 0, 5) }} WIB
                                        </div>
                                        <div class="text-[10px] text-slate-500 mt-0.5 flex items-center gap-1.5">
                                            <span title="Tekanan Darah"><i class="fa-solid fa-heart-pulse text-rose-500"></i> {{ $visit->tensi_darah ?? '-' }}</span>
                                            <span>•</span>
                                            <span title="Suhu Tubuh"><i class="fa-solid fa-temperature-half text-amber-500"></i> {{ $visit->suhu_tubuh ?? '-' }}°C</span>
                                        </div>
                                    </td>

                                    <!-- Layanan & Asuransi -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold 
                                            {{ $visit->patient->tipe_layanan == 'VVIP' ? 'bg-gradient-to-r from-amber-500 to-rose-500 text-white shadow-xs' : 'bg-purple-100 text-purple-700' }}">
                                            <i class="fa-solid fa-crown text-[9px]"></i> {{ $visit->patient->tipe_layanan }}
                                        </div>
                                        <div class="text-[11px] font-medium text-slate-600 mt-1 line-clamp-1" title="{{ $visit->patient->asuransi }}">
                                            {{ $visit->patient->asuransi }}
                                        </div>
                                    </td>

                                    <!-- Status Layanan -->
                                    <td class="py-4 px-4 whitespace-nowrap status-cell">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $badge['bg'] }}">
                                            <span class="w-2 h-2 rounded-full {{ $badge['dot'] }}"></span>
                                            <span class="status-label">{{ $badge['label'] }}</span>
                                        </span>
                                    </td>

                                    <!-- Aksi Cepat (Status Switcher Dropdown) -->
                                    <td class="py-4 px-5 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1.5">
                                            @if($visit->status == 'menunggu')
                                                <button onclick="updateVisitStatus({{ $visit->id }}, 'sedang_diperiksa')" 
                                                        class="px-2.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-xs smooth-transition flex items-center gap-1">
                                                    <i class="fa-solid fa-stethoscope"></i> Mulai Periksa
                                                </button>
                                            @elseif($visit->status == 'sedang_diperiksa')
                                                <button onclick="updateVisitStatus({{ $visit->id }}, 'farmasi')" 
                                                        class="px-2.5 py-1.5 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white font-semibold text-xs shadow-xs smooth-transition flex items-center gap-1">
                                                    <i class="fa-solid fa-prescription-bottle-medical"></i> Ke Farmasi
                                                </button>
                                                <button onclick="updateVisitStatus({{ $visit->id }}, 'selesai')" 
                                                        class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-xs smooth-transition flex items-center gap-1">
                                                    <i class="fa-solid fa-check"></i> Selesai
                                                </button>
                                            @elseif($visit->status == 'farmasi')
                                                <button onclick="updateVisitStatus({{ $visit->id }}, 'selesai')" 
                                                        class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-xs smooth-transition flex items-center gap-1">
                                                    <i class="fa-solid fa-check-double"></i> Serahkan Obat
                                                </button>
                                            @else
                                                <span class="text-xs text-slate-400 font-medium">
                                                    <i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Tuntas
                                                </span>
                                            @endif

                                            <!-- Dropdown Options for Other Statuses -->
                                            <div class="relative inline-block text-left">
                                                <button onclick="toggleRowMenu('menu-{{ $visit->id }}')" 
                                                        class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center smooth-transition">
                                                    <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                                </button>
                                                <div id="menu-{{ $visit->id }}" 
                                                     class="hidden absolute right-0 mt-2 w-44 rounded-2xl bg-white shadow-xl border border-slate-100 py-1.5 z-50 text-left smooth-transition">
                                                    <div class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Ubah Status Alur</div>
                                                    <button onclick="updateVisitStatus({{ $visit->id }}, 'menunggu'); hideRowMenus();" class="w-full px-3 py-1.5 text-xs text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Set: Menunggu
                                                    </button>
                                                    <button onclick="updateVisitStatus({{ $visit->id }}, 'sedang_diperiksa'); hideRowMenus();" class="w-full px-3 py-1.5 text-xs text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Set: Sedang Diperiksa
                                                    </button>
                                                    <button onclick="updateVisitStatus({{ $visit->id }}, 'farmasi'); hideRowMenus();" class="w-full px-3 py-1.5 text-xs text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span> Set: Farmasi VIP
                                                    </button>
                                                    <button onclick="updateVisitStatus({{ $visit->id }}, 'selesai'); hideRowMenus();" class="w-full px-3 py-1.5 text-xs text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Set: Selesai
                                                    </button>
                                                    <div class="border-t border-slate-100 my-1"></div>
                                                    <button onclick="showPatientDetailModal('{{ $visit->patient->nama_lengkap }}', '{{ $visit->patient->no_rm }}', '{{ $visit->nomor_antrian }}', '{{ $visit->poli->nama_poli }}', '{{ $visit->doctor->nama_lengkap }}', '{{ $visit->keluhan_utama }}', '{{ $visit->catatan_dokter }}'); hideRowMenus();" 
                                                            class="w-full px-3 py-1.5 text-xs text-indigo-600 hover:bg-indigo-50 flex items-center gap-2 font-medium">
                                                        <i class="fa-regular fa-id-card"></i> Lihat Detail Rekam Medis
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-12 text-slate-400">
                                        <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-400 text-2xl">
                                            <i class="fa-solid fa-calendar-xmark"></i>
                                        </div>
                                        <p class="font-bold text-slate-700 text-sm">Tidak ada data pasien untuk kriteria filter ini</p>
                                        <p class="text-xs text-slate-400 mt-1">Pilih poli lain atau klik "Daftar Pasien Eksekutif" untuk menambah antrian baru</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Summary -->
                <div class="p-4 bg-slate-50/60 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div>
                        Menampilkan <span id="visiblePatientCount" class="font-bold text-slate-800">{{ $visits->count() }}</span> pasien terdaftar
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                        <span>Privasi Data Pasien Terproteksi Enkripsi Standar Medis Internasional</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- ==================== TAB 2: JADWAL DOKTER EKSEKUTIF ==================== -->
        <div id="tabContentSchedules" class="hidden smooth-transition">
            
            <!-- Day Filter Pills -->
            <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-6">
                <span class="text-xs font-bold text-slate-500 mr-2 shrink-0"><i class="fa-solid fa-calendar-days text-indigo-500 mr-1"></i> Pilih Hari:</span>
                <button onclick="filterScheduleByDay('Semua', this)" 
                        class="schedule-day-pill px-4 py-2 rounded-xl text-xs font-semibold smooth-transition shrink-0 {{ $selectedDay == 'Semua' ? 'bg-indigo-600 text-white shadow-glow-primary' : 'bg-white text-slate-700 border border-slate-200 hover:border-indigo-300' }}">
                    Semua Hari
                </button>
                @foreach($daysOfWeek as $day)
                    <button onclick="filterScheduleByDay('{{ $day }}', this)" 
                            class="schedule-day-pill px-4 py-2 rounded-xl text-xs font-semibold smooth-transition shrink-0 {{ $selectedDay == $day ? 'bg-indigo-600 text-white shadow-glow-primary' : 'bg-white text-slate-700 border border-slate-200 hover:border-indigo-300' }}">
                        {{ $day }}
                    </button>
                @endforeach
            </div>

            <!-- Doctor Schedules Grid -->
            <div id="doctorSchedulesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($schedules as $sched)
                    <div class="glass-card rounded-3xl p-6 relative overflow-hidden schedule-card"
                         data-poli-id="{{ $sched->doctor->poli_id }}"
                         data-day="{{ $sched->hari }}">
                        
                        <!-- Top Accent Banner -->
                        <div class="h-1.5 absolute top-0 left-0 right-0"
                             style="background: {{ $sched->doctor->poli->warna_gradien ?? 'linear-gradient(135deg, #4f46e5, #7c3aed)' }};"></div>

                        <!-- Doctor Header -->
                        <div class="flex items-start gap-4 mb-4">
                            <div class="relative shrink-0">
                                <img src="{{ $sched->doctor->foto_url ?? 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=100' }}" 
                                     alt="{{ $sched->doctor->nama_lengkap }}" 
                                     class="w-14 h-14 rounded-2xl object-cover border-2 border-white shadow-xs">
                                
                                <!-- Doctor Online/Live Badge -->
                                <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white 
                                    {{ $sched->doctor->status_praktek == 'praktek' ? 'bg-emerald-500' : ($sched->doctor->status_praktek == 'istirahat' ? 'bg-amber-500' : 'bg-slate-400') }}"
                                    title="Status: {{ $sched->doctor->status_label }}"></span>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $sched->doctor->poli->warna_badge }}">
                                        {{ $sched->doctor->poli->kode_poli }}
                                    </span>
                                    <span class="text-xs font-bold text-amber-500 flex items-center gap-1">
                                        <i class="fa-solid fa-star text-[10px]"></i> {{ $sched->doctor->rating }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm mt-1 leading-snug line-clamp-1" title="{{ $sched->doctor->nama_lengkap }}">
                                    {{ $sched->doctor->nama_lengkap }}
                                </h4>
                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                                    {{ $sched->doctor->spesialisasi }}
                                </p>
                            </div>
                        </div>

                        <!-- Schedule Badge Detail -->
                        <div class="p-3.5 rounded-2xl bg-slate-50/90 border border-slate-100 mb-4">
                            <div class="flex items-center justify-between text-xs mb-2">
                                <span class="font-bold text-indigo-700 flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar-check"></i> {{ $sched->hari }} (Shift {{ $sched->shift }})
                                </span>
                                <span class="font-extrabold text-slate-800">
                                    {{ substr($sched->jam_mulai, 0, 5) }} - {{ substr($sched->jam_selesai, 0, 5) }} WIB
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-500">
                                <span><i class="fa-solid fa-door-open text-slate-400 mr-1"></i> {{ $sched->doctor->ruang_praktek }}</span>
                                <span><i class="fa-solid fa-briefcase-medical text-slate-400 mr-1"></i> {{ $sched->doctor->pengalaman_tahun }} Th Pengalaman</span>
                            </div>
                        </div>

                        <!-- Quota Progress Bar -->
                        <div class="mb-4">
                            @php
                                $percent = min(100, round(($sched->terisi / max(1, $sched->kuota_pasien)) * 100));
                            @endphp
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="text-slate-500 font-medium">Kapasitas Pasien Terisi</span>
                                <span class="font-bold text-slate-800">{{ $sched->terisi }} / {{ $sched->kuota_pasien }} Pasien</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full smooth-transition" 
                                     style="width: {{ $percent }}%; background: {{ $percent >= 90 ? 'linear-gradient(90deg, #f59e0b, #ef4444)' : 'linear-gradient(90deg, #4f46e5, #06b6d4)' }};"></div>
                            </div>
                        </div>

                        <!-- Footer: Live Status & Interactive Status Toggle -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="text-xs">
                                <span class="text-[10px] text-slate-400 uppercase font-semibold block">Status Dokter</span>
                                <span class="font-bold text-slate-800 flex items-center gap-1.5 mt-0.5">
                                    <span class="w-2 h-2 rounded-full {{ $sched->doctor->status_praktek == 'praktek' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span id="docStatusLabel-{{ $sched->doctor->id }}">{{ $sched->doctor->status_label }}</span>
                                </span>
                            </div>

                            <!-- Doctor Status Action -->
                            <div class="flex items-center gap-1">
                                <button onclick="toggleDoctorStatus({{ $sched->doctor->id }}, 'praktek')" 
                                        title="Ubah Status: Praktek"
                                        class="px-2 py-1 rounded-lg text-[11px] font-semibold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 smooth-transition">
                                    Praktek
                                </button>
                                <button onclick="toggleDoctorStatus({{ $sched->doctor->id }}, 'istirahat')" 
                                        title="Ubah Status: Istirahat"
                                        class="px-2 py-1 rounded-lg text-[11px] font-semibold bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 smooth-transition">
                                    Istirahat
                                </button>
                                <button onclick="toggleDoctorStatus({{ $sched->doctor->id }}, 'selesai')" 
                                        title="Ubah Status: Selesai"
                                        class="px-2 py-1 rounded-lg text-[11px] font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 smooth-transition">
                                    Selesai
                                </button>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-400">
                        <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-slate-300"></i>
                        <p class="font-bold text-slate-700">Tidak ada jadwal dokter untuk hari dan poli yang dipilih</p>
                    </div>
                @endforelse
            </div>

        </div>
        

    </main>

    <!-- ==================== MODAL 1: REGISTRASI PASIEN BARU EKSEKUTIF ==================== -->
    <div id="registerModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <!-- Backdrop Blur -->
        <div onclick="closeRegisterModal()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md smooth-transition"></div>

        <!-- Modal Dialog Box -->
        <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-10 modal-enter smooth-transition">
            
            <!-- Modal Header with Bright Gradient -->
            <div class="px-6 py-5 text-white flex items-center justify-between"
                 style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                        <i class="fa-solid fa-hospital-user text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-lg">Pendaftaran Pasien Eksekutif Prioritas</h3>
                        <p class="text-xs text-white/80">Input data pasien VIP untuk diterbitkan nomor antrian instan</p>
                    </div>
                </div>
                <button onclick="closeRegisterModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center smooth-transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Form Body -->
            <form id="registerPatientForm" onsubmit="handleRegisterSubmit(event)" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- Nama Lengkap -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Pasien <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" required 
                               placeholder="Contoh: Ir. Muhammad Fauzan, M.B.A" 
                               class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" name="nik" maxlength="16"
                               placeholder="16 Digit NIK KTP" 
                               class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp / HP <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_telepon" required
                               placeholder="0812-xxxx-xxxx" 
                               class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    </div>

                    <!-- Usia & Gender -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Usia (Tahun) <span class="text-rose-500">*</span></label>
                        <input type="number" name="usia" required min="0" max="120"
                               placeholder="Contoh: 45" 
                               class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" required class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <!-- Tipe Layanan & Asuransi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Klasifikasi Layanan Eksekutif <span class="text-rose-500">*</span></label>
                        <select name="tipe_layanan" required class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden font-semibold text-indigo-700">
                            <option value="VVIP">👑 VVIP Suite</option>
                            <option value="VIP" selected>⭐ VIP Executive</option>
                            <option value="Eksekutif Premium">✨ Eksekutif Premium</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Penjamin / Asuransi <span class="text-rose-500">*</span></label>
                        <select name="asuransi" required class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                            <option value="Prudential Black Card Infinite">Prudential Black Card Infinite</option>
                            <option value="Mandiri Inhealth Diamond VIP">Mandiri Inhealth Diamond VIP</option>
                            <option value="Allianz Platinum Health">Allianz Platinum Health</option>
                            <option value="BCA Life VIP Executive">BCA Life VIP Executive</option>
                            <option value="AXA Mandiri Elite Care">AXA Mandiri Elite Care</option>
                            <option value="Pribadi / Self-Pay">Pribadi / Self-Pay</option>
                        </select>
                    </div>

                    <!-- Poli Pilihan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Poli Tujuan Eksekutif <span class="text-rose-500">*</span></label>
                        <select name="poli_id" id="modalPoliSelect" onchange="updateModalDoctorOptions(this.value)" required 
                                class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                            @foreach($polis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dokter Pemeriksa -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Dokter Spesialis <span class="text-rose-500">*</span></label>
                        <select name="doctor_id" id="modalDoctorSelect" required 
                                class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" data-poli="{{ $d->poli_id }}">{{ $d->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jam Janji & Urgensi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jam Janji Konsultasi <span class="text-rose-500">*</span></label>
                        <input type="time" name="jam_janji" value="{{ date('H:i') }}" required
                               class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden font-bold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Urgensi <span class="text-rose-500">*</span></label>
                        <select name="tingkat_urgensi" required class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                            <option value="Normal">Normal Terjadwal</option>
                            <option value="Prioritas">Prioritas Segera</option>
                            <option value="VIP Urgent">VIP Urgent (Prioritas Utama)</option>
                        </select>
                    </div>

                    <!-- Tanda Vital -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tekanan Darah (mmHg)</label>
                        <input type="text" name="tensi_darah" value="120/80" placeholder="Contoh: 120/80" 
                               class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Suhu Tubuh (°C)</label>
                        <input type="number" step="0.1" name="suhu_tubuh" value="36.5" placeholder="Contoh: 36.5" 
                               class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    </div>

                    <!-- Keluhan Utama -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Keluhan Utama / Alasan Kunjungan <span class="text-rose-500">*</span></label>
                        <textarea name="keluhan_utama" rows="2" required 
                                  placeholder="Tuliskan keluhan atau tujuan konsultasi pasien eksekutif..." 
                                  class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden"></textarea>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeRegisterModal()" 
                            class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50 smooth-transition">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitPatient"
                            class="px-6 py-2.5 rounded-xl text-white font-semibold text-xs shadow-glow-primary smooth-transition flex items-center gap-2 hover:opacity-90"
                            style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);">
                        <i class="fa-solid fa-check"></i>
                        <span>Terbitkan Nomor Antrian VVIP</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- ==================== MODAL 2: DETAIL PASIEN & REKAM MEDIS ==================== -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div onclick="closeDetailModal()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md smooth-transition"></div>
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-10 modal-enter smooth-transition">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <span id="detailQueueBadge" class="px-3 py-1 rounded-xl text-xs font-extrabold text-white bg-indigo-600">EX-JTG-001</span>
                        <span class="text-xs text-slate-500 font-semibold" id="detailRm">RM-EK-2026-0000</span>
                    </div>
                    <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                
                <h3 id="detailPatientName" class="text-lg font-bold text-slate-900">Nama Pasien</h3>
                <p id="detailPoliAndDoctor" class="text-xs text-indigo-600 font-semibold mt-0.5">Poli • Dokter</p>

                <div class="my-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <h5 class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Keluhan Pasien:</h5>
                    <p id="detailKeluhan" class="text-xs text-slate-700 leading-relaxed">-</p>
                </div>

                <div class="my-4 p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100">
                    <h5 class="text-[11px] font-bold uppercase tracking-wider text-indigo-700 mb-1">Catatan Medis Dokter:</h5>
                    <p id="detailCatatan" class="text-xs text-indigo-900 leading-relaxed">-</p>
                </div>

                <div class="pt-3 border-t border-slate-100 text-right">
                    <button onclick="closeDetailModal()" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold text-xs hover:bg-slate-200 smooth-transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL 3: PENGATURAN VIDEO SIARAN TV ==================== -->
    <div id="videoModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div onclick="closeVideoModal()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md smooth-transition"></div>
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-10 modal-enter smooth-transition">
            <div class="px-6 py-5 text-white flex items-center justify-between"
                 style="background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #4f46e5 100%);">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                        <i class="fa-solid fa-tv text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-lg">Pengaturan Siaran Video TV</h3>
                        <p class="text-xs text-white/80">Pilih konten siaran untuk ruang tunggu pasien eksekutif</p>
                    </div>
                </div>
                <button onclick="closeVideoModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center smooth-transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[85vh] overflow-y-auto">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Pilihan Video Siaran (Preset Siap Pakai):</label>
                    <div class="space-y-2">
                        <div onclick="selectPresetVideo('https://www.youtube.com/watch?v=wXhTHyIgQ_U', 'Edukasi Kesehatan Jantung & Pencegahan Penyakit Kardiovaskular')" 
                             class="p-3 rounded-2xl border border-rose-200 bg-rose-50/50 hover:bg-rose-50 cursor-pointer smooth-transition flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                                    <i class="fa-brands fa-youtube text-base"></i>
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-800 group-hover:text-rose-600 smooth-transition">Edukasi Jantung & Kardiovaskular</h5>
                                    <p class="text-[10px] text-slate-500">Tips hidup sehat, nutrisi, & pencegahan serangan jantung (YouTube)</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-rose-600 bg-white px-2.5 py-1 rounded-full border border-rose-200 shadow-xs">Pilih</span>
                        </div>

                        <div onclick="selectPresetVideo('https://assets.mixkit.co/videos/preview/mixkit-doctor-checking-a-patient-in-a-hospital-room-41584-large.mp4', 'Edukasi Kesehatan: Konsultasi Pasien & Profil Dokter Spesialis')" 
                             class="p-3 rounded-2xl border border-indigo-200 bg-indigo-50/50 hover:bg-indigo-50 cursor-pointer smooth-transition flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                    <i class="fa-solid fa-user-doctor text-sm"></i>
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-800 group-hover:text-indigo-600 smooth-transition">Edukasi Dokter & Konsultasi Pasien</h5>
                                    <p class="text-[10px] text-slate-500">Video ramah pasien suasana konsultasi profesional (MP4 HD)</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-indigo-600 bg-white px-2.5 py-1 rounded-full border border-indigo-100 shadow-xs">Pilih</span>
                        </div>

                        <div onclick="selectPresetVideo('https://assets.mixkit.co/videos/preview/mixkit-hands-of-a-doctor-with-a-stethoscope-41586-large.mp4', 'Pemeriksaan Kardiologi & Panduan Menjaga Jantung Sehat')" 
                             class="p-3 rounded-2xl border border-slate-200 hover:border-amber-300 hover:bg-slate-50 cursor-pointer smooth-transition flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                    <i class="fa-solid fa-heart-pulse text-sm"></i>
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-800 group-hover:text-amber-600 smooth-transition">Pemeriksaan Kardiologi & Stetoskop</h5>
                                    <p class="text-[10px] text-slate-500">Video tips pencegahan hipertensi dan gaya hidup (MP4 HD)</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">Pilih</span>
                        </div>

                        <div onclick="selectPresetVideo('https://assets.mixkit.co/videos/preview/mixkit-a-nurse-prepares-a-medical-syringe-41587-large.mp4', 'Fasilitas Farmasi Terpadu & Laboratorium Eksekutif VIP')" 
                             class="p-3 rounded-2xl border border-slate-200 hover:border-cyan-300 hover:bg-slate-50 cursor-pointer smooth-transition flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center">
                                    <i class="fa-solid fa-flask-vial text-sm"></i>
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-800 group-hover:text-cyan-600 smooth-transition">Laboratorium & Layanan Farmasi Cepat</h5>
                                    <p class="text-[10px] text-slate-500">Alur obat prioritas tanpa antri lama (MP4 HD)</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">Pilih</span>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-800">Tempelkan Link Video Anda:</label>
                        <span class="text-[10px] font-extrabold text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-full border border-rose-200 flex items-center gap-1">
                            <i class="fa-brands fa-youtube"></i> Mendukung YouTube & MP4
                        </span>
                    </div>

                    <div class="relative">
                        <input type="text" id="customVideoUrlInput" 
                               placeholder="Tempel link YouTube (contoh: https://www.youtube.com/watch?v=... atau https://youtu.be/...)" 
                               class="w-full text-xs rounded-xl border border-slate-200 pl-9 pr-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-slate-700 font-medium">
                        <i class="fa-solid fa-link absolute left-3 top-3 text-slate-400 text-xs"></i>
                    </div>

                    <div class="relative mt-2">
                        <input type="text" id="customVideoTitleInput" 
                               placeholder="Judul Siaran Video (contoh: Profil Poliklinik Eksekutif RS)" 
                               class="w-full text-xs rounded-xl border border-slate-200 pl-9 pr-3.5 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-slate-700 font-medium">
                        <i class="fa-solid fa-heading absolute left-3 top-3 text-slate-400 text-xs"></i>
                    </div>

                    <!-- Quick Try Examples -->
                    <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                        <span class="text-[10px] text-slate-500 font-bold">Coba Contoh:</span>
                        <button type="button" onclick="fillExampleVideo('https://www.youtube.com/watch?v=wXhTHyIgQ_U', 'Edukasi Pencegahan Serangan Jantung & Stroke')" 
                                class="text-[10px] font-semibold px-2.5 py-1 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg border border-rose-200 smooth-transition flex items-center gap-1">
                            <i class="fa-brands fa-youtube text-rose-600"></i> Contoh YouTube
                        </button>
                        <button type="button" onclick="fillExampleVideo('https://assets.mixkit.co/videos/preview/mixkit-doctor-checking-a-patient-in-a-hospital-room-41584-large.mp4', 'Layanan Konsultasi Dokter Spesialis VIP')" 
                                class="text-[10px] font-semibold px-2.5 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg border border-indigo-200 smooth-transition flex items-center gap-1">
                            <i class="fa-solid fa-file-video text-indigo-600"></i> Contoh File MP4
                        </button>
                    </div>

                    <!-- Guidance Info -->
                    <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-2.5 text-slate-600">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-xs shrink-0"></i>
                        <p class="text-[11px] leading-relaxed">
                            Cukup <strong>Copy & Paste link YouTube</strong> (link biasa, link pendek <code class="bg-slate-200 px-1 rounded text-[10px]">youtu.be</code>, atau Shorts). Video akan otomatis berputar berulang (loop) dan tersimpan secara otomatis di TV.
                        </p>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeVideoModal()" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold text-xs hover:bg-slate-200 smooth-transition">
                        Tutup
                    </button>
                    <button type="button" onclick="applyCustomVideo()" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold text-xs shadow-md hover:bg-indigo-700 smooth-transition flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Terapkan Siaran
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== TOAST NOTIFICATION CONTAINER ==================== -->
    <div id="toastContainer" class="fixed top-24 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- JAVASCRIPT LOGIC & INTERACTIONS -->
    <script>
        // Setup CSRF token for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Realtime Clock & Indonesian Date
        function updateLiveClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('liveClock').textContent = `${hours}:${minutes}:${seconds} WIB`;

            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('liveDate').textContent = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateLiveClock, 1000);
        updateLiveClock();

        // ==================== TV BROADCAST VIDEO CONTROLS ====================
        const broadcastVideo = document.getElementById('tvBroadcastVideo');
        const broadcastIframe = document.getElementById('tvBroadcastIframe');

        // Extract video ID & type from YouTube, Vimeo, or HTML5 MP4/Stream
        function extractVideoSource(rawInput) {
            if (!rawInput) return null;
            let url = rawInput.trim();

            // Extract src if user pasted iframe HTML tag
            const iframeMatch = url.match(/src=["']([^"']+)["']/i);
            if (iframeMatch) {
                url = iframeMatch[1];
            }

            // YouTube Regex: supports watch?v=, youtu.be/, /embed/, /shorts/, /live/
            const ytRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts|live)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
            const ytMatch = url.match(ytRegex);

            if (ytMatch && ytMatch[1]) {
                const videoId = ytMatch[1];
                return {
                    type: 'youtube',
                    id: videoId,
                    embedUrl: `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&mute=1&loop=1&playlist=${videoId}&controls=1&rel=0&modestbranding=1`,
                    rawUrl: url
                };
            }

            // Vimeo Regex
            const vimeoRegex = /(?:vimeo\.com\/)(\d+)/i;
            const vimeoMatch = url.match(vimeoRegex);
            if (vimeoMatch && vimeoMatch[1]) {
                const videoId = vimeoMatch[1];
                return {
                    type: 'vimeo',
                    id: videoId,
                    embedUrl: `https://player.vimeo.com/video/${videoId}?autoplay=1&loop=1&muted=1&autopause=0`,
                    rawUrl: url
                };
            }

            // Standard HTML5 video file (.mp4, .webm, stream)
            return {
                type: 'html5',
                embedUrl: url,
                rawUrl: url
            };
        }

        // Set broadcast video source seamlessly
        function setTvVideoSource(url, title, saveToStorage = true) {
            const videoInfo = extractVideoSource(url);
            if (!videoInfo) return;

            const videoEl = document.getElementById('tvBroadcastVideo');
            const iframeEl = document.getElementById('tvBroadcastIframe');
            const titleEl = document.getElementById('videoTitleDisplay');

            const finalTitle = title || (videoInfo.type === 'youtube' ? 'Siaran Edukasi YouTube Eksekutif' : 'Siaran Video TV Eksekutif');
            if (titleEl) {
                titleEl.textContent = finalTitle;
            }

            if (videoInfo.type === 'youtube' || videoInfo.type === 'vimeo') {
                // Pause and hide HTML5 video
                if (videoEl) {
                    try { videoEl.pause(); } catch(e){}
                    videoEl.classList.add('hidden');
                }
                // Show iframe with embed
                if (iframeEl) {
                    iframeEl.classList.remove('hidden');
                    iframeEl.src = videoInfo.embedUrl;
                }
                showToast('Siaran Aktif', `Siaran ${videoInfo.type === 'youtube' ? 'YouTube' : 'Vimeo'} berhasil dimuat!`, 'success');
            } else {
                // Hide iframe
                if (iframeEl) {
                    iframeEl.classList.add('hidden');
                    iframeEl.src = '';
                }
                // Show and load HTML5 video
                if (videoEl) {
                    videoEl.classList.remove('hidden');
                    videoEl.src = videoInfo.embedUrl;
                    videoEl.load();
                    videoEl.play().catch(err => {
                        console.warn('Playback error:', err);
                    });
                }
                showToast('Siaran Aktif', 'File video berhasil diputar!', 'success');
            }

            if (saveToStorage) {
                try {
                    localStorage.setItem('executive_tv_video_url', url);
                    localStorage.setItem('executive_tv_video_title', finalTitle);
                } catch(e) {}
            }
        }

        function toggleVideoAudio() {
            const iframeEl = document.getElementById('tvBroadcastIframe');
            if (iframeEl && !iframeEl.classList.contains('hidden')) {
                showToast('Kontrol Audio YouTube', 'Gunakan kontrol volume di dalam pemutar YouTube.', 'info');
                return;
            }

            if (!broadcastVideo) return;
            broadcastVideo.muted = !broadcastVideo.muted;
            const icon = document.getElementById('audioIcon');
            if (broadcastVideo.muted) {
                icon.className = 'fa-solid fa-volume-xmark';
                showToast('Audio TV', 'Suara siaran dinonaktifkan (Muted)', 'info');
            } else {
                icon.className = 'fa-solid fa-volume-high text-cyan-400';
                broadcastVideo.volume = 0.8;
                showToast('Audio TV', 'Suara siaran diaktifkan', 'success');
            }
        }

        function toggleVideoPlay() {
            const iframeEl = document.getElementById('tvBroadcastIframe');
            if (iframeEl && !iframeEl.classList.contains('hidden')) {
                showToast('Kontrol Putar YouTube', 'Klik langsung pada layar video YouTube untuk jeda/putar.', 'info');
                return;
            }

            if (!broadcastVideo) return;
            const icon = document.getElementById('playIcon');
            if (broadcastVideo.paused) {
                broadcastVideo.play();
                icon.className = 'fa-solid fa-pause';
                showToast('Siaran TV', 'Siaran diputar', 'info');
            } else {
                broadcastVideo.pause();
                icon.className = 'fa-solid fa-play text-amber-400';
                showToast('Siaran TV', 'Siaran dijeda', 'info');
            }
        }

        function toggleVideoFullscreen() {
            const container = document.getElementById('tvBroadcastContainer') || broadcastVideo;
            if (!container) return;
            if (!document.fullscreenElement) {
                if (container.requestFullscreen) {
                    container.requestFullscreen();
                } else if (container.webkitRequestFullscreen) {
                    container.webkitRequestFullscreen();
                } else if (container.msRequestFullscreen) {
                    container.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        function openVideoModal() {
            const modal = document.getElementById('videoModal');
            try {
                const savedUrl = localStorage.getItem('executive_tv_video_url');
                const savedTitle = localStorage.getItem('executive_tv_video_title');
                if (savedUrl && !document.getElementById('customVideoUrlInput').value) {
                    document.getElementById('customVideoUrlInput').value = savedUrl;
                }
                if (savedTitle && !document.getElementById('customVideoTitleInput').value) {
                    document.getElementById('customVideoTitleInput').value = savedTitle;
                }
            } catch(e) {}

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.modal-enter').classList.add('modal-enter-active');
            }, 10);
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            modal.querySelector('.modal-enter').classList.remove('modal-enter-active');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 250);
        }

        function selectPresetVideo(url, title) {
            setTvVideoSource(url, title, true);
            closeVideoModal();
        }

        function fillExampleVideo(url, title) {
            document.getElementById('customVideoUrlInput').value = url;
            document.getElementById('customVideoTitleInput').value = title;
        }

        function applyCustomVideo() {
            const urlInput = document.getElementById('customVideoUrlInput').value.trim();
            const titleInput = document.getElementById('customVideoTitleInput').value.trim();
            if (!urlInput) {
                showToast('Peringatan', 'Silakan masukkan link video terlebih dahulu', 'error');
                return;
            }
            setTvVideoSource(urlInput, titleInput || 'Siaran Kustom Poliklinik Eksekutif', true);
            closeVideoModal();
        }

        if (broadcastVideo) {
            broadcastVideo.addEventListener('error', function() {
                console.warn('Video failed to load.');
            });
        }

        // ==================== AUTO-ROTATING POLI CAROUSEL ====================
        let currentCarouselIndex = 0;
        let carouselIntervalTimer = null;

        function getCarouselVisibleCount() {
            const viewport = document.getElementById('poliCarouselViewport');
            if (!viewport) return 3;
            const w = viewport.clientWidth;
            if (w >= 780) return 4;
            if (w >= 520) return 3;
            return 2;
        }

        function updateCardWidths() {
            const viewport = document.getElementById('poliCarouselViewport');
            const track = document.getElementById('poliCarouselTrack');
            if (!viewport || !track || !track.children.length) return;

            const visibleCount = getCarouselVisibleCount();
            const gap = 16; // 16px gap (gap-4)
            // Available width inside viewport with 4px safety breathing margin
            const availableWidth = viewport.clientWidth - 4;
            const cardWidth = Math.floor((availableWidth - (visibleCount - 1) * gap) / visibleCount);

            Array.from(track.children).forEach(card => {
                card.style.width = `${cardWidth}px`;
                card.style.minWidth = `${cardWidth}px`;
                card.style.maxWidth = `${cardWidth}px`;
            });

            slideCarousel('current');
            updateCarouselDots();
        }

        function updateCarouselDots() {
            const dotsContainer = document.getElementById('carouselDots');
            const track = document.getElementById('poliCarouselTrack');
            if (!dotsContainer || !track) return;
            
            const totalCards = track.children.length;
            const visibleCount = getCarouselVisibleCount();
            const totalSteps = Math.max(1, totalCards - visibleCount + 1);

            let dotsHtml = '';
            for (let i = 0; i < totalSteps; i++) {
                const isActive = (i === currentCarouselIndex);
                dotsHtml += `<button onclick="goToCarouselSlide(${i})" class="h-1.5 rounded-full smooth-transition ${isActive ? 'w-6 bg-indigo-600' : 'w-2 bg-slate-200 hover:bg-slate-300'}" title="Poli Slide ${i + 1}"></button>`;
            }
            dotsContainer.innerHTML = dotsHtml;
        }

        function slideCarousel(direction = 'next') {
            const track = document.getElementById('poliCarouselTrack');
            const viewport = document.getElementById('poliCarouselViewport');
            if (!track || !track.children.length || !viewport) return;

            const totalCards = track.children.length;
            const visibleCount = getCarouselVisibleCount();
            const maxIndex = Math.max(0, totalCards - visibleCount);

            if (direction === 'next') {
                currentCarouselIndex = (currentCarouselIndex >= maxIndex) ? 0 : currentCarouselIndex + 1;
            } else if (direction === 'prev') {
                currentCarouselIndex = (currentCarouselIndex <= 0) ? maxIndex : currentCarouselIndex - 1;
            } else if (direction === 'current') {
                if (currentCarouselIndex > maxIndex) currentCarouselIndex = maxIndex;
            }

            const card = track.children[0];
            const gap = 16;
            const cardWidth = card.offsetWidth;
            const offset = currentCarouselIndex * (cardWidth + gap);

            track.style.transform = `translateX(-${offset}px)`;
            updateCarouselDots();
        }

        function goToCarouselSlide(index) {
            currentCarouselIndex = index;
            slideCarousel('current');
        }

        function pauseCarousel() {
            if (carouselIntervalTimer) {
                clearInterval(carouselIntervalTimer);
                carouselIntervalTimer = null;
            }
        }

        function resumeCarousel() {
            pauseCarousel();
            carouselIntervalTimer = setInterval(() => {
                slideCarousel('next');
            }, 3800); // 3.8s auto-rotation
        }

        // Start auto-carousel and update widths on load and resize
        window.addEventListener('load', () => {
            // Restore TV broadcast video from admin server settings or persistent localStorage
            try {
                const serverUrl = @json($settings['video_url'] ?? '');
                const serverTitle = @json($settings['video_title'] ?? '');
                const savedUrl = localStorage.getItem('executive_tv_video_url');
                const savedTitle = localStorage.getItem('executive_tv_video_title');

                const finalUrl = serverUrl || savedUrl;
                const finalTitle = serverTitle || savedTitle;
                if (finalUrl) {
                    setTvVideoSource(finalUrl, finalTitle, false);
                }
            } catch(e) {}

            updateCardWidths();
            resumeCarousel();
        });

        if (window.ResizeObserver) {
            const ro = new ResizeObserver(() => {
                updateCardWidths();
            });
            const vp = document.getElementById('poliCarouselViewport');
            if (vp) ro.observe(vp);
        } else {
            window.addEventListener('resize', updateCardWidths);
        }
        setTimeout(updateCardWidths, 80);

        // Counter Animation on Load
        document.querySelectorAll('.counter').forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const speed = 25; // ms
            const increment = Math.max(1, Math.ceil(target / 15));
            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    counter.textContent = target;
                    clearInterval(timer);
                } else {
                    counter.textContent = count;
                }
            }, speed);
        });

        // Tab Switching Logic (Pasien vs Jadwal)
        function switchTab(tab) {
            const btnPatients = document.getElementById('tabBtnPatients');
            const btnSchedules = document.getElementById('tabBtnSchedules');
            const contentPatients = document.getElementById('tabContentPatients');
            const contentSchedules = document.getElementById('tabContentSchedules');

            if (tab === 'patients') {
                btnPatients.className = "px-5 py-2.5 rounded-xl font-semibold text-sm smooth-transition flex items-center gap-2 bg-white text-indigo-600 shadow-xs";
                btnSchedules.className = "px-5 py-2.5 rounded-xl font-semibold text-sm smooth-transition flex items-center gap-2 text-slate-600 hover:text-slate-900";
                contentPatients.classList.remove('hidden');
                contentSchedules.classList.add('hidden');
            } else {
                btnSchedules.className = "px-5 py-2.5 rounded-xl font-semibold text-sm smooth-transition flex items-center gap-2 bg-white text-indigo-600 shadow-xs";
                btnPatients.className = "px-5 py-2.5 rounded-xl font-semibold text-sm smooth-transition flex items-center gap-2 text-slate-600 hover:text-slate-900";
                contentSchedules.classList.remove('hidden');
                contentPatients.classList.add('hidden');
            }
        }

        // Filter by Poli (Cards Filter)
        let activePoliId = 'all';

        function filterByPoli(poliId, element = null) {
            activePoliId = poliId;

            // Highlight active poli pill
            document.querySelectorAll('.poli-pill').forEach(pill => {
                pill.classList.remove('ring-2', 'ring-indigo-500', 'bg-indigo-50/40', 'shadow-glow-primary');
            });

            if (element) {
                element.classList.add('ring-2', 'ring-indigo-500', 'bg-indigo-50/40', 'shadow-glow-primary');
                const poliName = element.querySelector('span:nth-child(2)').textContent.trim();
                document.getElementById('activePoliTitle').textContent = 'Poli ' + poliName;
            } else {
                document.getElementById('activePoliTitle').textContent = 'Semua Poli Eksekutif';
            }

            applyFilters();
        }

        // Filter Schedule by Day
        function filterScheduleByDay(day, element) {
            document.querySelectorAll('.schedule-day-pill').forEach(btn => {
                btn.className = "schedule-day-pill px-4 py-2 rounded-xl text-xs font-semibold smooth-transition shrink-0 bg-white text-slate-700 border border-slate-200 hover:border-indigo-300";
            });
            element.className = "schedule-day-pill px-4 py-2 rounded-xl text-xs font-semibold smooth-transition shrink-0 bg-indigo-600 text-white shadow-glow-primary";

            const cards = document.querySelectorAll('.schedule-card');
            cards.forEach(card => {
                const cardDay = card.getAttribute('data-day');
                const cardPoliId = card.getAttribute('data-poli-id');

                const matchDay = (day === 'Semua' || cardDay === day);
                const matchPoli = (activePoliId === 'all' || cardPoliId === activePoliId);

                if (matchDay && matchPoli) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Live Patient Search with Instant Debounce
        const searchInput = document.getElementById('patientSearchInput');
        searchInput.addEventListener('input', () => {
            applyFilters();
        });

        // Filter by Status dropdown
        function filterVisitsByStatus(status) {
            applyFilters();
        }

        // Apply All Filter criteria together
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const statusFilter = document.getElementById('statusFilterSelect').value;

            const rows = document.querySelectorAll('.patient-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const rowPoliId = row.getAttribute('data-poli-id');
                const rowStatus = row.getAttribute('data-status');
                const patientName = row.querySelector('.patient-name').textContent.toLowerCase();
                const patientRm = row.querySelector('.patient-rm').textContent.toLowerCase();

                const matchesPoli = (activePoliId === 'all' || rowPoliId === activePoliId);
                const matchesStatus = (statusFilter === 'all' || rowStatus === statusFilter);
                const matchesSearch = (!searchTerm || patientName.includes(searchTerm) || patientRm.includes(searchTerm));

                if (matchesPoli && matchesStatus && matchesSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('visiblePatientCount').textContent = visibleCount;
            document.getElementById('tabBadgePatients').textContent = visibleCount;

            // Also filter doctor schedule cards
            document.querySelectorAll('.schedule-card').forEach(card => {
                const cardPoliId = card.getAttribute('data-poli-id');
                if (activePoliId === 'all' || cardPoliId === activePoliId) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Row Action Dropdown Toggle
        function toggleRowMenu(menuId) {
            hideRowMenus();
            const menu = document.getElementById(menuId);
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        function hideRowMenus() {
            document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add('hidden'));
        }

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.text-left')) {
                hideRowMenus();
            }
        });

        // AJAX: Update Patient Visit Status
        async function updateVisitStatus(visitId, newStatus) {
            try {
                const res = await fetch(`/visits/${visitId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const data = await res.json();
                if (data.success) {
                    showToast('Sukses', data.message, 'success');
                    
                    // Update row in-place smoothly
                    const row = document.querySelector(`tr[data-id="${visitId}"]`);
                    if (row) {
                        row.setAttribute('data-status', newStatus);
                        const statusCell = row.querySelector('.status-cell');
                        statusCell.innerHTML = `
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border ${data.badge.bg}">
                                <span class="w-2 h-2 rounded-full ${data.badge.dot}"></span>
                                <span class="status-label">${data.badge.label}</span>
                            </span>
                        `;
                    }
                }
            } catch (err) {
                console.error(err);
                showToast('Kesalahan', 'Gagal memperbarui status pasien', 'error');
            }
        }

        // AJAX: Toggle Doctor Status
        async function toggleDoctorStatus(doctorId, status) {
            try {
                const res = await fetch(`/doctors/${doctorId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status_praktek: status })
                });

                const data = await res.json();
                if (data.success) {
                    showToast('Status Dokter Diperbarui', data.message, 'success');
                    const label = document.getElementById(`docStatusLabel-${doctorId}`);
                    if (label) {
                        label.textContent = data.status_label;
                    }
                }
            } catch (err) {
                console.error(err);
                showToast('Kesalahan', 'Gagal memperbarui status dokter', 'error');
            }
        }

        // Modal Controls
        function openRegisterModal() {
            const modal = document.getElementById('registerModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.modal-enter').classList.add('modal-enter-active');
            }, 10);
            updateModalDoctorOptions(document.getElementById('modalPoliSelect').value);
        }

        function closeRegisterModal() {
            const modal = document.getElementById('registerModal');
            modal.querySelector('.modal-enter').classList.remove('modal-enter-active');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 250);
        }

        function showPatientDetailModal(name, rm, queue, poli, doctor, keluhan, catatan) {
            document.getElementById('detailPatientName').textContent = name;
            document.getElementById('detailRm').textContent = rm;
            document.getElementById('detailQueueBadge').textContent = queue;
            document.getElementById('detailPoliAndDoctor').textContent = `${poli} • ${doctor}`;
            document.getElementById('detailKeluhan').textContent = keluhan || 'Tidak ada catatan keluhan';
            document.getElementById('detailCatatan').textContent = catatan || 'Belum ada catatan dokter';

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.modal-enter').classList.add('modal-enter-active');
            }, 10);
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.querySelector('.modal-enter').classList.remove('modal-enter-active');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 250);
        }

        // Filter Doctor Options in Modal based on selected Poli
        function updateModalDoctorOptions(selectedPoliId) {
            const docSelect = document.getElementById('modalDoctorSelect');
            const options = docSelect.querySelectorAll('option');
            let firstMatched = false;

            options.forEach(opt => {
                const poli = opt.getAttribute('data-poli');
                if (poli === selectedPoliId) {
                    opt.style.display = '';
                    if (!firstMatched) {
                        opt.selected = true;
                        firstMatched = true;
                    }
                } else {
                    opt.style.display = 'none';
                }
            });
        }

        // AJAX Form Submit for Registering Patient
        async function handleRegisterSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitPatient');
            btn.disabled = true;
            btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...`;

            const form = e.target;
            const formData = new FormData(form);

            try {
                const res = await fetch('/visits', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await res.json();
                if (data.success) {
                    showToast('Pasien Terdaftar!', `Nomor Antrian: ${data.data.nomor_antrian}`, 'success');
                    closeRegisterModal();
                    form.reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    showToast('Gagal', 'Terjadi kesalahan pengisian form.', 'error');
                }
            } catch (err) {
                console.error(err);
                showToast('Gagal', 'Terjadi kesalahan server.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = `<i class="fa-solid fa-check"></i> <span>Terbitkan Nomor Antrian VVIP</span>`;
            }
        }

        // Toast Notification System
        function showToast(title, message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `pointer-events-auto flex items-center gap-3 p-4 rounded-2xl bg-white shadow-2xl border border-slate-100 min-w-[320px] max-w-md transform translate-x-12 opacity-0 smooth-transition`;

            let iconHtml = '';
            if (type === 'success') {
                iconHtml = `<div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-check"></i></div>`;
            } else if (type === 'error') {
                iconHtml = `<div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-triangle-exclamation"></i></div>`;
            } else {
                iconHtml = `<div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-bell"></i></div>`;
            }

            toast.innerHTML = `
                ${iconHtml}
                <div class="flex-1">
                    <h5 class="font-bold text-slate-900 text-xs">${title}</h5>
                    <p class="text-[11px] text-slate-500 mt-0.5">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-12', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('translate-x-12', 'opacity-0');
                setTimeout(() => toast.remove(), 400);
            }, 4500);
        }

        // Fullscreen TV Mode Toggle
        function toggleBrowserFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => console.warn(err));
                const icon = document.getElementById('fullscreenIcon');
                if (icon) icon.className = 'fa-solid fa-compress text-sm';
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
                const icon = document.getElementById('fullscreenIcon');
                if (icon) icon.className = 'fa-solid fa-expand text-sm';
            }
        }
        document.addEventListener('fullscreenchange', () => {
            const icon = document.getElementById('fullscreenIcon');
            if (!icon) return;
            if (document.fullscreenElement) {
                icon.className = 'fa-solid fa-compress text-sm';
            } else {
                icon.className = 'fa-solid fa-expand text-sm';
            }
        });

        // Initialize Chart.js with Vibrant Gradients (Only if canvas elements exist)
        document.addEventListener('DOMContentLoaded', () => {
            const canvasPoli = document.getElementById('poliDistributionChart');
            if (canvasPoli) {
                const ctxPoli = canvasPoli.getContext('2d');
                
                // Create vibrant gradient fills
                const gradientRose = ctxPoli.createLinearGradient(0, 0, 0, 250);
                gradientRose.addColorStop(0, '#FF416C');
                gradientRose.addColorStop(1, '#FF4B2B');

                const gradientIndigo = ctxPoli.createLinearGradient(0, 0, 0, 250);
                gradientIndigo.addColorStop(0, '#6366F1');
                gradientIndigo.addColorStop(1, '#8B5CF6');

                const gradientEmerald = ctxPoli.createLinearGradient(0, 0, 0, 250);
                gradientEmerald.addColorStop(0, '#10B981');
                gradientEmerald.addColorStop(1, '#06B6D4');

                const gradientAmber = ctxPoli.createLinearGradient(0, 0, 0, 250);
                gradientAmber.addColorStop(0, '#F59E0B');
                gradientAmber.addColorStop(1, '#D97706');

                new Chart(ctxPoli, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($poliChartLabels) !!},
                        datasets: [{
                            label: 'Pasien Eksekutif',
                            data: {!! json_encode($poliChartData) !!},
                            backgroundColor: [
                                gradientRose, gradientIndigo, gradientEmerald, '#0EA5E9',
                                gradientAmber, '#EC4899', '#8B5CF6', '#3B82F6'
                            ],
                            borderRadius: 12,
                            borderSkipped: false,
                            barPercentage: 0.55
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                                bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                                padding: 12,
                                cornerRadius: 12,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: { family: 'Plus Jakarta Sans', size: 11 }
                                },
                                grid: {
                                    color: '#f1f5f9'
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }
                                }
                            }
                        }
                    }
                });
            }

            // Chart 2: Status Doughnut
            const canvasStatus = document.getElementById('statusDoughnutChart');
            if (canvasStatus) {
                const ctxStatus = canvasStatus.getContext('2d');
                new Chart(ctxStatus, {
                    type: 'doughnut',
                    data: {
                        labels: ['Diperiksa', 'Menunggu', 'Selesai', 'Farmasi'],
                        datasets: [{
                            data: [
                                {{ $pasienSedangDiperiksa }}, 
                                {{ $pasienMenunggu }}, 
                                {{ $pasienSelesai }}, 
                                {{ max(0, $totalPasienHariIni - $pasienSedangDiperiksa - $pasienMenunggu - $pasienSelesai) }}
                            ],
                            backgroundColor: ['#6366F1', '#F59E0B', '#10B981', '#06B6D4'],
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                                bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                                padding: 12,
                                cornerRadius: 12
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
