<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>NutriDSS Manager - Sistem Pendukung Keputusan Gizi Nasional</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#003c90",
                        "primary-hover": "#002f75",
                        "primary-light": "#e8f0fe"
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-[#f4f8fc] dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased transition-colors duration-300">

    <!-- Top Navigation Bar -->
    <header class="w-full h-16 bg-white/90 dark:bg-slate-850/90 backdrop-blur border-b border-gray-200/80 dark:border-slate-800 flex justify-between items-center px-12 sticky top-0 z-50 transition-colors">
        <div class="flex items-center gap-2 font-black text-xl text-slate-900 dark:text-white tracking-tight">
            <span class="text-primary dark:text-blue-400 material-symbols-outlined font-bold !text-[26px]">space_dashboard</span>
            <span>NutriDSS <span class="text-primary dark:text-blue-400 font-medium text-sm">Manager</span></span>
        </div>
        
        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600 dark:text-slate-300">
            <a href="#" class="text-primary dark:text-blue-400 border-b-2 border-primary dark:border-blue-400 pb-1">Home</a>
            <a href="#ranking-spk" class="hover:text-primary dark:hover:text-blue-400 transition-colors">Ranking SPK</a>
            <a href="#daftar-menu" class="hover:text-primary dark:hover:text-blue-400 transition-colors">Daftar Menu</a>
            <a href="#informasi-gizi" class="hover:text-primary dark:hover:text-blue-400 transition-colors">Informasi Gizi</a>
        </nav>

        <div class="flex items-center gap-4">
            <button id="theme-toggle" class="p-2 rounded-full bg-transparent text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-amber-500 transition-all focus:outline-none hover:scale-110 hover:rotate-12">
                <span id="theme-toggle-dark-icon" class="material-symbols-outlined hidden !text-[20px]">dark_mode</span>
                <span id="theme-toggle-light-icon" class="material-symbols-outlined hidden !text-[20px]">light_mode</span>
            </button>
            <button class="bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-xl font-bold text-xs shadow-sm flex items-center gap-1.5 transition-all active:scale-95">
                <span class="material-symbols-outlined !text-sm">login</span>
                Masuk / Login
            </button>
        </div>
    </header>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Area -->
    <footer class="w-full bg-slate-900 text-slate-400 text-xs py-12 px-12 border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-3">
                <div class="font-black text-white text-lg tracking-tight">NutriDSS</div>
                <p class="leading-relaxed text-gray-400">Sistem Pendukung Keputusan untuk Manajemen Program Gizi Nasional yang transparan, akurat, dan berbasis data ilmiah.</p>
            </div>
            <div class="space-y-2">
                <div class="font-bold text-white text-sm tracking-tight mb-1">Tautan Cepat</div>
                <a href="#" class="block hover:text-white transition-colors">Home</a>
                <a href="#ranking-spk" class="block hover:text-white transition-colors">Hasil Ranking SPK</a>
                <a href="#daftar-menu" class="block hover:text-white transition-colors">Daftar Menu</a>
                <a href="#informasi-gizi" class="block hover:text-white transition-colors">Informasi Gizi</a>
            </div>
            <div class="space-y-2">
                <div class="font-bold text-white text-sm tracking-tight mb-1">Kontak &amp; Bantuan</div>
                <div class="flex items-center gap-2"><span class="material-symbols-outlined !text-sm">mail</span> info@nutridss.go.id</div>
                <div class="flex items-center gap-2"><span class="material-symbols-outlined !text-sm">location_on</span> Wonosobo, Jawa Tengah, Indonesia</div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto border-t border-slate-800 mt-8 pt-4 flex flex-col sm:flex-row justify-between text-[11px] text-gray-500">
            <span>© 2026 NutriDSS. Seluruh hak cipta di bawah perlindungan undang-undang.</span>
        </div>
    </footer>

    <script>
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        if (document.documentElement.classList.contains('dark')) {
            lightIcon.classList.remove('hidden');
        } else {
            darkIcon.classList.remove('hidden');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');
        themeToggleBtn.addEventListener('click', function() {
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');

            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
</body>
</html>