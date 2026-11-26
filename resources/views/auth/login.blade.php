<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas &amp; Admin — Poliklinik Eksekutif</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #eef2ff 35%, #fdf2f8 100%);
            min-height: 100vh;
        }
        .smooth-transition {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 sm:p-6 min-h-screen relative overflow-x-hidden font-sans antialiased text-slate-800">

    <!-- Ambient glowing backgrounds -->
    <div class="fixed top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-400/20 blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-rose-400/20 blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Back to TV Display Link -->
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-indigo-600 smooth-transition flex items-center gap-2 group">
                <i class="fa-solid fa-arrow-left text-[11px] group-hover:-translate-x-1 smooth-transition"></i>
                <span>Kembali ke Layar TV Display</span>
            </a>
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-full border border-indigo-100">
                VIP Access
            </span>
        </div>

        <!-- Main Login Card -->
        <div class="glass-card rounded-3xl p-7 sm:p-9 shadow-2xl border border-slate-200/90 relative overflow-hidden">
            
            <!-- Top Gradient Accent Bar -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-rose-500"></div>

            <!-- Header Title & Hospital Icon -->
            <div class="text-center mb-7 pt-2">
                <div class="w-16 h-16 rounded-2xl mx-auto mb-3.5 flex items-center justify-center text-white shadow-lg shadow-indigo-500/25 p-0.5"
                     style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);">
                    <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center text-indigo-600">
                        <i class="fa-solid fa-user-shield text-2xl" style="background: linear-gradient(135deg, #4f46e5, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                </div>

                <h2 class="text-2xl font-display font-black text-slate-900 tracking-tight">Login Portal Petugas</h2>
                <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola siaran TV, running text, dan data antrian pasien</p>
            </div>

            <!-- Validation Error Alert -->
            @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-start gap-2.5 shadow-xs">
                <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-500 text-sm shrink-0"></i>
                <div class="flex-1 font-medium">
                    {{ $errors->first() }}
                </div>
            </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email:</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               placeholder="nama@poliklinik.com"
                               class="w-full text-xs rounded-xl border border-slate-200 pl-10 pr-3.5 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-slate-800 font-medium">
                        <i class="fa-regular fa-envelope absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700">Kata Sandi:</label>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               placeholder="••••••••"
                               class="w-full text-xs rounded-xl border border-slate-200 pl-10 pr-10 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-slate-800 font-medium">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-3 text-slate-400 hover:text-slate-600 text-sm focus:outline-hidden">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600 font-medium">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span>Ingat sesi masuk saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3.5 rounded-2xl text-white font-bold text-xs shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/45 hover:-translate-y-0.5 smooth-transition flex items-center justify-center gap-2"
                            style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #ec4899 100%);">
                        <i class="fa-solid fa-right-to-bracket text-sm"></i>
                        <span>Masuk ke Panel Pengaturan</span>
                    </button>
                </div>
            </form>

            <!-- Quick Demo Accounts Helper -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center mb-2.5">
                    Klik Cepat Akun Demo:
                </span>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="fillAccount('admin@poliklinik.com', 'admin123')" 
                            class="p-2.5 rounded-xl border border-indigo-200 bg-indigo-50/60 hover:bg-indigo-100/70 text-indigo-900 text-left smooth-transition group">
                        <div class="flex items-center justify-between mb-0.5">
                            <span class="text-[10px] font-extrabold uppercase text-indigo-600 bg-white px-1.5 py-0.5 rounded border border-indigo-200">Admin</span>
                            <i class="fa-solid fa-bolt text-amber-500 text-[10px]"></i>
                        </div>
                        <div class="text-[11px] font-bold truncate">admin@poliklinik.com</div>
                        <div class="text-[10px] text-slate-500 font-mono">admin123</div>
                    </button>

                    <button type="button" onclick="fillAccount('user@poliklinik.com', 'user123')" 
                            class="p-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-800 text-left smooth-transition group">
                        <div class="flex items-center justify-between mb-0.5">
                            <span class="text-[10px] font-extrabold uppercase text-slate-600 bg-white px-1.5 py-0.5 rounded border border-slate-200">Staff / User</span>
                            <i class="fa-solid fa-user text-slate-400 text-[10px]"></i>
                        </div>
                        <div class="text-[11px] font-bold truncate">user@poliklinik.com</div>
                        <div class="text-[10px] text-slate-500 font-mono">user123</div>
                    </button>
                </div>
            </div>

        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; 2026 Poliklinik Eksekutif VIP Suite &bull; Sistem Terpadu Rumah Sakit
        </p>

    </div>

    <script>
        function togglePasswordVisibility() {
            const pass = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (pass.type === 'password') {
                pass.type = 'text';
                eye.className = 'fa-regular fa-eye-slash text-indigo-600';
            } else {
                pass.type = 'password';
                eye.className = 'fa-regular fa-eye';
            }
        }

        function fillAccount(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
