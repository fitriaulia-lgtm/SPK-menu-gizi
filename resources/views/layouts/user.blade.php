<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SPK Menu Bergizi - Panel Petugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#003c90",
                        "primary-hover": "#002f75",
                        "primary-light": "#e8f0fe",
                        "on-surface": "#071e27",
                        "outline-variant": "#e2e8f0"
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { 
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; 
            font-size: 24px;
        }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-[#F4F7FC] dark:bg-slate-900 text-on-surface dark:text-slate-100 antialiased transition-colors duration-300">

    <aside class="fixed left-0 top-0 h-full w-[260px] bg-[#f8faff] dark:bg-slate-800 border-r border-outline-variant dark:border-slate-700 flex flex-col z-50 transition-colors duration-300">
        <div class="pt-8 pb-8 px-6">
            <div class="flex items-center gap-3 text-primary dark:text-blue-400 font-bold text-xl tracking-tight">
                <span class="material-symbols-outlined text-2xl font-bold" style="font-variation-settings: 'FILL' 1;">apps</span>
                <span>SPK Menu Bergizi</span>
            </div>
        </div>

        <nav class="flex-grow space-y-1 px-3">
            <a class="flex justify-between items-center pl-4 pr-0 py-3.5 rounded-l-md border-r-[4px] transition-all duration-200 group
                {{ request()->routeIs('admin.dashboard') 
                    ? 'text-primary dark:text-blue-400 font-semibold bg-primary-light/60 dark:bg-blue-500/10 border-primary dark:border-blue-500' 
                    : 'text-gray-600 dark:text-slate-400 font-medium border-transparent hover:bg-gray-100/70 dark:hover:bg-slate-700/40 hover:text-primary dark:hover:text-blue-400' }}" 
               href="{{ route('admin.dashboard') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined transition-colors
                        {{ request()->routeIs('admin.dashboard') ? 'text-primary dark:text-blue-400' : 'text-gray-400 dark:text-slate-500 group-hover:text-primary dark:group-hover:text-blue-400' }}"
                        style="{{ request()->routeIs('admin.dashboard') ? "font-variation-settings: 'FILL' 1;" : '' }}">
                        dashboard
                    </span>
                    <span class="text-[15px]">Dashboard</span>
                </div>
            </a>

            <a class="flex justify-between items-center pl-4 pr-0 py-3.5 rounded-l-md border-r-[4px] transition-all duration-200 group
                {{ request()->routeIs('admin.result') 
                    ? 'text-primary dark:text-blue-400 font-semibold bg-primary-light/60 dark:bg-blue-500/10 border-primary dark:border-blue-500' 
                    : 'text-gray-600 dark:text-slate-400 font-medium border-transparent hover:bg-gray-100/70 dark:hover:bg-slate-700/40 hover:text-primary dark:hover:text-blue-400' }}" 
               href="{{ route('admin.result') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined transition-colors
                        {{ request()->routeIs('admin.result') ? 'text-primary dark:text-blue-400' : 'text-gray-400 dark:text-slate-500 group-hover:text-primary dark:group-hover:text-blue-400' }}"
                        style="{{ request()->routeIs('admin.result') ? "font-variation-settings: 'FILL' 1;" : '' }}">
                        leaderboard
                    </span>
                    <span class="text-[15px]">Ranking SPK (TOPSIS)</span>
                </div>
            </a>

            @if(auth()->user()->role === 'admin')
            <a class="flex justify-between items-center pl-4 pr-0 py-3.5 rounded-l-md border-r-[4px] transition-all duration-200 group
                {{ request()->routeIs('criterias.*') 
                    ? 'text-primary dark:text-blue-400 font-semibold bg-primary-light/60 dark:bg-blue-500/10 border-primary dark:border-blue-500' 
                    : 'text-gray-600 dark:text-slate-400 font-medium border-transparent hover:bg-gray-100/70 dark:hover:bg-slate-700/40 hover:text-primary dark:hover:text-blue-400' }}" 
               href="{{ route('criterias.index') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined transition-colors
                        {{ request()->routeIs('criterias.*') ? 'text-primary dark:text-blue-400' : 'text-gray-400 dark:text-slate-500 group-hover:text-primary dark:group-hover:text-blue-400' }}">
                        analytics
                    </span>
                    <span class="text-[15px]">Kelola Kriteria</span>
                </div>
            </a>

            <a class="flex justify-between items-center pl-4 pr-0 py-3.5 rounded-l-md border-r-[4px] transition-all duration-200 group
                {{ request()->routeIs('alternatives.*') 
                    ? 'text-primary dark:text-blue-400 font-semibold bg-primary-light/60 dark:bg-blue-500/10 border-primary dark:border-blue-500' 
                    : 'text-gray-600 dark:text-slate-400 font-medium border-transparent hover:bg-gray-100/70 dark:hover:bg-slate-700/40 hover:text-primary dark:hover:text-blue-400' }}" 
               href="{{ route('alternatives.index') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined transition-colors
                        {{ request()->routeIs('alternatives.*') ? 'text-primary dark:text-blue-400' : 'text-gray-400 dark:text-slate-500 group-hover:text-primary dark:group-hover:text-blue-400' }}">
                        restaurant_menu
                    </span>
                    <span class="text-[15px]">Kelola Alternatif Menu</span>
                </div>
            </a>
            @endif
        </nav>

        <div class="p-4 space-y-2 border-t border-outline-variant/60 dark:border-slate-700/60 bg-[#f8faff] dark:bg-slate-800 transition-colors duration-300">
            <a class="flex items-center gap-4 pl-4 py-2.5 text-gray-600 dark:text-slate-400 font-medium hover:bg-gray-100/70 dark:hover:bg-slate-700/40 hover:text-primary dark:hover:text-blue-400 rounded-md transition-colors group" href="#">
                <span class="material-symbols-outlined text-gray-400 dark:text-slate-500 group-hover:text-primary dark:group-hover:text-blue-400">settings</span>
                <span class="text-[15px]">Settings</span>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 pl-4 py-2.5 text-gray-600 dark:text-slate-400 font-medium hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-600 dark:hover:text-red-400 rounded-md transition-colors group text-left">
                    <span class="material-symbols-outlined text-gray-400 dark:text-slate-500 group-hover:text-red-500">logout</span>
                    <span class="text-[15px]">Keluar / Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="ml-[260px] min-h-screen flex flex-col">
        <header class="h-16 px-8 bg-white dark:bg-slate-800 border-b border-outline-variant dark:border-slate-700/80 flex justify-between items-center sticky top-0 z-40 transition-colors duration-300">
            <div>
                <h1 class="text-xl font-extrabold tracking-tight text-slate-800 dark:text-white">
                    Dashboard {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Petugas' }}
                </h1>
            </div>
            
            <div class="flex items-center gap-5">
                <button id="theme-toggle" class="p-2 rounded-full bg-transparent text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/60 hover:text-amber-500 dark:hover:text-amber-400 transition-all duration-300 hover:scale-110 active:scale-95 hover:rotate-12 focus:outline-none">
                    <span id="theme-toggle-dark-icon" class="material-symbols-outlined hidden !text-[22px]">dark_mode</span>
                    <span id="theme-toggle-light-icon" class="material-symbols-outlined hidden !text-[22px]">light_mode</span>
                </button>

                <div class="h-6 w-[1px] bg-gray-200 dark:bg-slate-700"></div>
                
                <div class="flex items-center gap-3">
                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200">
                        {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                    </div>
                    <div class="w-9 h-9 rounded-full bg-primary/10 dark:bg-slate-900 flex items-center justify-center text-primary dark:text-blue-400 font-extrabold text-sm border border-primary/10 dark:border-slate-700 shadow-inner">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="p-8 space-y-6 flex-grow">
            @yield('content')
        </div>

        <footer class="py-4 text-center text-xs text-gray-400 dark:text-slate-500 border-t border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-800 transition-colors duration-200">
            © 2026 SPK Menu Bergizi - Decision Support System for National Nutrition Programs.
        </footer>
    </main>

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

        // Efek klik mikro pegas (spring) untuk semua tombol sistem
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', () => button.classList.add('scale-[0.97]'));
            button.addEventListener('mouseup', () => button.classList.remove('scale-[0.97]'));
            button.addEventListener('mouseleave', () => button.classList.remove('scale-[0.97]'));
        });
    </script>
</body>
</html>