<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login | NutriDSS Admin Portal</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary-container": "#bcceff",
                        "error": "#ba1a1a",
                        "tertiary-fixed-dim": "#55d7ed",
                        "surface-variant": "#cfe6f2",
                        "on-secondary-fixed": "#002204",
                        "inverse-primary": "#b0c6ff",
                        "background": "#f3faff",
                        "on-surface-variant": "#434653",
                        "on-error": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed": "#001f24",
                        "outline": "#737784",
                        "outline-variant": "#c3c6d5",
                        "secondary-fixed": "#a3f69c",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#dff4ff",
                        "on-background": "#071e27",
                        "inverse-surface": "#1e333c",
                        "error-container": "#ffdad6",
                        "surface-bright": "#f3faff",
                        "tertiary-fixed": "#9eefff",
                        "on-tertiary-container": "#5fdff5",
                        "tertiary": "#004851",
                        "on-surface": "#071e27",
                        "primary-container": "#0f52ba",
                        "surface-dim": "#c7dde9",
                        "primary": "#003c90",
                        "surface-container-highest": "#cfe6f2",
                        "on-secondary-container": "#217128",
                        "primary-fixed": "#d9e2ff",
                        "on-tertiary-fixed-variant": "#004e59",
                        "on-primary-fixed-variant": "#00419c",
                        "surface-container": "#dbf1fe",
                        "surface-container-high": "#d5ecf8",
                        "on-secondary": "#ffffff",
                        "tertiary-container": "#00616e",
                        "secondary-container": "#a0f399",
                        "on-primary-fixed": "#001945",
                        "surface": "#f3faff",
                        "surface-tint": "#1d59c1",
                        "surface-container-low": "#e6f6ff",
                        "primary-fixed-dim": "#b0c6ff",
                        "secondary": "#1b6d24",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed-variant": "#005312",
                        "secondary-fixed-dim": "#88d982"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "max-width": "1440px",
                        "gutter": "24px",
                        "margin-desktop": "32px",
                        "base": "4px",
                        "lg": "24px",
                        "md": "16px",
                        "xl": "32px",
                        "sm": "8px",
                        "base": "4px",
                        "xs": "4px",
                        "margin-mobile": "16px"
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
    <!-- Script Anti-Interupsi Kedipan Putih saat Muat Ulang Halaman -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="min-h-screen flex items-center justify-center overflow-hidden bg-surface dark:bg-slate-950 text-on-surface dark:text-slate-100 transition-colors duration-300">

    <!-- Shell Konten Utama -->
    <main class="w-full h-screen flex flex-col md:flex-row">
        
        <!-- SISI KIRI: Visual & Branding Section (NutriDSS Manager Identitas) -->
        <section class="relative hidden md:flex md:w-3/5 h-full overflow-hidden items-center justify-center">
            <div class="absolute inset-0 z-0 bg-primary-container">
                <div class="absolute inset-0 bg-gradient-to-tr from-slate-950 via-primary/80 to-primary/20 z-10"></div>
                <img alt="Healthy fresh ingredients" class="absolute inset-0 w-full h-full object-cover opacity-40 transition-all duration-1000" src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&q=80&w=1200"/>
            </div>
            
            <!-- Konten Utama Branding -->
            <div class="relative z-10 p-xl max-w-xl text-on-primary space-y-6">
                <div class="space-y-3">
                    <span class="material-symbols-outlined text-[54px] text-amber-400" style="font-variation-settings: 'FILL' 1;">analytics</span>
                    <h1 class="font-display-lg text-4xl font-black tracking-tight text-white">NutriDSS Manager</h1>
                    <p class="text-sm font-semibold text-blue-200 leading-relaxed">
                        Sistem Pendukung Keputusan Skala Nasional untuk Akurasi Program Kelayakan Gizi Seimbang Anak Sekolah.
                    </p>
                </div>
                
                <!-- Indikator Metrik Kinerja -->
                <div class="grid grid-cols-2 gap-md pt-4">
                    <div class="glass-panel p-md rounded-2xl shadow-sm">
                        <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest mb-1">Akurasi Sistem</p>
                        <p class="text-2xl font-black text-white">99.8%</p>
                        <p class="text-[11px] text-slate-300 font-medium">Validitas Data Riil</p>
                    </div>
                    <div class="glass-panel p-md rounded-2xl shadow-sm">
                        <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest mb-1">Status Environtment</p>
                        <p class="text-2xl font-black text-emerald-400 flex items-center gap-1">Optimal</p>
                        <p class="text-[11px] text-slate-300 font-medium">Koneksi Enkripsi Aman</p>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-xl left-xl z-10 text-[11px] text-slate-400 font-semibold">
                © 2026 NutriDSS Global. Seluruh hak cipta dilindungi undang-undang.
            </div>
        </section>

        <!-- SISI KANAN: Login Form Section (Mendukung Dark Mode Penuh) -->
        <section class="w-full md:w-2/5 flex items-center justify-center bg-surface-container-lowest dark:bg-slate-900 p-margin-mobile md:p-margin-desktop transition-colors duration-300">
            <div class="w-full max-w-[380px] space-y-6">
                
                <!-- Mobile Header -->
                <div class="md:hidden flex flex-col items-center text-center">
                    <div class="p-3 rounded-2xl bg-primary/10 text-primary dark:text-blue-400 mb-3">
                        <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1;">analytics</span>
                    </div>
                    <h2 class="text-xl font-black tracking-tight text-on-surface dark:text-white">NutriDSS Admin</h2>
                    <p class="text-xs font-semibold text-on-surface-variant dark:text-slate-400 mt-1">Silakan otorisasikan kredensial petugas resmi Anda</p>
                </div>

                <!-- Desktop Header -->
                <div class="hidden md:block">
                    <h2 class="text-2xl font-black tracking-tight text-primary dark:text-blue-400 mb-1">Selamat Datang</h2>
                    <p class="text-xs font-semibold text-on-surface-variant dark:text-slate-400">Masuk untuk mengelola basis data kelayakan menu gizi.</p>
                </div>

                <!-- Alert Pesan Kesalahan Validasi Internal Laravel -->
                @if ($errors->has('login_error'))
                <div class="p-3.5 bg-red-50 dark:bg-red-950/20 border border-red-100 dark:border-red-900/40 rounded-xl flex items-start gap-3 text-xs text-red-600 dark:text-red-400 font-semibold">
                    <span class="material-symbols-outlined !text-sm text-red-500 pt-0.5">error</span>
                    <span>{{ $errors->first('login_error') }}</span>
                </div>
                @endif

                <!-- Form Pemrosesan POST Otentikasi Riil -->
                <form id="login-form" action="{{ route('login.process') }}" method="POST" class="space-y-4 text-xs font-bold">
                    @csrf

                    <!-- Kolom Alamat Email -->
                    <div class="space-y-1.5">
                        <label class="text-slate-700 dark:text-slate-300" for="email">Alamat Email Resmi</label>
                        <div class="relative group">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline dark:text-slate-500 group-focus-within:text-primary dark:group-focus-within:text-blue-400 transition-colors !text-[20px]">person</span>
                            <input class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low dark:bg-slate-950 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-primary dark:focus:border-blue-500 transition-all font-medium text-slate-800 dark:text-slate-200 placeholder:text-gray-300 dark:placeholder:text-slate-700" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="admin@nutridss.go.id" required type="email" autofocus />
                        </div>
                        @if ($errors->has('email'))
                            <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <!-- Kolom Kata Sandi -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label class="text-slate-700 dark:text-slate-300" for="password">Kata Sandi</label>
                            <a class="text-[11px] text-primary dark:text-blue-400 hover:underline transition-all" href="#">Lupa sandi?</a>
                        </div>
                        <div class="relative group">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline dark:text-slate-500 group-focus-within:text-primary dark:group-focus-within:text-blue-400 transition-colors !text-[20px]">lock</span>
                            <input class="w-full pl-10 pr-11 py-2.5 bg-surface-container-low dark:bg-slate-950 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-primary dark:focus:border-blue-500 transition-all font-medium text-slate-800 dark:text-slate-200 placeholder:text-gray-300 dark:placeholder:text-slate-700" 
                                   id="password" name="password" placeholder="••••••••" required type="password"/>
                            <!-- Tombol Intip Password -->
                            <button id="toggle-password" class="absolute right-3 top-1/2 -translate-y-1/2 text-outline dark:text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-colors" type="button">
                                <span id="visibility-icon" class="material-symbols-outlined !text-[20px]">visibility</span>
                            </button>
                        </div>
                        @if ($errors->has('password'))
                            <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <!-- Pilihan Ingat Perangkat -->
                    <div class="flex items-center gap-2 pt-1">
                        <input class="w-4 h-4 rounded border-outline-variant dark:border-slate-800 text-primary dark:text-blue-500 focus:ring-primary dark:focus:ring-blue-500 dark:bg-slate-950" id="remember" name="remember" type="checkbox"/>
                        <label class="text-xs text-on-surface-variant dark:text-slate-400 cursor-pointer font-medium" for="remember">Ingat akun saya di perangkat ini</label>
                    </div>

                    <!-- Tombol Masuk dengan Animasi Mikro Pemuat -->
                    <div class="pt-2">
                        <button id="submit-btn" class="w-full py-3 bg-primary dark:bg-blue-600 text-on-primary font-bold text-xs rounded-xl hover:bg-primary-hover dark:hover:bg-blue-700 shadow-md active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                            <span>Masuk Sebagai Admin</span>
                            <span class="material-symbols-outlined text-[18px]">login</span>
                        </button>
                    </div>
                </form>

                <!-- Footer Info & Navigasi Kembali ke Beranda -->
                <div class="pt-4 border-t border-outline-variant/30 dark:border-slate-800/80 text-center space-y-4">
                    <p class="text-[11px] text-on-surface-variant dark:text-slate-500 font-medium leading-relaxed">
                        Akses terbatas khusus personel resmi pelaksana SPPG Kecamatan Kertek Wonosobo. Seluruh aktivitas log dipantau ketat.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('public.portal') }}" class="text-xs font-bold text-gray-400 hover:text-primary dark:hover:text-blue-400 flex items-center gap-1 group">
                            <span class="material-symbols-outlined !text-sm transform group-hover:-translate-x-0.5 transition-transform">arrow_back</span> 
                            Kembali ke Portal Utama
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Indikator Status Server Atas -->
    <div class="fixed top-4 right-4 hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/80 dark:bg-slate-900 border border-outline-variant/50 dark:border-slate-800 shadow-sm z-50 transition-colors">
        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
        <span class="text-[11px] font-bold text-on-surface-variant dark:text-slate-400">Status Server: Terkoneksi</span>
    </div>

    <!-- SCRIPT AKTIVITAS INTERAKTIF FORM -->
    <script>
        // 1. Animasi Mikro Elastis Input Field
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('scale-[1.01]');
            });
            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('scale-[1.01]');
            });
        });

        // 2. Fungsi Sakelar Intip Kata Sandi (Password Visibility Toggle)
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('toggle-password');
        const visibilityIcon = document.getElementById('visibility-icon');

        togglePasswordBtn.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                visibilityIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                visibilityIcon.textContent = 'visibility';
            }
        });

        // 3. Efek Pemuat (Loading State Animation) saat Form Dikirim
        const loginForm = document.getElementById('login-form');
        const submitBtn = document.getElementById('submit-btn');

        loginForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-90', 'cursor-not-allowed');
            submitBtn.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Mengautentikasi Kredensial...</span>
            `;
        });

        // 4. Pegas Klik Mikro Tombol Sistem
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', () => button.classList.add('scale-[0.97]'));
            button.addEventListener('mouseup', () => button.classList.remove('scale-[0.97]'));
            button.addEventListener('mouseleave', () => button.classList.remove('scale-[0.97]'));
        });
    </script>
</body>
</html>