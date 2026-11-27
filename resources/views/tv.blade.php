<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Display TV Ruang Tunggu — {{ $settings['hospital_name'] ?? 'Poliklinik Eksekutif' }}</title>

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
                            50: '#f0fdf4',
                            500: '#10b981',
                            600: '#059669',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 40%, #faf5ff 100%);
        }
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marqueeLinear linear infinite;
        }
        @keyframes marqueeLinear {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>
</head>
<body class="min-h-screen lg:h-screen lg:max-h-screen lg:overflow-hidden overflow-y-auto flex flex-col justify-between font-sans antialiased text-slate-800 select-none p-2.5 sm:p-3.5 md:p-4 lg:p-5 relative">

    <!-- Top TV Navigation Header -->
    <header class="glass-card rounded-2xl px-3 sm:px-5 py-2.5 sm:py-3 shadow-xs border border-slate-200/90 shrink-0 mb-2.5 sm:mb-3 flex items-center justify-between gap-2 flex-wrap">
        <!-- Logo & Branding -->
        <div class="flex items-center gap-2.5 sm:gap-3.5">
            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl flex items-center justify-center p-0.5 shadow-md shadow-indigo-500/20 shrink-0"
                 style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);">
                <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-hospital-user text-lg sm:text-xl" style="background: linear-gradient(135deg, #4f46e5, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                </div>
            </div>
            <div>
                <h1 class="text-sm sm:text-base lg:text-lg font-display font-extrabold tracking-tight text-slate-900 leading-tight">
                    {{ $settings['hospital_name'] ?? 'POLIKLINIK EKSEKUTIF' }}
                </h1>
                <p class="hidden sm:block text-[11px] text-slate-500 font-medium leading-none mt-0.5">
                    {{ $settings['hospital_subtitle'] ?? 'Sistem Monitoring Terintegrasi & Alur Pasien Prioritas' }}
                </p>
            </div>
        </div>

        <!-- Center: Realtime Digital Clock (Responsive) -->
        <div class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-1.5 rounded-xl bg-slate-100/90 border border-slate-200/80 shadow-inner">
            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-[11px] sm:text-xs shrink-0">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div>
                <div id="tvLiveClock" class="text-xs sm:text-sm font-black font-mono text-slate-900 tracking-wider">00:00:00 WIB</div>
                <div id="tvLiveDate" class="hidden sm:block text-[10px] text-slate-500 font-semibold">Memuat waktu...</div>
            </div>
        </div>

        <!-- Right Controls: Fullscreen & Switch to Web -->
        <div class="flex items-center gap-2">
            <!-- Fullscreen TV Toggle Button -->
            <button onclick="toggleTvFullscreen()" title="Layar Penuh TV (Fullscreen)" 
                    class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-300 flex items-center justify-center smooth-transition shadow-xs">
                <i class="fa-solid fa-expand text-xs" id="tvFullscreenIcon"></i>
            </button>

            <!-- Switch to Web Dashboard -->
            <a href="{{ route('dashboard') }}" title="Buka Tampilan Web Dashboard" 
               class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-indigo-300 text-slate-600 hover:text-indigo-600 text-xs font-bold smooth-transition shadow-xs">
                <i class="fa-solid fa-desktop text-xs"></i>
                <span class="hidden md:inline">Web Dashboard</span>
            </a>
        </div>
    </header>

    <!-- Main Content Area: Responsive Grid (Stacks on mobile, 12-col side-by-side on lg/TV) -->
    <main class="flex-1 min-h-0 flex flex-col justify-between mb-2.5 sm:mb-3">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 sm:gap-3.5 xl:gap-4.5 h-full min-h-0 items-stretch">
            
            @if(($settings['show_video'] ?? '1') == '1')
            <!-- LEFT: Video Player (Responsive aspect-ratio on mobile, 5 Cols on desktop/TV) -->
            <div class="lg:col-span-5 xl:col-span-5 flex flex-col h-auto lg:h-full min-h-0">
                <div class="glass-card rounded-2xl sm:rounded-3xl p-2.5 sm:p-3 h-full flex flex-col justify-between relative overflow-hidden border border-slate-200/90 shadow-sm">
                    
                    <div id="tvPlayerContainer" class="relative w-full rounded-xl sm:rounded-2xl overflow-hidden bg-slate-950 aspect-video lg:aspect-auto flex-1 min-h-[200px] sm:min-h-[260px] lg:min-h-0 flex items-center justify-center shadow-inner">
                        <!-- HTML5 Video -->
                        <video id="tvBroadcastVideo" class="w-full h-full object-cover absolute inset-0" autoplay loop muted playsinline poster="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1200&auto=format&fit=crop">
                            <source src="{{ $settings['video_url'] ?? '' }}" type="video/mp4">
                        </video>

                        <!-- YouTube Embed Iframe -->
                        <iframe id="tvBroadcastIframe" class="w-full h-full absolute inset-0 hidden border-0" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                        <!-- Top TV Badge -->
                        <div class="absolute top-2.5 sm:top-3 left-2.5 sm:left-3 right-2.5 sm:right-3 flex items-center justify-between z-20 pointer-events-none">
                            <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-[11px] sm:text-xs font-bold border border-white/20">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                <span class="text-rose-400 font-extrabold uppercase text-[10px] sm:text-[11px]">LIVE SIARAN TV</span>
                            </div>
                        </div>

                        <!-- Bottom Title Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4 bg-gradient-to-t from-slate-950/95 via-slate-950/70 to-transparent text-white z-20">
                            <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-cyan-400 block mb-0.5">
                                <i class="fa-solid fa-circle-play mr-1"></i> Sedang Ditayangkan
                            </span>
                            <h4 id="tvVideoTitle" class="text-xs sm:text-sm font-extrabold text-white line-clamp-1 leading-snug">
                                {{ $settings['video_title'] ?? 'Edukasi Kesehatan Poliklinik Eksekutif' }}
                            </h4>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            <!-- RIGHT: KPI Cards & Clinic Carousel (7 Cols or 12 Cols if video is disabled) -->
            <div class="{{ ($settings['show_video'] ?? '1') == '1' ? 'lg:col-span-7 xl:col-span-7' : 'lg:col-span-12 xl:col-span-12' }} flex flex-col justify-between gap-3 sm:gap-3.5 xl:gap-4 h-full min-h-0">
                
                <!-- 4 KPI Metrics (Proporsional & Seimbang untuk Layar TV) -->
                <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-4 gap-3 xl:gap-3.5 shrink-0">
                    <!-- KPI 1: Total Pasien -->
                    <div class="glass-card p-3.5 sm:p-4 rounded-2xl sm:rounded-3xl flex flex-col justify-between shadow-xs border border-slate-200/90 bg-white/95">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Total Pasien</span>
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl flex items-center justify-center text-white shadow-sm shrink-0" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                                <i class="fa-solid fa-users text-sm sm:text-base"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl sm:text-3xl xl:text-4xl font-display font-black text-slate-900" id="kpiTotal">{{ $totalPasienHariIni }}</span>
                                <span class="text-[11px] sm:text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">+14%</span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-bold mt-0.5">Kunjungan Terjadwal</p>
                        </div>
                    </div>

                    <!-- KPI 2: Diperiksa -->
                    <div class="glass-card p-3.5 sm:p-4 rounded-2xl sm:rounded-3xl flex flex-col justify-between shadow-xs border border-slate-200/90 bg-white/95">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Diperiksa</span>
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl flex items-center justify-center text-white shadow-sm shrink-0" style="background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);">
                                <i class="fa-solid fa-user-doctor text-sm sm:text-base"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl sm:text-3xl xl:text-4xl font-display font-black text-cyan-600" id="kpiDiperiksa">{{ $pasienSedangDiperiksa }}</span>
                                <span class="text-[11px] sm:text-xs font-extrabold text-cyan-700 bg-cyan-50 px-2 py-0.5 rounded-lg border border-cyan-200">Suite</span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-bold mt-0.5">Sedang Konsultasi</p>
                        </div>
                    </div>

                    <!-- KPI 3: Menunggu -->
                    <div class="glass-card p-3.5 sm:p-4 rounded-2xl sm:rounded-3xl flex flex-col justify-between shadow-xs border border-slate-200/90 bg-white/95">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Menunggu</span>
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl flex items-center justify-center text-white shadow-sm shrink-0" style="background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);">
                                <i class="fa-solid fa-mug-hot text-sm sm:text-base"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl sm:text-3xl xl:text-4xl font-display font-black text-amber-600" id="kpiMenunggu">{{ $pasienMenunggu }}</span>
                                <span class="text-[11px] sm:text-xs font-extrabold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-200">Lounge</span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-bold mt-0.5">Antrian di Lounge</p>
                        </div>
                    </div>

                    <!-- KPI 4: Dokter Aktif -->
                    <div class="glass-card p-3.5 sm:p-4 rounded-2xl sm:rounded-3xl flex flex-col justify-between shadow-xs border border-slate-200/90 bg-white/95">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Dokter Aktif</span>
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl flex items-center justify-center text-white shadow-sm shrink-0" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <i class="fa-solid fa-stethoscope text-sm sm:text-base"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl sm:text-3xl xl:text-4xl font-display font-black text-emerald-600" id="kpiDokter">{{ $dokterPraktekCount }}</span>
                                <span class="text-[11px] sm:text-xs font-extrabold text-slate-500">/ {{ $totalDokter }} Dr</span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-bold mt-0.5">Siaga Praktek Hari Ini</p>
                        </div>
                    </div>
                </div>

                <!-- Auto-Rotating Clinic Carousel (Presisi, Proporsional & Badge Pasien Tidak Terpotong) -->
                <div class="glass-card p-3.5 sm:p-4 lg:p-4.5 rounded-2xl sm:rounded-3xl relative overflow-hidden flex-1 min-h-0 flex flex-col justify-between border border-slate-200/90 shadow-sm"
                     id="tvPoliCarouselSection"
                     onmouseenter="pauseTvCarousel()" 
                     onmouseleave="resumeTvCarousel()">
                    
                    <!-- Carousel Header -->
                    <div class="flex items-center justify-between shrink-0 mb-2 sm:mb-2.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm sm:text-base shadow-xs border border-indigo-100">
                                <i class="fa-solid fa-hospital-user"></i>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-display font-black text-slate-900 leading-tight">
                                    Poliklinik Spesialis Eksekutif
                                </h3>
                                <p class="text-[11px] sm:text-xs text-slate-500 font-semibold">Jadwal konsultasi &amp; beban kunjungan aktif</p>
                            </div>
                        </div>

                        <!-- Controls -->
                        <div class="flex items-center gap-1.5">
                            <button onclick="slideTvCarousel('prev')" title="Sebelumnya" 
                                    class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-300 flex items-center justify-center smooth-transition text-xs shadow-xs">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button onclick="slideTvCarousel('next')" title="Berikutnya" 
                                    class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-300 flex items-center justify-center smooth-transition text-xs shadow-xs">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Carousel Viewport (Mengisi Penuh Tinggi & Lebar Container) -->
                    <div class="overflow-hidden w-full flex-1 min-h-0 py-1 flex flex-col" id="tvPoliViewport">
                        <div id="tvPoliTrack" class="flex gap-3 sm:gap-4 h-full items-stretch w-full smooth-transition" style="transform: translateX(0px); transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);">
                            @foreach($polis as $poli)
                            <div class="poli-carousel-card shrink-0 select-none h-full flex flex-col">
                                <div class="w-full h-full p-3.5 sm:p-4 lg:p-4.5 rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white/95 hover:bg-white smooth-transition shadow-xs hover:shadow-md flex flex-col items-center justify-between text-center relative overflow-hidden group">
                                    
                                    <!-- Gradient Icon Circle (Sleek & Proportional) -->
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 xl:w-18 xl:h-18 rounded-2xl sm:rounded-3xl flex items-center justify-center text-white text-2xl sm:text-3xl shadow-sm group-hover:scale-105 smooth-transition shrink-0"
                                         style="background: {{ $poli->warna_gradien }};">
                                        <i class="fa-solid {{ $poli->icon }}"></i>
                                    </div>

                                    <!-- Poli Code & Full Name -->
                                    <div class="my-auto py-1 sm:py-1.5 w-full px-1">
                                        <span class="text-base sm:text-lg xl:text-xl font-display font-black text-slate-900 block tracking-tight group-hover:text-indigo-600 smooth-transition">
                                            {{ $poli->kode_poli }}
                                        </span>
                                        <h4 class="text-xs sm:text-sm font-extrabold text-slate-700 line-clamp-2 mt-0.5 sm:mt-1 leading-snug">
                                            {{ str_replace('Poli ', '', $poli->nama_poli) }}
                                        </h4>
                                    </div>

                                    <!-- Visitor Badge (Jelas, Tampak Utuh & Tidak Terpotong) -->
                                    <div class="shrink-0 w-full pt-1.5 pb-0.5 flex justify-center">
                                        <span class="inline-flex items-center justify-center gap-1.5 px-4 py-1.5 sm:px-5 sm:py-2 rounded-xl sm:rounded-2xl text-xs sm:text-sm xl:text-base font-black bg-indigo-50 text-indigo-700 border-2 border-indigo-200/90 shadow-xs">
                                            <i class="fa-solid fa-users text-xs sm:text-sm text-indigo-600"></i>
                                            <span>{{ $poli->visits_count }} Pasien</span>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dots Indicator -->
                    <div class="flex items-center justify-center gap-2 mt-2 shrink-0" id="tvCarouselDots"></div>
                </div>
            </div>

        </div>

    </main>

    <!-- Bottom Ticker / Running Text (Shrink-0 / Fixed Docked) -->
    @if(($settings['show_running_text'] ?? '1') == '1')
    <div class="shrink-0 p-3 sm:p-3.5 rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white shadow-xl border border-indigo-500/30 flex items-center gap-3.5 overflow-hidden">
        <div class="shrink-0 flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-amber-500 to-rose-500 text-white font-black text-xs xl:text-sm shadow-md tracking-wider">
            <i class="fa-solid fa-bullhorn text-xs"></i> {{ $settings['running_text_label'] ?? 'PENGUMUMAN' }}
        </div>
        <div class="overflow-hidden whitespace-nowrap flex-1 relative">
            <div class="marquee-track flex gap-16" style="animation-duration: {{ $settings['running_text_speed'] ?? '75s' }};">
                <div class="shrink-0 flex items-center gap-10 text-xs sm:text-sm font-semibold text-slate-100">
                    @foreach($runningTextItems as $item)
                    <span class="flex items-center gap-2">
                        <i class="{{ $item['icon'] ?? 'fa-solid fa-circle-info' }} {{ $item['color'] ?? 'text-cyan-400' }} text-sm"></i>
                        <span>{!! str_replace(['**', '**'], ['<strong>', '</strong>'], $item['text'] ?? '') !!}</span>
                    </span>
                    <span class="text-indigo-400">&bull;</span>
                    @endforeach
                </div>
                <!-- Duplicate copy for seamless loop -->
                <div class="shrink-0 flex items-center gap-10 text-xs sm:text-sm font-semibold text-slate-100" aria-hidden="true">
                    @foreach($runningTextItems as $item)
                    <span class="flex items-center gap-2">
                        <i class="{{ $item['icon'] ?? 'fa-solid fa-circle-info' }} {{ $item['color'] ?? 'text-cyan-400' }} text-sm"></i>
                        <span>{!! str_replace(['**', '**'], ['<strong>', '</strong>'], $item['text'] ?? '') !!}</span>
                    </span>
                    <span class="text-indigo-400">&bull;</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- TV Display JavaScript -->
    <script>
        // Realtime Clock
        function updateTvClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('tvLiveClock').textContent = `${h}:${m}:${s} WIB`;

            const opt = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('tvLiveDate').textContent = now.toLocaleDateString('id-ID', opt);
        }
        setInterval(updateTvClock, 1000);
        updateTvClock();

        // TV Fullscreen Toggle
        function toggleTvFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => console.warn(err));
                const icon = document.getElementById('tvFullscreenIcon');
                if (icon) icon.className = 'fa-solid fa-compress text-xs';
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
                const icon = document.getElementById('tvFullscreenIcon');
                if (icon) icon.className = 'fa-solid fa-expand text-xs';
            }
        }
        document.addEventListener('fullscreenchange', () => {
            const icon = document.getElementById('tvFullscreenIcon');
            if (!icon) return;
            if (document.fullscreenElement) {
                icon.className = 'fa-solid fa-compress text-xs';
            } else {
                icon.className = 'fa-solid fa-expand text-xs';
            }
        });

        // Video Player Setup (YouTube vs HTML5)
        function initTvVideo() {
            const rawUrl = @json($settings['video_url'] ?? '');
            if (!rawUrl) return;

            const ytRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts|live)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
            const match = rawUrl.match(ytRegex);

            const videoEl = document.getElementById('tvBroadcastVideo');
            const iframeEl = document.getElementById('tvBroadcastIframe');

            if (match && match[1]) {
                const vid = match[1];
                if (videoEl) {
                    try { videoEl.pause(); } catch(e){}
                    videoEl.classList.add('hidden');
                }
                if (iframeEl) {
                    iframeEl.classList.remove('hidden');
                    iframeEl.src = `https://www.youtube-nocookie.com/embed/${vid}?autoplay=1&mute=1&loop=1&playlist=${vid}&controls=1&rel=0&modestbranding=1`;
                }
            } else {
                if (iframeEl) {
                    iframeEl.classList.add('hidden');
                    iframeEl.src = '';
                }
                if (videoEl) {
                    videoEl.classList.remove('hidden');
                    videoEl.src = rawUrl;
                    videoEl.load();
                    videoEl.play().catch(e => console.warn(e));
                }
            }
        }
        initTvVideo();

                // Auto-Rotating Carousel Poli for TV (Tampil 3 Poli Bergantian Otomatis Presisi)
        let tvCarouselIdx = 0;
        let tvCarouselTimer = null;

        function getTvVisibleCount() {
            const vp = document.getElementById('tvPoliViewport');
            if (!vp) return 3;
            const w = vp.clientWidth;
            if (w < 480) return 1;
            if (w < 768) return 2;
            if (w < 1366) return 3;
            const hasVideo = {{ ($settings['show_video'] ?? '1') == '1' ? 'true' : 'false' }};
            if (!hasVideo && w >= 1366) return 4;
            return 3;
        }

        function updateTvCardWidths() {
            const vp = document.getElementById('tvPoliViewport');
            const track = document.getElementById('tvPoliTrack');
            if (!vp || !track || !track.children.length) return;

            const visible = getTvVisibleCount();
            const gap = 16;
            const avail = vp.clientWidth;
            const w = Math.floor((avail - (visible - 1) * gap) / visible);

            Array.from(track.children).forEach(c => {
                c.style.width = `${w}px`;
                c.style.minWidth = `${w}px`;
                c.style.maxWidth = `${w}px`;
            });

            slideTvCarousel('current');
            updateTvDots();
        }

        function slideTvCarousel(dir) {
            const track = document.getElementById('tvPoliTrack');
            if (!track || !track.children.length) return;

            const total = track.children.length;
            const visible = getTvVisibleCount();
            const maxIdx = Math.max(0, total - visible);

            if (dir === 'next') {
                tvCarouselIdx = (tvCarouselIdx >= maxIdx) ? 0 : tvCarouselIdx + 1;
            } else if (dir === 'prev') {
                tvCarouselIdx = (tvCarouselIdx <= 0) ? maxIdx : tvCarouselIdx - 1;
            } else if (dir === 'current') {
                if (tvCarouselIdx > maxIdx) tvCarouselIdx = maxIdx;
            }

            const cardW = track.children[0].offsetWidth;
            const gap = 16;
            const offset = tvCarouselIdx * (cardW + gap);
            track.style.transform = `translateX(-${offset}px)`;
            updateTvDots();
        }

        function updateTvDots() {
            const dots = document.getElementById('tvCarouselDots');
            const track = document.getElementById('tvPoliTrack');
            if (!dots || !track) return;

            const total = track.children.length;
            const visible = getTvVisibleCount();
            const pages = Math.max(1, total - visible + 1);

            dots.innerHTML = '';
            for (let i = 0; i < pages; i++) {
                const d = document.createElement('span');
                const isActive = (i === tvCarouselIdx);
                d.className = `h-2 rounded-full smooth-transition cursor-pointer ${isActive ? 'bg-indigo-600 w-6' : 'bg-slate-300 hover:bg-slate-400 w-2'}`;
                d.onclick = () => { tvCarouselIdx = i; slideTvCarousel('current'); };
                dots.appendChild(d);
            }
        }

        function pauseTvCarousel() {
            if (tvCarouselTimer) clearInterval(tvCarouselTimer);
            tvCarouselTimer = null;
        }

        function resumeTvCarousel() {
            pauseTvCarousel();
            tvCarouselTimer = setInterval(() => slideTvCarousel('next'), 3500); // Rotasi otomatis setiap 3.5 detik
        }

        window.addEventListener('load', () => {
            updateTvCardWidths();
            resumeTvCarousel();
        });
        window.addEventListener('resize', updateTvCardWidths);

        // Auto-Polling Realtime Stats every 20 seconds
        setInterval(() => {
            fetch('/api/visits')
                .then(r => r.json())
                .then(res => {
                    if (res && res.data) {
                        const visits = res.data;
                        const total = visits.length;
                        const diperiksa = visits.filter(v => v.status === 'sedang_diperiksa').length;
                        const menunggu = visits.filter(v => v.status === 'menunggu').length;
                        document.getElementById('kpiTotal').textContent = total;
                        document.getElementById('kpiDiperiksa').textContent = diperiksa;
                        document.getElementById('kpiMenunggu').textContent = menunggu;
                    }
                })
                .catch(e => console.warn('Polling error:', e));
        }, 20000);
    </script>
</body>
</html>
