<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>NutriDSS Portal - Program Gizi Nasional</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed": "#001f24",
                        "on-primary-fixed-variant": "#00419c",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed": "#a3f69c",
                        "on-tertiary-fixed-variant": "#004e59",
                        "on-background": "#071e27",
                        "primary": "#003c90",
                        "secondary-container": "#a0f399",
                        "primary-fixed-dim": "#b0c6ff",
                        "secondary-fixed-dim": "#88d982",
                        "on-secondary-container": "#217128",
                        "background": "#f3faff",
                        "error": "#ba1a1a",
                        "surface-container-highest": "#cfe6f2",
                        "surface-bright": "#f3faff",
                        "on-secondary": "#ffffff",
                        "on-surface": "#071e27",
                        "tertiary-fixed-dim": "#55d7ed",
                        "surface-variant": "#cfe6f2",
                        "surface-dim": "#c7dde9",
                        "outline": "#737784",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#b0c6ff",
                        "on-surface-variant": "#434653",
                        "surface-tint": "#1d59c1",
                        "surface-container": "#dbf1fe",
                        "tertiary-container": "#00616e",
                        "tertiary": "#004851",
                        "on-primary": "#ffffff",
                        "surface": "#f3faff",
                        "inverse-surface": "#1e333c",
                        "secondary": "#1b6d24",
                        "on-secondary-fixed": "#002204",
                        "on-primary-container": "#bcceff",
                        "surface-container-high": "#d5ecf8",
                        "tertiary-fixed": "#9eefff",
                        "surface-container-low": "#e6f6ff",
                        "on-tertiary-container": "#5fdff5",
                        "primary-fixed": "#d9e2ff",
                        "error-container": "#ffdad6",
                        "outline-variant": "#c3c6d5",
                        "on-primary-fixed": "#001945",
                        "inverse-on-surface": "#dff4ff",
                        "on-secondary-fixed-variant": "#005312",
                        "primary-container": "#0f52ba",
                        "on-error": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "xs": "4px",
                        "max-width": "1440px",
                        "margin-mobile": "16px",
                        "lg": "24px",
                        "gutter": "24px",
                        "xl": "32px",
                        "sm": "8px",
                        "base": "4px",
                        "md": "16px",
                        "margin-desktop": "32px"
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
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
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
<body class="bg-surface-bright dark:bg-slate-950 text-on-surface dark:text-slate-100 antialiased transition-colors duration-300">

    <header class="fixed top-0 left-0 right-0 z-50 bg-surface-container-lowest dark:bg-slate-900 border-b border-outline-variant dark:border-slate-800 flex justify-between items-center h-16 px-margin-desktop shadow-sm transition-colors">
        <div class="flex items-center gap-md">
            <span class="text-xl font-black text-on-surface dark:text-white tracking-tight flex items-center gap-2">
                <span class="text-primary dark:text-blue-400 material-symbols-outlined font-bold">space_dashboard</span>
                NutriDSS <span class="text-primary dark:text-blue-400 font-medium text-sm">Manager</span>
            </span>
        </div>
        
        <nav id="main-nav" class="hidden md:flex items-center gap-xl">
            <a class="nav-link text-sm text-primary dark:text-blue-400 border-b-2 border-primary dark:border-blue-400 pb-1 font-bold transition-all duration-200" href="#home">Home</a>
            <a class="nav-link text-sm text-on-surface-variant dark:text-slate-300 border-b-2 border-transparent pb-1 font-semibold hover:text-primary dark:hover:text-blue-400 transition-all duration-200" href="#ranking">Ranking SPK</a>
            <a class="nav-link text-sm text-on-surface-variant dark:text-slate-300 border-b-2 border-transparent pb-1 font-semibold hover:text-primary dark:hover:text-blue-400 transition-all duration-200" href="#menu">Daftar Menu</a>
            <a class="nav-link text-sm text-on-surface-variant dark:text-slate-300 border-b-2 border-transparent pb-1 font-semibold hover:text-primary dark:hover:text-blue-400 transition-all duration-200" href="#informasi">Informasi Gizi</a>
        </nav>
        
        <div class="flex items-center gap-md">
            <button id="theme-toggle" class="p-2 rounded-full bg-transparent text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-amber-500 dark:hover:text-amber-400 transition-all duration-300 hover:scale-110 active:scale-95 hover:rotate-12 focus:outline-none">
                <span id="theme-toggle-dark-icon" class="material-symbols-outlined hidden !text-[22px]">dark_mode</span>
                <span id="theme-toggle-light-icon" class="material-symbols-outlined hidden !text-[22px]">light_mode</span>
            </button>
            <a href="{{ route('login') }}" class="bg-primary text-on-primary px-lg py-sm rounded-lg font-semibold text-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-xs">
                <span class="material-symbols-outlined text-[20px]">login</span>
                Masuk/Login
            </a>
        </div>
    </header>

    <main class="pt-16">
        <section class="relative min-h-[520px] flex items-center overflow-hidden bg-surface-container-low dark:bg-slate-900/20 border-b border-gray-200/50 dark:border-slate-800" id="home">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/40 to-transparent dark:from-slate-950 dark:via-slate-950/50 z-10"></div>
                <img class="w-full h-full object-cover brightness-95 dark:brightness-[0.35]" src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&q=80&w=1600"/>
            </div>
            <div class="container mx-auto px-margin-desktop relative z-20 max-w-4xl">
                <div class="p-xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-2xl border border-outline-variant/30 dark:border-slate-800 shadow-xl">
                    <span class="inline-block py-0.5 px-3 bg-secondary-container dark:bg-emerald-500/10 text-on-secondary-container dark:text-emerald-400 font-bold text-xs rounded-full mb-3 border border-emerald-500/10">Transparansi Publik</span>
                    <h1 class="text-3xl font-black text-on-surface dark:text-white tracking-tight mb-3">Sistem Pendukung Keputusan Gizi Nasional</h1>
                    <p class="text-sm text-on-surface-variant dark:text-slate-300 mb-6 leading-relaxed font-medium">
                        NutriDSS memberikan akses terbuka bagi masyarakat untuk memantau standar nutrisi, komposisi menu, dan hasil pemeringkatan program makan bergizi nasional. Kami memastikan setiap porsi memenuhi standar kesehatan terbaik secara objektif.
                    </p>
                    <div class="flex flex-wrap gap-md text-xs font-bold">
                        <a class="bg-primary text-on-primary px-5 py-2.5 rounded-xl hover:shadow-lg transition-all" href="#menu">Lihat Daftar Menu</a>
                        <a class="border border-primary text-primary dark:text-blue-400 dark:border-blue-500/40 px-5 py-2.5 rounded-xl hover:bg-primary-light/50 dark:hover:bg-slate-800 transition-all" href="#ranking">Hasil Analisis SPK</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-xl bg-surface dark:bg-slate-950" id="ranking">
            <div class="container mx-auto px-margin-desktop">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-xl border-b border-gray-100 dark:border-slate-800 pb-4">
                    <div class="max-w-2xl">
                        <h2 class="text-xl font-black tracking-tight text-on-surface dark:text-white mb-1">Hasil Rekomendasi Menu Teratas</h2>
                        <p class="text-xs font-semibold text-on-surface-variant dark:text-slate-400">Hasil pemeringkatan otomatis berdasarkan rujukan bobot kriteria AHP harian.</p>
                    </div>
                    <div class="mt-md md:mt-0 flex items-center gap-xs text-primary dark:text-blue-400 font-bold text-xs">
                        <span class="material-symbols-outlined !text-sm">update</span>
                        Terakhir Diperbarui: 17 Juni 2026
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-lg">
                    <div class="md:col-span-7 bg-surface-container-lowest dark:bg-slate-900/50 rounded-2xl border-2 border-secondary dark:border-emerald-500/50 overflow-hidden shadow-sm hover:shadow-md transition-all group relative">
                        <div class="absolute top-4 left-4 z-10 bg-secondary dark:bg-emerald-600 text-on-secondary text-xs px-3 py-1 rounded-lg font-black tracking-wider shadow">
                            🏅 RANK 1
                        </div>
                        <div class="h-60 overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800"/>
                        </div>
                        <div class="p-lg">
                            <div class="flex justify-between items-start mb-md gap-4">
                                <div>
                                    <h3 class="text-lg font-black text-on-surface dark:text-white tracking-tight">A10 — Nasi Putih, Fried Chicken &amp; Buah Naga</h3>
                                    <p class="text-xs font-medium text-on-surface-variant dark:text-slate-400 mt-0.5">Komposisi seimbang dengan kandungan serat dan protein hewani yang tinggi.</p>
                                </div>
                                <div class="text-right shrink-0">
                                    <div class="text-primary dark:text-blue-400 font-black text-2xl tracking-tight">0.7536</div>
                                    <div class="font-bold text-[9px] text-on-surface-variant dark:text-slate-500 uppercase tracking-wider mt-0.5">Skor Kedekatan Vi</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-5 gap-2 border-t border-gray-100 dark:border-slate-800 pt-md text-center">
                                <div class="p-2 bg-slate-50 dark:bg-slate-900 rounded-xl">
                                    <div class="text-xs font-black dark:text-slate-200">478</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tight mt-0.5">Kkal (C1)</div>
                                </div>
                                <div class="p-2 bg-slate-50 dark:bg-slate-900 rounded-xl">
                                    <div class="text-xs font-black dark:text-slate-200">23.9g</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tight mt-0.5">Prot (C2)</div>
                                </div>
                                <div class="p-2 bg-slate-50 dark:bg-slate-900 rounded-xl">
                                    <div class="text-xs font-black dark:text-slate-200">12.4g</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tight mt-0.5">Lemak (C3)</div>
                                </div>
                                <div class="p-2 bg-slate-50 dark:bg-slate-900 rounded-xl">
                                    <div class="text-xs font-black dark:text-slate-200">67.6g</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tight mt-0.5">Karbo (C4)</div>
                                </div>
                                <div class="p-2 bg-slate-50 dark:bg-slate-900 rounded-xl">
                                    <div class="text-xs font-black dark:text-slate-200">5.4g</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tight mt-0.5">Serat (C5)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-5 flex flex-col gap-md">
                        <div class="bg-surface-container-lowest dark:bg-slate-900/50 rounded-2xl border border-outline-variant dark:border-slate-800/80 p-4 flex gap-md hover:shadow-sm transition-all">
                            <img class="w-16 h-16 rounded-xl object-cover shrink-0" src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=200"/>
                            <div class="flex-grow flex flex-col justify-between">
                                <div>
                                    <h4 class="text-sm font-black text-on-surface dark:text-white tracking-tight">A12 — Nasi Kuning, Dadar Suwir &amp; Apel</h4>
                                    <p class="text-[11px] text-on-surface-variant dark:text-slate-400">Peringkat dua kelayakan gizi makro.</p>
                                </div>
                                <div class="flex items-center justify-between text-xs pt-1">
                                    <span class="font-extrabold text-primary dark:text-blue-400">Score: 0.7270</span>
                                    <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded uppercase">Rank 2</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-surface-container-lowest dark:bg-slate-900/50 rounded-2xl border border-outline-variant dark:border-slate-800/80 p-4 flex gap-md hover:shadow-sm transition-all">
                            <img class="w-16 h-16 rounded-xl object-cover shrink-0" src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=200"/>
                            <div class="flex-grow flex flex-col justify-between">
                                <div>
                                    <h4 class="text-sm font-black text-on-surface dark:text-white tracking-tight">A1 — Nasi Kuning, Abon Ayam &amp; Anggur</h4>
                                    <p class="text-[11px] text-on-surface-variant dark:text-slate-400">Pilihan variatif dengan kombinasi buah anggur segar.</p>
                                </div>
                                <div class="flex items-center justify-between text-xs pt-1">
                                    <span class="font-extrabold text-primary dark:text-blue-400">Score: 0.6450</span>
                                    <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded uppercase">Rank 3</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-900/50 border border-outline-variant dark:border-slate-800/80 p-5 rounded-2xl shadow-sm flex flex-col justify-center">
                            <div class="flex justify-between items-center mb-3">
                                <div class="space-y-0.5">
                                    <h4 class="font-black text-slate-800 dark:text-slate-200 text-sm tracking-tight">Kriteria Prioritas Gizi</h4>
                                    <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Hasil Vektor Bobot Pakar (AHP)</p>
                                </div>
                                <span class="material-symbols-outlined text-primary dark:text-blue-400">verified</span>
                            </div>
                            <div class="space-y-2.5">
                                <div>
                                    <div class="flex justify-between text-[11px] font-bold mb-0.5">
                                        <span class="text-slate-700 dark:text-slate-300">Protein (C2)</span>
                                        <span class="text-emerald-600 dark:text-emerald-400">31.04%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-emerald-500 h-full rounded-full" style="width: 31.04%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[11px] font-bold mb-0.5">
                                        <span class="text-slate-700 dark:text-slate-300">Serat (C5)</span>
                                        <span class="text-teal-600 dark:text-teal-400">29.61%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-teal-500 h-full rounded-full" style="width: 29.61%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[11px] font-bold mb-0.5">
                                        <span class="text-slate-700 dark:text-slate-300">Karbohidrat (C4)</span>
                                        <span class="text-cyan-600 dark:text-cyan-400">23.89%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-cyan-500 h-full rounded-full" style="width: 23.89%"></div>
                                    </div>
                                </div>
                            </div>
                            <a class="font-bold text-[11px] text-primary dark:text-blue-400 hover:underline mt-4 text-center block" href="#informasi">Tampilkan Semua 5 Atribut Kriteria</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-xl bg-surface-container-low dark:bg-slate-900/20" id="menu">
            <div class="container mx-auto px-margin-desktop">
                <div class="text-center mb-xl max-w-xl mx-auto space-y-1">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface dark:text-white">Eksplorasi Daftar Menu</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant dark:text-slate-400">Tinjau data rujukan alternatif komposisi hidangan sajian program makanan bergizi seimbang.</p>
                </div>
                
                <div class="flex flex-col md:flex-row gap-lg mb-xl">
                    <div class="flex-1 relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline dark:text-slate-500">search</span>
                        <input class="w-full pl-xl pr-md py-2.5 bg-surface-container-lowest dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm" placeholder="Cari nama menu atau bahan..." type="text"/>
                    </div>
                    <div class="flex gap-md overflow-x-auto pb-xs text-xs font-bold">
                        <button class="shrink-0 bg-primary text-on-primary px-4 py-2.5 rounded-xl shadow-sm">Semua</button>
                        <button class="shrink-0 bg-surface-container-lowest dark:bg-slate-900 text-on-surface dark:text-slate-300 border border-outline-variant dark:border-slate-800 px-4 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Tinggi Protein</button>
                        <button class="shrink-0 bg-surface-container-lowest dark:bg-slate-900 text-on-surface dark:text-slate-300 border border-outline-variant dark:border-slate-800 px-4 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Rendah Lemak</button>
                        <button class="shrink-0 bg-surface-container-lowest dark:bg-slate-900 text-on-surface dark:text-slate-300 border border-outline-variant dark:border-slate-800 px-4 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Vegetarian</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-lg">
                    <div class="bg-surface-container-lowest dark:bg-slate-900/40 rounded-2xl border border-outline-variant dark:border-slate-800/60 overflow-hidden flex flex-col justify-between transition-all hover:-translate-y-1 hover:shadow group">
                        <div class="h-44 overflow-hidden relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=400"/>
                            <span class="absolute top-2 right-2 bg-tertiary text-on-tertiary font-bold text-[9px] px-2 py-0.5 rounded-md uppercase tracking-wider">Tradisional</span>
                        </div>
                        <div class="p-4 space-y-3 flex-grow flex flex-col justify-between">
                            <div>
                                <h5 class="font-extrabold text-sm text-on-surface dark:text-white tracking-tight group-hover:text-primary dark:group-hover:text-blue-400 transition-colors">A1 — Nasi Kuning &amp; Abon Ayam</h5>
                                <div class="flex items-center gap-xs text-secondary dark:text-emerald-400 mt-1">
                                    <span class="material-symbols-outlined text-[16px]">verified</span>
                                    <span class="font-bold text-[10px]">Menu Standar Nasional</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-slate-800 text-xs font-bold text-gray-400">
                                <div class="text-slate-700 dark:text-slate-300 font-black">468 Kkal</div>
                                <a href="#ranking" class="text-primary dark:text-blue-400 flex items-center gap-xs hover:underline">Lihat Rank <span class="material-symbols-outlined text-[16px]">visibility</span></a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest dark:bg-slate-900/40 rounded-2xl border border-outline-variant dark:border-slate-800/60 overflow-hidden flex flex-col justify-between transition-all hover:-translate-y-1 hover:shadow group">
                        <div class="h-44 overflow-hidden relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=400"/>
                            <span class="absolute top-2 right-2 bg-tertiary text-on-tertiary font-bold text-[9px] px-2 py-0.5 rounded-md uppercase tracking-wider">Unggas</span>
                        </div>
                        <div class="p-4 space-y-3 flex-grow flex flex-col justify-between">
                            <div>
                                <h5 class="font-extrabold text-sm text-on-surface dark:text-white tracking-tight group-hover:text-primary dark:group-hover:text-blue-400 transition-colors">A2 — Ayam Goreng Lengkuas</h5>
                                <div class="flex items-center gap-xs text-secondary dark:text-emerald-400 mt-1">
                                    <span class="material-symbols-outlined text-[16px]">verified</span>
                                    <span class="font-bold text-[10px]">Menu Standar Nasional</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-slate-800 text-xs font-bold text-gray-400">
                                <div class="text-slate-700 dark:text-slate-300 font-black">441 Kkal</div>
                                <a href="#ranking" class="text-primary dark:text-blue-400 flex items-center gap-xs hover:underline">Lihat Rank <span class="material-symbols-outlined text-[16px]">visibility</span></a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest dark:bg-slate-900/40 rounded-2xl border border-outline-variant dark:border-slate-800/60 overflow-hidden flex flex-col justify-between transition-all hover:-translate-y-1 hover:shadow group">
                        <div class="h-44 overflow-hidden relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=400"/>
                            <span class="absolute top-2 right-2 bg-amber-500 text-white font-bold text-[9px] px-2 py-0.5 rounded-md uppercase tracking-wider">Terbaik</span>
                        </div>
                        <div class="p-4 space-y-3 flex-grow flex flex-col justify-between">
                            <div>
                                <h5 class="font-extrabold text-sm text-on-surface dark:text-white tracking-tight group-hover:text-primary dark:group-hover:text-blue-400 transition-colors">A10 — Fried Chicken &amp; Naga</h5>
                                <div class="flex items-center gap-xs text-secondary dark:text-emerald-400 mt-1">
                                    <span class="material-symbols-outlined text-[16px]">verified_user</span>
                                    <span class="font-bold text-[10px] text-emerald-600 dark:text-emerald-400">Rekomendasi Utama</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-slate-800 text-xs font-bold text-gray-400">
                                <div class="text-slate-700 dark:text-slate-300 font-black">478 Kkal</div>
                                <a href="#ranking" class="text-primary dark:text-blue-400 flex items-center gap-xs hover:underline">Lihat Rank <span class="material-symbols-outlined text-[16px]">visibility</span></a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest dark:bg-slate-900/40 rounded-2xl border border-outline-variant dark:border-slate-800/60 overflow-hidden flex flex-col justify-between transition-all hover:-translate-y-1 hover:shadow group">
                        <div class="h-44 overflow-hidden relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=400"/>
                            <span class="absolute top-2 right-2 bg-tertiary text-on-tertiary font-bold text-[9px] px-2 py-0.5 rounded-md uppercase tracking-wider">Kombinasi</span>
                        </div>
                        <div class="p-4 space-y-3 flex-grow flex flex-col justify-between">
                            <div>
                                <h5 class="font-extrabold text-sm text-on-surface dark:text-white tracking-tight group-hover:text-primary dark:group-hover:text-blue-400 transition-colors">A12 — Nasi Kuning &amp; Apel</h5>
                                <div class="flex items-center gap-xs text-secondary dark:text-emerald-400 mt-1">
                                    <span class="material-symbols-outlined text-[16px]">verified</span>
                                    <span class="font-bold text-[10px]">Menu Standar Nasional</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-slate-800 text-xs font-bold text-gray-400">
                                <div class="text-slate-700 dark:text-slate-300 font-black">492 Kkal</div>
                                <a href="#ranking" class="text-primary dark:text-blue-400 flex items-center gap-xs hover:underline">Lihat Rank <span class="material-symbols-outlined text-[16px]">visibility</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-xl text-center">
                    <button class="px-6 py-2.5 bg-white dark:bg-slate-900 border border-outline-variant dark:border-slate-800 text-on-surface-variant dark:text-slate-300 rounded-xl font-bold text-xs hover:bg-slate-100 dark:hover:bg-slate-800/80 transition-all active:scale-95 shadow-sm">
                        Muat Seluruh 12 Alternatif Menu
                    </button>
                </div>
            </div>
        </section>

        <section class="py-xl bg-surface-container-lowest dark:bg-slate-950 border-t border-gray-150 dark:border-slate-900" id="informasi">
            <div class="container mx-auto px-margin-desktop">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl items-center">
                    <div>
                        <h2 class="text-xl font-black tracking-tight text-on-surface dark:text-white mb-3">Memahami Angka Kecukupan Gizi (AKG)</h2>
                        <p class="text-xs font-medium text-on-surface-variant dark:text-slate-400 mb-6 leading-relaxed">
                            Setiap piring hidangan standar nasional di SPPG Kecamatan Kertek diuji melalui 5 kriteria parameter gizi makro guna memastikan pemenuhan pertumbuhan harian anak.
                        </p>
                        
                        <div class="space-y-3">
                            <div class="flex items-start gap-4 p-3.5 bg-surface-container-low dark:bg-slate-900/40 border border-gray-100 dark:border-slate-800/40 rounded-xl">
                                <div class="p-2 bg-primary/10 rounded-xl text-primary dark:text-blue-400 shrink-0">
                                    <span class="material-symbols-outlined !text-xl">fitness_center</span>
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-sm text-on-surface dark:text-white tracking-tight">Protein Tinggi Berkelanjutan (C2)</h4>
                                    <p class="text-xs font-medium text-on-surface-variant dark:text-slate-400 mt-0.5">Aspek vital untuk pembentukan imunitas jaringan otot sel tubuh anak sekolah.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-3.5 bg-surface-container-low dark:bg-slate-900/40 border border-gray-100 dark:border-slate-800/40 rounded-xl">
                                <div class="p-2 bg-primary/10 rounded-xl text-primary dark:text-blue-400 shrink-0">
                                    <span class="material-symbols-outlined !text-xl">bolt</span>
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-sm text-on-surface dark:text-white tracking-tight">Kalori Dan Energi Terukur (C1)</h4>
                                    <p class="text-xs font-medium text-on-surface-variant dark:text-slate-400 mt-0.5">Dosis kalori proporsional untuk energi konsentrasi belajar tanpa risiko obesitas.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -inset-4 bg-primary/5 rounded-[2rem] blur-2xl z-0"></div>
                        <div class="relative z-10 glass-card dark:bg-slate-900/80 p-xl rounded-2xl shadow-xl border border-outline-variant dark:border-slate-800">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-black text-sm tracking-tight text-on-surface dark:text-white">5 Atribut Nilai Parameter Gizi (Benefit)</h3>
                                <span class="material-symbols-outlined text-outline dark:text-slate-500">info</span>
                            </div>
                            <div class="space-y-4 text-xs font-bold">
                                <div>
                                    <div class="flex justify-between mb-1 text-gray-500 dark:text-slate-400">
                                        <span>Karbohidrat (C4)</span>
                                        <span class="text-on-surface dark:text-white">0.2389</span>
                                    </div>
                                    <div class="w-full bg-surface-container-highest dark:bg-slate-800 rounded-full h-2">
                                        <div class="bg-primary h-2 rounded-full" style="width: 23.89%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1 text-gray-500 dark:text-slate-400">
                                        <span>Energi (C1)</span>
                                        <span class="text-on-surface dark:text-white">0.0953</span>
                                    </div>
                                    <div class="w-full bg-surface-container-highest dark:bg-slate-800 rounded-full h-2">
                                        <div class="bg-amber-500 h-2 rounded-full" style="width: 9.53%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1 text-gray-500 dark:text-slate-400">
                                        <span>Lemak Sehat (C3)</span>
                                        <span class="text-on-surface dark:text-white">0.0592</span>
                                    </div>
                                    <div class="w-full bg-surface-container-highest dark:bg-slate-800 rounded-full h-2">
                                        <div class="bg-rose-500 h-2 rounded-full" style="width: 5.92%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-on-background dark:bg-slate-950 text-white pt-xl pb-lg border-t dark:border-slate-900">
        <div class="container mx-auto px-margin-desktop max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-xl mb-xl">
                <div class="col-span-1 md:col-span-2 space-y-4">
                    <h3 class="text-lg font-black tracking-tight">NutriDSS</h3>
                    <p class="text-xs text-gray-400 leading-relaxed max-w-sm">
                        Sistem Pendukung Keputusan Kelayakan Menu Program Gizi Seimbang Nasional yang transparan dan berbasis data.
                    </p>
                </div>
                <div class="space-y-2">
                    <h4 class="font-extrabold text-sm tracking-tight mb-1">Tautan Portal</h4>
                    <ul class="space-y-1.5 text-xs text-gray-400 font-medium">
                        <li><a class="hover:text-white transition-colors" href="#home">Home</a></li>
                        <li><a class="hover:text-white transition-colors" href="#ranking">Hasil Ranking SPK</a></li>
                        <li><a class="hover:text-white transition-colors" href="#menu">Daftar Menu</a></li>
                        <li><a class="hover:text-white transition-colors" href="#informasi">Informasi Gizi</a></li>
                    </ul>
                </div>
                <div class="space-y-2">
                    <h4 class="font-extrabold text-sm tracking-tight mb-1">Kontak Wilayah</h4>
                    <ul class="space-y-1.5 text-xs text-gray-400 font-medium">
                        <li class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">mail</span> info@nutridss.go.id</li>
                        <li class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">location_on</span> Wonosobo, Jawa Tengah, Indonesia</li>
                    </ul>
                </div>
            </div>
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

        // FIXED SCRIPT: PENYANGGA UTAMA SINKRONISASI AKTIF GARIS BAWAH NAV-LINK
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('section[id]');

        function updateActiveNavbar() {
            let currentSectionId = "home";
            const scrollPosition = window.scrollY + 120; // Tambah offset tinggi topbar

            // KONDISI BATAS BAWAH (EDGE CASE): Jika posisi scroll mentok ke paling bawah halaman
            if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 50) {
                currentSectionId = "informasi"; // Paksa pindahkan langsung ke ID paling bawah
            } else {
                sections.forEach(section => {
                    if (scrollPosition >= section.offsetTop) {
                        currentSectionId = section.getAttribute('id');
                    }
                });
            }

            navLinks.forEach(link => {
                // Reset semua kelas ke status tidak aktif harian
                link.classList.remove('text-primary', 'dark:text-blue-400', 'border-primary', 'dark:border-blue-400', 'font-bold');
                link.classList.add('text-on-surface-variant', 'dark:text-slate-300', 'border-transparent', 'font-semibold');

                // Pasang pendaran garis biru ke menu yang id-nya cocok
                if (link.getAttribute('href') === `#${currentSectionId}`) {
                    link.classList.remove('text-on-surface-variant', 'dark:text-slate-300', 'border-transparent', 'font-semibold');
                    link.classList.add('text-primary', 'dark:text-blue-400', 'border-primary', 'dark:border-blue-400', 'font-bold');
                }
            });
        }

        window.addEventListener('scroll', updateActiveNavbar);
        window.addEventListener('load', updateActiveNavbar);

        // INSTANT INTERACTIVE CLICK: Garis langsung pindah tanpa menunggu durasi scroll selesai
        navLinks.forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                window.scrollTo({
                    top: targetElement.offsetTop - 60, // Menghindari judul tertutup header
                    behavior: 'smooth'
                });

                // Pindahkan kelas aktif secara manual saat diklik agar terasa responsif
                navLinks.forEach(link => {
                    link.classList.remove('text-primary', 'dark:text-blue-400', 'border-primary', 'dark:border-blue-400', 'font-bold');
                    link.classList.add('text-on-surface-variant', 'dark:text-slate-300', 'border-transparent', 'font-semibold');
                });
                this.classList.remove('text-on-surface-variant', 'dark:text-slate-300', 'border-transparent', 'font-semibold');
                this.classList.add('text-primary', 'dark:text-blue-400', 'border-primary', 'dark:border-blue-400', 'font-bold');
            });
        });

        // Pegas klik mikro untuk tombol sistem
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', () => button.classList.add('scale-[0.97]'));
            button.addEventListener('mouseup', () => button.classList.remove('scale-[0.97]'));
            button.addEventListener('mouseleave', () => button.classList.remove('scale-[0.97]'));
        });
    </script>
</body>
</html>