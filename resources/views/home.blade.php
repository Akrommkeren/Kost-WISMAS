<!DOCTYPE html>
<html lang="id" class="scroll-smooth" style="scrollbar-gutter: stable;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kost Wisma S') }} - Hunian Kost Nyaman, Bersih & Strategis</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-kost.jpg') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#1e3a8a',
                        },
                        orange: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-navbar {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
        }
        .modal-overlay {
            background-color: rgba(23, 37, 84, 0.75);
            backdrop-filter: blur(4px);
        }
        #aturanSliderContainer::-webkit-scrollbar, #ulasanSliderContainer::-webkit-scrollbar { display: none; }
        #aturanSliderContainer, #ulasanSliderContainer { -ms-overflow-style: none; scrollbar-width: none; cursor: grab; }
        #aturanSliderContainer.cursor-grabbing, #ulasanSliderContainer.cursor-grabbing { cursor: grabbing; }

        /* Sembunyikan ikon mata bawaan browser (Microsoft Edge / Windows) */
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-orange-500 selection:text-white flex flex-col min-h-screen">

    @auth
        @if(Auth::user()->isOwner())
            <div class="bg-navy-950 text-white px-4 py-2.5 text-xs flex flex-wrap justify-between items-center z-50 sticky top-0 border-b border-navy-800">
                <span class="font-medium text-slate-200">
                    <i class="fa-solid fa-eye text-orange-400 mr-2"></i> Mode Pratinjau Website Kost (Masuk sebagai Owner: <b>{{ Auth::user()->name }}</b>)
                </span>
                <a href="{{ route('home') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center shadow-sm">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Sistem Manajemen Owner
                </a>
            </div>
        @endif
    @endauth

    <!-- MAIN NAVBAR (WHITE GLASS) -->
    <header class="sticky top-0 z-40 glass-navbar shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo -->
                <a href="#beranda" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 bg-white rounded-xl p-1 shadow-sm flex items-center justify-center overflow-hidden border border-slate-200 transition transform group-hover:scale-105 shrink-0">
                        <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="text-xs font-black text-orange-600 tracking-widest uppercase leading-none mb-0.5">Kost</span>
                        <span class="text-lg sm:text-xl font-black text-navy-900 tracking-tight leading-tight">WISMA S</span>
                    </div>
                </a>

                <!-- Desktop Menu Nav -->
                <nav class="hidden lg:flex items-center space-x-7 text-xs font-bold text-slate-700 uppercase tracking-wider">
                    <a href="#beranda" class="hover:text-orange-600 transition">Beranda</a>
                    <a href="#kamar" class="hover:text-orange-600 transition">Kamar</a>
                    <a href="#aturan" class="hover:text-orange-600 transition">Ketentuan</a>
                    <a href="#pengaduan" class="hover:text-orange-600 transition">Pengaduan</a>
                    <a href="#lokasi" class="hover:text-orange-600 transition">Lokasi</a>
                </nav>

                <!-- Auth Buttons (Desktop & Tablet) -->
                <div class="hidden sm:flex items-center space-x-3" id="navAuthArea">
                    @auth
                        @if(Auth::user()->isOwner())
                            <a href="{{ route('home') }}" class="px-4 py-2.5 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition shadow-sm flex items-center">
                                <i class="fa-solid fa-gauge-high mr-2"></i> Sistem Manajemen Owner
                            </a>
                        @else
                            <button onclick="openTenantDashboard()" class="px-4 py-2.5 text-xs font-bold text-navy-950 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-lg transition shadow-sm flex items-center">
                                <i class="fa-solid fa-user text-orange-600 mr-2"></i> Portal Penghuni
                            </button>
                        @endif
                        <button onclick="logout()" class="px-3.5 py-2 text-xs font-bold text-slate-600 hover:text-red-600 hover:bg-slate-100 rounded-lg transition">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                        </button>
                    @else
                        <button onclick="openAuthModal('login', 'penghuni')" class="px-4 py-2.5 text-xs font-bold text-slate-700 hover:text-orange-600 transition flex items-center">
                            <i class="fa-solid fa-arrow-right-to-bracket mr-1.5"></i> Masuk
                        </button>
                        <button onclick="openAuthModal('register', 'penghuni')" class="px-5 py-2.5 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-lg shadow-sm transition">
                            <i class="fa-solid fa-user-plus mr-1.5"></i> Daftar
                        </button>
                    @endauth
                </div>

                <!-- Mobile Action Menu -->
                <div class="sm:hidden flex items-center space-x-1.5">
                    @guest
                        <button onclick="openAuthModal('login', 'penghuni')" class="px-2.5 py-1.5 text-xs font-bold text-slate-700 border border-slate-300 rounded-md hover:bg-slate-50 transition">Masuk</button>
                        <button onclick="openAuthModal('register', 'penghuni')" class="px-3 py-1.5 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-md shadow-sm transition">Daftar</button>
                    @else
                        @if(!Auth::user()->isOwner())
                            <button onclick="openTenantDashboard()" class="px-2.5 py-1.5 text-xs font-bold text-navy-950 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-md transition shadow-sm flex items-center">
                                <i class="fa-solid fa-user text-orange-600 mr-1"></i> Penghuni
                            </button>
                        @endif
                        <button onclick="logout()" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-slate-100 rounded-md">Keluar</button>
                    @endguest
                </div>

            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="beranda" class="relative text-slate-800 pt-16 pb-28 border-b border-slate-200 bg-cover bg-center overflow-hidden" style="background-image: url('{{ asset('images/foto-kost.jpg') }}');">
        <!-- White Transparent Overlay -->
        <div class="absolute inset-0 bg-white/50"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl space-y-6 text-left py-6 sm:py-10">
                
                <!-- Badge -->
                <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded bg-white border border-slate-300 text-navy-900 text-xs font-bold shadow-sm">
                    <i class="fa-solid fa-circle-check text-blue-600 text-xs"></i>
                    <span>Pilihan Tepat Mahasiswa & Karyawan</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-navy-950 leading-tight tracking-tight">
                    Kost Nyaman, Bersih & Strategis di Lingkungan Aman
                </h1>

                <!-- CTA Button -->
                <div class="pt-2">
                    <a href="#kamar" class="inline-flex items-center justify-center px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-bold rounded-lg shadow-md hover:shadow-lg transition">
                        <i class="fa-solid fa-bed mr-2"></i> Lihat Kamar Tersedia
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- REAL-WORLD SEARCH & FILTER BAR (ANCHORED) -->
    <section class="relative -mt-6 z-20 w-full max-w-6xl mx-auto px-4 sm:px-6">
        <div class="w-full bg-white rounded-xl shadow-lg border border-slate-200/90 p-3.5 sm:py-3.5 sm:px-4.5">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 items-end">
                
                <!-- 1. Tipe Kamar Dropdown (Fixed 3 Cols) -->
                <div class="col-span-1 sm:col-span-1 lg:col-span-3 relative filter-dropdown-wrapper w-full min-w-0 max-w-full">
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1 whitespace-nowrap">
                        <i class="fa-solid fa-filter text-orange-600 mr-1"></i> Tipe Kamar
                    </label>
                    <input type="hidden" id="filterTypeSelect" value="all">
                    <button type="button" onclick="toggleCustomDropdown('type')" class="w-full max-w-full min-w-0 h-[42px] bg-slate-50 hover:bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg px-3.5 focus:ring-2 focus:ring-navy-600 focus:outline-none font-medium flex items-center justify-between transition shadow-sm overflow-hidden">
                        <span id="displayFilterType" class="flex-1 min-w-0 truncate text-slate-900 font-medium text-left">Semua Tipe Kamar</span>
                        <i id="arrowFilterType" class="fa-solid fa-chevron-down text-slate-500 text-[10px] shrink-0 ml-2"></i>
                    </button>

                    <!-- Dropdown Options Menu (1 Kalimat, Warna Hitam Saja, Tanpa Icon) -->
                    <div id="menuFilterType" class="hidden absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-lg shadow-xl border border-slate-200 p-1 space-y-0.5">
                        <div onclick="selectCustomOption('type', 'all', 'Semua Tipe Kamar')" data-val="all" class="type-opt-all px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 bg-slate-100 truncate">
                            Semua Tipe Kamar
                        </div>
                        <div onclick="selectCustomOption('type', 'Standard', 'Standard Single')" data-val="Standard" class="type-opt-Standard px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 truncate">
                            Standard Single
                        </div>
                        <div onclick="selectCustomOption('type', 'Executive', 'Executive Deluxe')" data-val="Executive" class="type-opt-Executive px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 truncate">
                            Executive Deluxe
                        </div>
                        <div onclick="selectCustomOption('type', 'VIP', 'VIP King Suite')" data-val="VIP" class="type-opt-VIP px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 truncate">
                            VIP King Suite
                        </div>
                    </div>
                </div>

                <!-- 2. Status Ketersediaan Dropdown (Fixed 4 Cols) -->
                <div class="col-span-1 sm:col-span-1 lg:col-span-4 relative filter-dropdown-wrapper w-full min-w-0 max-w-full">
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1 whitespace-nowrap">
                        <i class="fa-solid fa-circle-check text-orange-600 mr-1"></i> Status Ketersediaan
                    </label>
                    <input type="hidden" id="filterStatusSelect" value="all">
                    <button type="button" onclick="toggleCustomDropdown('status')" class="w-full max-w-full min-w-0 h-[42px] bg-slate-50 hover:bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg px-3.5 focus:ring-2 focus:ring-navy-600 focus:outline-none font-medium flex items-center justify-between transition shadow-sm overflow-hidden">
                        <span id="displayFilterStatus" class="flex-1 min-w-0 truncate text-slate-900 font-medium text-left">Semua Status</span>
                        <i id="arrowFilterStatus" class="fa-solid fa-chevron-down text-slate-500 text-[10px] shrink-0 ml-2"></i>
                    </button>

                    <!-- Dropdown Options Menu (1 Kalimat, Warna Hitam Saja, Tanpa Icon) -->
                    <div id="menuFilterStatus" class="hidden absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-lg shadow-xl border border-slate-200 p-1 space-y-0.5">
                        <div onclick="selectCustomOption('status', 'all', 'Semua Status')" class="status-opt-all px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 bg-slate-100 truncate">
                            Semua Status
                        </div>
                        <div onclick="selectCustomOption('status', 'available', 'Kamar Tersedia (Siap Huni)')" class="status-opt-available px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 truncate">
                            Kamar Tersedia (Siap Huni)
                        </div>
                        <div onclick="selectCustomOption('status', 'occupied', 'Kamar Terisi')" class="status-opt-occupied px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 truncate">
                            Kamar Terisi
                        </div>
                    </div>
                </div>

                <!-- 3. Kisaran Harga Dropdown (Fixed 3 Cols) -->
                <div class="col-span-1 sm:col-span-1 lg:col-span-3 relative filter-dropdown-wrapper w-full min-w-0 max-w-full">
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1 whitespace-nowrap">
                        <i class="fa-solid fa-money-bill-wave text-orange-600 mr-1"></i> Kisaran Harga
                    </label>
                    <input type="hidden" id="filterPriceSelect" value="all">
                    <button type="button" onclick="toggleCustomDropdown('price')" class="w-full max-w-full min-w-0 h-[42px] bg-slate-50 hover:bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg px-3.5 focus:ring-2 focus:ring-navy-600 focus:outline-none font-medium flex items-center justify-between transition shadow-sm overflow-hidden">
                        <span id="displayFilterPrice" class="flex-1 min-w-0 truncate text-slate-900 font-medium text-left">Semua Harga</span>
                        <i id="arrowFilterPrice" class="fa-solid fa-chevron-down text-slate-500 text-[10px] shrink-0 ml-2"></i>
                    </button>

                    <!-- Dropdown Options Menu (1 Kalimat, Warna Hitam Saja, Tanpa Icon) -->
                    <div id="menuFilterPrice" class="hidden absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-lg shadow-xl border border-slate-200 p-1 space-y-0.5">
                        <div onclick="selectCustomOption('price', 'all', 'Semua Harga')" class="price-opt-all px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 bg-slate-100 truncate">
                            Semua Harga
                        </div>
                        <div onclick="selectCustomOption('price', 'under13', 'Di bawah Rp 1.300.000')" class="price-opt-under13 px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 truncate">
                            Di bawah Rp 1.300.000
                        </div>
                        <div onclick="selectCustomOption('price', '13to16', 'Rp 1.300.000 - Rp 1.600.000')" class="price-opt-13to16 px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 truncate">
                            Rp 1.300.000 - Rp 1.600.000
                        </div>
                        <div onclick="selectCustomOption('price', 'above16', 'Di atas Rp 1.600.000')" class="price-opt-above16 px-3 py-1.5 rounded-md hover:bg-slate-100 cursor-pointer transition text-xs sm:text-sm font-medium text-slate-900 truncate">
                            Di atas Rp 1.600.000
                        </div>
                    </div>
                </div>

                <!-- 4. Reset Button (Fixed 2 Cols) -->
                <div class="col-span-1 sm:col-span-1 lg:col-span-2 w-full min-w-0 max-w-full">
                    <button onclick="resetFilters()" class="w-full h-[42px] px-3.5 bg-navy-900 hover:bg-navy-800 text-white text-xs sm:text-sm font-bold rounded-lg transition inline-flex items-center justify-center shadow-sm whitespace-nowrap">
                        <i class="fa-solid fa-rotate-left mr-1.5 text-orange-400"></i> Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: PILIHAN KAMAR -->
    <section id="kamar" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 pb-4 border-b border-slate-200">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-900">Daftar Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">Pilih tipe kamar sesuai dengan kebutuhan dan anggaran Anda.</p>
            </div>

            <!-- Room Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="roomContainer">
                @foreach($rooms as $room)
                <div class="bg-white rounded-xl overflow-hidden border border-slate-200 hover:border-slate-300 shadow-sm hover:shadow-md transition duration-200 room-card cursor-pointer group" 
                     data-status="{{ $room->status }}" 
                     data-price="{{ $room->price }}" 
                     data-type="{{ $room->type }}"
                     onclick="handleRoomClick({{ $room->id }})">
                    
                    <!-- Room Image Container -->
                    <div class="relative h-52 bg-slate-100 overflow-hidden">
                        <img src="{{ $room->image }}" alt="{{ $room->number }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex items-center space-x-1.5">
                            @if($room->status === 'available')
                                <span class="px-2.5 py-1 bg-emerald-600 text-white font-bold text-[11px] rounded shadow">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Tersedia
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-700 text-white font-bold text-[11px] rounded shadow">
                                    <i class="fa-solid fa-user-lock mr-1"></i> Kamar Terisi
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Room Information -->
                    <div class="p-5">
                        <div class="mb-2">
                            <div class="flex justify-between items-baseline">
                                <h3 class="font-extrabold text-navy-900 text-lg group-hover:text-orange-600 transition">{{ $room->number }}</h3>
                                <div class="text-lg font-extrabold text-navy-900">Rp {{ number_format($room->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="flex justify-between items-baseline mt-0.5">
                                <p class="text-xs font-semibold text-orange-600">{{ $room->type }}</p>
                                <span class="text-[11px] text-slate-500 font-normal">/ bulan</span>
                            </div>
                        </div>

                        <!-- Room Features List -->
                        <div class="my-4 py-3 border-y border-slate-100 grid grid-cols-2 gap-2 text-xs text-slate-600">
                            @if(is_array($room->features))
                                @foreach($room->features as $f)
                                    <div class="flex items-center space-x-1.5">
                                        <i class="fa-solid fa-check text-orange-500 text-[10px]"></i>
                                        <span class="truncate">{{ $f }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Button Rincian & Spesifikasi Fasilitas -->
                        <button type="button" onclick="event.stopPropagation(); handleRoomClick({{ $room->id }})" class="w-full mb-2 py-2 bg-slate-50 hover:bg-slate-100 text-navy-900 border border-slate-200 font-bold text-xs rounded-lg transition flex items-center justify-center">
                            <i class="fa-solid fa-circle-info mr-1.5 text-orange-600"></i> Rincian & Spesifikasi Fasilitas
                        </button>

                        <!-- Action Button -->
                        @if($room->status === 'available')
                            <button onclick="event.stopPropagation(); handleBooking({{ $room->id }}, '{{ $room->number }}')" class="w-full py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-lg transition flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-calendar-check mr-1.5"></i> Booking Kamar
                            </button>
                        @else
                            <button disabled class="w-full py-2 bg-slate-100 text-slate-400 font-bold text-xs rounded-lg cursor-not-allowed border border-slate-200 flex items-center justify-center">
                                <i class="fa-solid fa-lock mr-1.5"></i> Kamar Terisi
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State for filters -->
            <div id="noRoomsNotice" class="hidden text-center py-12 bg-white rounded-xl border border-slate-200 p-6 mt-4">
                <i class="fa-solid fa-inbox text-4xl text-slate-300 mb-3"></i>
                <p class="text-base font-bold text-navy-900">Kamar Tidak Ditemukan</p>
                <p class="text-xs text-slate-500 mt-1">Tidak ada kamar yang cocok dengan kriteria filter yang Anda pilih. Silakan atur ulang filter.</p>
            </div>

        </div>
    </section>


    <!-- SECTION: TATA TERTIB & KETENTUAN KOST -->
    <section id="aturan" class="py-16 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-900">Ketentuan & Kebijakan</h2>
                <p class="text-sm text-slate-500 mt-1">Dibuat untuk menjaga ketenangan, kebersihan, dan kenyamanan seluruh penghuni.</p>
            </div>

            <!-- Wrapper Slider dengan Tombol Navigasi Kiri & Kanan -->
            <div class="relative group">
                <!-- Tombol Prev di sebelah kiri opsi Ketentuan & Kebijakan -->
                <button type="button" 
                        onclick="slideAturan('prev')" 
                        class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white hover:bg-navy-900 text-navy-900 hover:text-white border border-slate-300 shadow-md hover:shadow-lg flex items-center justify-center transition-all duration-200 active:scale-95 focus:outline-none" 
                        title="Sebelumnya" 
                        aria-label="Sebelumnya">
                    <i class="fas fa-chevron-left text-xs sm:text-sm"></i>
                </button>

                <!-- Container Slider Opsi Ketentuan & Kebijakan -->
                <div id="aturanSliderContainer" class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory py-2 pb-4 cursor-grab select-none px-1">
                <!-- Poin 1 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">1</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Akses Kunci & Bebas Jam Malam</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Setiap penghuni memegang kunci gerbang utama dan kamar mandiri. Bebas jam malam dengan tetap menjaga ketenangan lingkungan.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 2 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">2</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Kunjungan Tamu & Jam Bertamu</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Tamu diterima di ruang tamu bersama hingga pukul 22.00 WIB. Tamu lawan jenis tidak diperkenankan menginap atau masuk ke dalam kamar tidur.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 3 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">3</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Pembayaran Sewa Tepat Waktu</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Sewa bulanan dibayar tepat waktu sebelum tanggal jatuh tempo setiap bulannya melalui transfer rekening resmi pengelola kost.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 4 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">4</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Listrik Token Kamar Mandiri</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Setiap kamar dilengkapi meteran token PLN tersendiri. Pengisian pulsa listrik kamar dikelola secara mandiri oleh penghuni sesuai pemakaian.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 5 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">5</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Ketenangan & Jam Istirahat</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Wajib menjaga ketenangan lingkungan, terutama pada jam istirahat malam (22.00 - 06.00 WIB). Dilarang menyalakan audio keras atau berbuat gaduh.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 6 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">6</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Larangan Merokok di Kamar AC</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Dilarang keras merokok di dalam kamar AC dan koridor tertutup. Penghuni dapat menggunakan area terbuka luar yang telah disediakan.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 7 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">7</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Penggunaan Fasilitas Dapur Bersama</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Fasilitas kompor, gas, dan kulkas bersama bebas digunakan. Wajib langsung mencuci peralatan masak/makan dan menjaga kebersihan dapur.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 8 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">8</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Kebersihan & Pembuangan Sampah</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Wajib menjaga kebersihan kamar dan koridor. Sampah kamar dibungkus kantong plastik rapat dan dibuang ke tempat sampah utama yang disediakan.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 9 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">9</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Parkir Kendaraan Tertib & Aman</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Kendaraan motor dan mobil diparkir rapi di area parkir dalam gerbang. Wajib mengunci stang dan mengamankan helm masing-masing.</p>
                        </div>
                    </div>
                </div>

                <!-- Poin 10 -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/90 flex flex-col justify-between hover:bg-slate-100/70 transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] xl:w-[calc(25%-12px)] shrink-0 snap-start">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-7 h-7 rounded-lg bg-navy-900 text-orange-400 flex items-center justify-center font-extrabold text-xs shrink-0 mt-0.5">10</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-navy-900 text-xs sm:text-sm">Bebas Hewan & Larangan Zat Terlarang</h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">Dilarang membawa hewan peliharaan apa pun. Dilarang keras membawa atau mengonsumsi minuman keras, narkoba, dan barang berbahaya.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Next di sebelah kanan opsi Ketentuan & Kebijakan -->
            <button type="button" 
                    onclick="slideAturan('next')" 
                    class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white hover:bg-navy-900 text-navy-900 hover:text-white border border-slate-300 shadow-md hover:shadow-lg flex items-center justify-center transition-all duration-200 active:scale-95 focus:outline-none" 
                    title="Selanjutnya" 
                    aria-label="Selanjutnya">
                <i class="fas fa-chevron-right text-xs sm:text-sm"></i>
            </button>
        </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION: PENGADUAN FASILITAS -->
    <!-- ========================================================================= -->
    <section id="pengaduan" class="py-16 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section (Sama seperti header section lainnya) -->
            <div class="mb-8 max-w-3xl">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-900">Pengaduan</h2>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed">
                    Pilih jenis kendala fasilitas di bawah ini, isi pesan Anda sendiri, dan kirimkan langsung via WhatsApp ke pihak terkait (seperti pesanan air galon langsung ke depot rekanan).
                </p>
            </div>

            <!-- Card Formulir Pengaduan (Full Width Rata Kanan Kiri) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm w-full space-y-5">
                
                <!-- Opsi Fasilitas Berbentuk Button (Warna Biru Navy Disesuaikan dengan Tema) -->
                <div>
                    <input type="hidden" id="selectedKategoriFasilitas" value="Fasilitas Kost">
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" 
                                id="btnFasilitasKost"
                                onclick="pilihOpsiFasilitas('Fasilitas Kost')" 
                                class="inline-flex items-center px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm border transition shadow-sm active:scale-95 bg-navy-900 hover:bg-navy-800 text-white border-navy-900">
                            <i class="fa-solid fa-building mr-2"></i> Fasilitas Kost
                        </button>
                        <button type="button" 
                                id="btnFasilitasKamar"
                                onclick="pilihOpsiFasilitas('Fasilitas Kamar')" 
                                class="inline-flex items-center px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm border transition shadow-sm active:scale-95 bg-white text-slate-700 border-slate-300 hover:bg-slate-50">
                            <i class="fa-solid fa-door-closed mr-2"></i> Fasilitas Kamar
                        </button>
                    </div>
                </div>

                <!-- Kolom Untuk Mengisi Pesan (Lebih Panjang Rata Kanan Kiri) -->
                <div class="w-full">
                    <textarea id="pesanPengaduan" 
                              rows="5" 
                              required 
                              class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-navy-600 focus:outline-none text-xs sm:text-sm font-medium leading-relaxed bg-white text-slate-800 placeholder-slate-400" 
                              placeholder="Tuliskan pesan pengaduan atau kendala fasilitas Anda di sini (misal: Air galon dispenser habis, tolong kirim galon baru)..."></textarea>
                </div>

                <!-- Button Kirim Pengaduan (Dibuat Seperti Button Buat Ulasan, di Sebelah Kanan) -->
                <div class="flex justify-end pt-1">
                    <button type="button" 
                            onclick="kirimPengaduan()" 
                            class="inline-flex items-center px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-sm hover:shadow-md transition active:scale-95">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pengaduan
                    </button>
                </div>

            </div>

        </div>
    </section>

    <!-- SECTION: LOKASI & ULASAN -->
    <section id="lokasi" class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Lokasi & Akses Peta -->
            <div class="mb-14">
                <div class="max-w-3xl mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-900">Lokasi</h2>
                    <p class="text-sm text-slate-600 mt-1 leading-relaxed">
                        Kost Wisma S terletak di kawasan strategis dan tenang Perumahan Griya Karang Indah, Karangpucung, Purwokerto Selatan dengan akses cepat ke kampus, stasiun, fasilitas kesehatan, dan sentra kuliner harian.
                    </p>
                </div>

                <!-- Akses Google Maps Embed Full Width -->
                <div class="w-full">
                    <div class="bg-white p-2.5 sm:p-3 rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <iframe 
                            class="w-full h-96 rounded-lg border-0" 
                            src="https://maps.google.com/maps?q=Perumahan+Griya+Karang+Indah+Blok+S-15+RT+01+RW+12+Karangpucung+Purwokerto+Selatan+Banyumas+53142&t=&z=17&ie=UTF8&iwloc=&output=embed" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <div class="p-3 bg-slate-50 rounded-b-lg flex flex-col sm:flex-row justify-between items-center text-xs text-slate-600 gap-2 border-t border-slate-100">
                            <span class="flex items-center font-medium">
                                <i class="fa-solid fa-map-pin text-orange-600 mr-1.5 shrink-0"></i> Titik Lokasi: Perumahan Griya Karang Indah Blok S-15 RT 01 RW 12, Kel. Karangpucung, Kec. Purwokerto Selatan, Kab. Banyumas 53142
                            </span>
                            <a href="https://www.google.com/maps/search/?api=1&query=Perumahan+Griya+Karang+Indah+Blok+S-15+RT+01+RW+12+Karangpucung+Purwokerto+Selatan+Banyumas+53142" target="_blank" class="px-3 py-1.5 bg-orange-50 text-orange-700 hover:bg-orange-100 font-bold rounded-md transition flex items-center shrink-0">
                                <i class="fa-solid fa-arrow-up-right-from-square mr-1.5 text-[10px]"></i> Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ulasan Penghuni (Tepat di bawah Lokasi) -->
            <div class="pt-12 border-t border-slate-200">
                <div class="mb-8">
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-navy-900">Ulasan Penghuni</h3>
                    <p class="text-sm text-slate-500 mt-1">Pengalaman langsung dari para penghuni yang tinggal di Kost Wisma S.</p>
                </div>

                <!-- Wrapper Slider dengan Tombol Navigasi Kiri & Kanan -->
                <div class="relative group">
                    <!-- Tombol Prev di sebelah kiri ulasan -->
                    <button type="button" 
                            onclick="slideUlasan('prev')" 
                            class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white hover:bg-navy-900 text-navy-900 hover:text-white border border-slate-300 shadow-md hover:shadow-lg flex items-center justify-center transition-all duration-200 active:scale-95 focus:outline-none" 
                            title="Sebelumnya" 
                            aria-label="Sebelumnya">
                        <i class="fas fa-chevron-left text-xs sm:text-sm"></i>
                    </button>

                    <!-- Container Slider Ulasan Penghuni -->
                    <div id="ulasanSliderContainer" class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory py-2 pb-4 cursor-grab select-none px-1">
                        <!-- Ulasan 1 -->
                        <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] shrink-0 snap-start">
                            <div>
                                <div class="flex text-amber-500 text-xs space-x-1 mb-3">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-slate-600 text-xs leading-relaxed mb-4">"Sudah hampir 1 tahun ngekost di sini. Pengelolanya sangat tanggap, kalau ada lampu mati atau AC kurang dingin langsung diperbaiki hari itu juga. Suasana tenang cocok buat kerja remote dan belajar."</p>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 border-t border-slate-100">
                                <div class="w-8 h-8 rounded-full bg-navy-800 text-white flex items-center justify-center font-bold text-xs">AP</div>
                                <div>
                                    <p class="font-bold text-xs text-navy-900">Andi Pratama</p>
                                    <p class="text-[10px] text-slate-500">Penghuni Kamar 102 • Karyawan Swasta</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ulasan 2 -->
                        <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] shrink-0 snap-start">
                            <div>
                                <div class="flex text-amber-500 text-xs space-x-1 mb-3">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-slate-600 text-xs leading-relaxed mb-4">"Parkiran mobil lega dan aman karena gerbang selalu ditutup plus ada CCTV 24 jam. Lokasinya pas banget di Purwokerto, cari makan gampang jalan kaki tinggal pilih."</p>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 border-t border-slate-100">
                                <div class="w-8 h-8 rounded-full bg-orange-600 text-white flex items-center justify-center font-bold text-xs">SR</div>
                                <div>
                                    <p class="font-bold text-xs text-navy-900">Siti Rahma</p>
                                    <p class="text-[10px] text-slate-500">Penghuni Kamar 205 • Mahasiswi</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ulasan 3 -->
                        <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] shrink-0 snap-start">
                            <div>
                                <div class="flex text-amber-500 text-xs space-x-1 mb-3">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-slate-600 text-xs leading-relaxed mb-4">"Sistem pencatatan pembayarannya rapi dan bisa cek status lewat portal web ini. Kamar mandinya bersih dengan shower lancar. Sangat rekomendasi di Purwokerto."</p>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 border-t border-slate-100">
                                <div class="w-8 h-8 rounded-full bg-navy-700 text-white flex items-center justify-center font-bold text-xs">RH</div>
                                <div>
                                    <p class="font-bold text-xs text-navy-900">Rian Hidayat</p>
                                    <p class="text-[10px] text-slate-500">Penghuni Kamar 108 • Karyawan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ulasan 4 -->
                        <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] shrink-0 snap-start">
                            <div>
                                <div class="flex text-amber-500 text-xs space-x-1 mb-3">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-slate-600 text-xs leading-relaxed mb-4">"Sebagai dokter muda yang sering dinas malam, suasana kost di Griya Karang Indah ini sangat tenang dan tidak bising. Akses kunci mandiri sangat memudahkan saat pulang dini hari."</p>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 border-t border-slate-100">
                                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">DM</div>
                                <div>
                                    <p class="font-bold text-xs text-navy-900">dr. Dina Marlina</p>
                                    <p class="text-[10px] text-slate-500">Penghuni Kamar 201 • Dokter Muda</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ulasan 5 -->
                        <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] shrink-0 snap-start">
                            <div>
                                <div class="flex text-amber-500 text-xs space-x-1 mb-3">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-slate-600 text-xs leading-relaxed mb-4">"Koneksi WiFi-nya kencang dan stabil buat kebutuhan meeting Zoom dan kerja remote. Meteran listrik token mandiri juga sangat adil sesuai pemakaian perangkat pribadi."</p>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 border-t border-slate-100">
                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs">FN</div>
                                <div>
                                    <p class="font-bold text-xs text-navy-900">Fajar Nugroho</p>
                                    <p class="text-[10px] text-slate-500">Penghuni Kamar 105 • Software Engineer</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ulasan 6 -->
                        <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] shrink-0 snap-start">
                            <div>
                                <div class="flex text-amber-500 text-xs space-x-1 mb-3">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-slate-600 text-xs leading-relaxed mb-4">"Fasilitas dapur bersamanya sangat membantu buat masak sehari-hari, ada kulkas dan kompor gas. Lingkungan kost bersih karena koridor rutin dibersihkan pengelola."</p>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 border-t border-slate-100">
                                <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-xs">BS</div>
                                <div>
                                    <p class="font-bold text-xs text-navy-900">Budi Santoso, M.Si.</p>
                                    <p class="text-[10px] text-slate-500">Penghuni Kamar 210 • Dosen Universitas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ulasan 7 -->
                        <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] shrink-0 snap-start">
                            <div>
                                <div class="flex text-amber-500 text-xs space-x-1 mb-3">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-slate-600 text-xs leading-relaxed mb-4">"Kasur spring bed dan perabotan kamarnya berkualitas, tidak asal-asalan. Kamarnya wangi dan ventilasi udara bagus jadi tidak pengap. Nyaman banget berasa rumah sendiri."</p>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 border-t border-slate-100">
                                <div class="w-8 h-8 rounded-full bg-rose-600 text-white flex items-center justify-center font-bold text-xs">NP</div>
                                <div>
                                    <p class="font-bold text-xs text-navy-900">Nadia Putri</p>
                                    <p class="text-[10px] text-slate-500">Penghuni Kamar 104 • Pegawai Perbankan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Next di sebelah kanan ulasan -->
                    <button type="button" 
                            onclick="slideUlasan('next')" 
                            class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white hover:bg-navy-900 text-navy-900 hover:text-white border border-slate-300 shadow-md hover:shadow-lg flex items-center justify-center transition-all duration-200 active:scale-95 focus:outline-none" 
                            title="Selanjutnya" 
                            aria-label="Selanjutnya">
                        <i class="fas fa-chevron-right text-xs sm:text-sm"></i>
                    </button>
                </div>

                <!-- Tombol Buat Ulasan di Bawah Slider Ulasan (Sebelah Kanan) -->
                <div class="mt-6 flex justify-end">
                    <button type="button" 
                            onclick="handleBuatUlasan()" 
                            class="inline-flex items-center px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-sm hover:shadow-md transition active:scale-95">
                        <i class="fa-solid fa-pen-to-square mr-2"></i> Buat Ulasan
                    </button>
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-navy-900 text-slate-300 py-12 border-t border-navy-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                
                <!-- Brand & Tagline (Lebih leluasa di kiri) -->
                <div class="md:col-span-4 lg:col-span-5 space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-lg p-0.5 shadow flex items-center justify-center overflow-hidden shrink-0">
                            <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-full h-full object-contain">
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-[11px] font-extrabold text-orange-400 tracking-widest uppercase">Kost</span>
                            <span class="text-lg font-extrabold text-white tracking-tight leading-tight">WISMA S</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed max-w-sm">
                        Kost Nyaman, Bersih & Strategis di Lingkungan Aman.
                    </p>
                </div>

                <!-- MENU (Digeser ke kanan) -->
                <div class="md:col-span-2 lg:col-span-2 md:pl-4 lg:pl-8">
                    <h4 class="text-xs font-bold text-white uppercase mb-3 tracking-wider">MENU</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#beranda" class="hover:text-orange-400 transition">Beranda</a></li>
                        <li><a href="#kamar" class="hover:text-orange-400 transition">Kamar</a></li>
                        <li><a href="#aturan" class="hover:text-orange-400 transition">Ketentuan</a></li>
                        <li><a href="#pengaduan" class="hover:text-orange-400 transition">Pengaduan</a></li>
                        <li><a href="#lokasi" class="hover:text-orange-400 transition">Lokasi</a></li>
                    </ul>
                </div>

                <!-- LAYANAN (Digeser ke kanan bersama MENU) -->
                <div class="md:col-span-2 lg:col-span-2 md:pl-4 lg:pl-8">
                    <h4 class="text-xs font-bold text-white uppercase mb-3 tracking-wider">Layanan</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#kamar" onclick="handleFooterBooking(event)" class="hover:text-orange-400 transition">Booking</a></li>
                        <li><a href="#pengaduan" onclick="handleFooterPengaduan(event)" class="hover:text-orange-400 transition">Pengaduan</a></li>
                        @auth
                            @if(Auth::user()->isOwner())
                                <li><a href="javascript:void(0)" onclick="openOwnerDashboard()" class="hover:text-orange-400 transition">Portal Owner</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <!-- INFORMASI -->
                <div class="md:col-span-4 lg:col-span-3">
                    <h4 class="text-xs font-bold text-white uppercase mb-3 tracking-wider">INFORMASI</h4>
                    <div class="space-y-2 text-xs">
                        <p class="flex items-start"><i class="fa-solid fa-location-dot text-orange-500 mr-2 mt-0.5 shrink-0"></i> <span>Griya Karang Indah Blok S-15, Karangpucung, Purwokerto Selatan 53142</span></p>
                        <p class="flex items-center"><i class="fa-solid fa-phone text-orange-500 mr-2"></i> 0821-7890-1234</p>
                        <p class="flex items-center"><i class="fa-regular fa-envelope text-orange-500 mr-2"></i> info@wismas.com</p>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <!-- ========================================================================= -->
    <!-- MODAL AUTHENTICATION (LOGIN & SIGN UP) -->
    <!-- ========================================================================= -->
    <div id="authModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 sm:p-7 shadow-2xl relative border border-slate-200 max-h-[92vh] overflow-y-auto">
            
            <button type="button" onclick="closeAuthModal()" class="absolute top-4 right-4 text-slate-400 hover:text-navy-900 w-8 h-8 rounded bg-slate-100 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Modal Header Brand -->
            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-white rounded-xl p-1 shadow-sm flex items-center justify-center mx-auto mb-2 border border-slate-200">
                    <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-full h-full object-contain">
                </div>
                <h3 class="text-xl font-black text-navy-900" id="authModalTitle">Masuk</h3>
                <p class="text-xs text-slate-500 mt-1" id="authModalSubtitle">Masuk untuk melanjutkan booking kamar ini.</p>
            </div>

            <!-- Tab Switcher (Masuk / Daftar) -->
            <div class="flex border-b border-slate-200 mb-5">
                <button type="button" id="tabLogin" onclick="switchAuthTab('login')" class="w-1/2 pb-2.5 text-xs font-bold border-b-2 border-orange-600 text-orange-600 transition">
                    Masuk
                </button>
                <button type="button" id="tabRegister" onclick="switchAuthTab('register')" class="w-1/2 pb-2.5 text-xs font-bold border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition">
                    Daftar Akun
                </button>
            </div>

            <!-- Form Content -->
            <form id="authForm" onsubmit="handleAuthSubmit(event)" enctype="multipart/form-data" class="space-y-4">
                
                <input type="hidden" id="authMode" value="login">
                <input type="hidden" id="authRole" value="penghuni">

                <!-- Register Only: Nama Lengkap -->
                <div id="registerFieldsName" class="hidden">
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-regular fa-user text-xs"></i>
                        </span>
                        <input type="text" id="regName" class="w-full pl-9 pr-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-navy-600 focus:outline-none" placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <!-- Input Email -->
                <div>
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="authEmail" required class="w-full pl-9 pr-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-navy-600 focus:outline-none" placeholder="email@gmail.com">
                    </div>
                </div>

                <!-- Register Only: No WhatsApp -->
                <div id="registerFieldsPhone" class="hidden">
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Nomor WhatsApp</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-brands fa-whatsapp text-xs"></i>
                        </span>
                        <input type="tel" id="regPhone" class="w-full pl-9 pr-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-navy-600 focus:outline-none" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" id="authPassword" required class="w-full pl-9 pr-9 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-navy-600 focus:outline-none" placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility('authPassword')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Register Only: Upload File KTP -->
                <div id="registerFieldsKtp" class="hidden">
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Foto KTP / Fotokopi KTP</label>
                    <div class="border-2 border-dashed border-slate-300 hover:border-orange-500 rounded-xl p-3 text-center cursor-pointer transition relative bg-slate-50">
                        <input type="file" id="regKtp" accept="image/*,.pdf" onchange="previewKtpFileName(this)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                        <div class="space-y-1">
                            <i class="fa-solid fa-id-card text-2xl text-orange-500"></i>
                            <p class="text-xs font-bold text-navy-900" id="regKtpLabel">Pilih file foto KTP</p>
                            <p class="text-[10px] text-slate-400">Format JPG, PNG, atau PDF (Maks. 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="btnAuthSubmit" class="w-full py-2.5 bg-orange-600 hover:bg-orange-700 active:scale-95 text-white font-bold text-xs rounded-xl shadow transition flex items-center justify-center space-x-1.5">
                    <i class="fa-solid fa-right-to-bracket text-xs"></i>
                    <span>Masuk Sekarang</span>
                </button>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL SPESIFIKASI & RINCIAN FASILITAS KAMAR -->
    <!-- ========================================================================= -->
    <div id="roomDetailModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-7 shadow-2xl relative border border-slate-200 max-h-[92vh] overflow-y-auto">
            
            <button onclick="closeRoomDetailModal()" class="absolute top-4 right-4 text-slate-400 hover:text-navy-900 w-8 h-8 rounded bg-slate-100 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Header Modal -->
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-200 mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center font-extrabold text-lg">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h3 class="text-lg font-extrabold text-navy-900" id="detailRoomNumber">Kamar 101</h3>
                        <span id="detailRoomBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Tersedia</span>
                    </div>
                    <p class="text-xs text-orange-600 font-semibold" id="detailRoomType">Tipe Standard</p>
                </div>
            </div>

            <!-- Foto Kamar -->
            <div class="mb-5 rounded-xl overflow-hidden border border-slate-200">
                <img id="detailRoomImage" src="{{ asset('images/foto-kost.jpg') }}" alt="Foto Kamar" class="w-full h-48 sm:h-56 object-cover">
            </div>

            <!-- Harga & Status -->
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <span class="text-[11px] text-slate-500 font-medium block">Tarif Sewa Kamar</span>
                    <span class="text-lg font-extrabold text-navy-900" id="detailRoomPrice">Rp 1.500.000</span>
                    <span class="text-xs text-slate-500 font-normal"> / bulan</span>
                </div>
                <div id="detailActionContainer">
                    <!-- Tombol Booking Kamar -->
                </div>
            </div>

            <!-- Spesifikasi Rincian Fasilitas Kamar -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-navy-900 uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-list-check text-orange-600 mr-2"></i> Spesifikasi & Rincian Fasilitas Kamar
                </h4>

                <!-- Grid Spesifikasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs text-slate-700">
                    <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-start space-x-2.5 shadow-sm">
                        <i class="fa-solid fa-ruler-combined text-orange-600 mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold text-navy-900 block">Luas & Dimensi</span>
                            <span class="text-slate-500 text-[11px]">3 x 4 Meter (Kamar Lega)</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-start space-x-2.5 shadow-sm">
                        <i class="fa-solid fa-bath text-orange-600 mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold text-navy-900 block">Kamar Mandi</span>
                            <span class="text-slate-500 text-[11px]">Kamar Mandi Dalam + Kloset Duduk & Shower</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-start space-x-2.5 shadow-sm">
                        <i class="fa-solid fa-snowflake text-orange-600 mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold text-navy-900 block">Pendingin Ruangan (AC)</span>
                            <span class="text-slate-500 text-[11px]">AC Dingin & Hemat Listrik</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-start space-x-2.5 shadow-sm">
                        <i class="fa-solid fa-bed text-orange-600 mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold text-navy-900 block">Tempat Tidur</span>
                            <span class="text-slate-500 text-[11px]">Springbed Premium + Bantal & Sprei</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-start space-x-2.5 shadow-sm">
                        <i class="fa-solid fa-chair text-orange-600 mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold text-navy-900 block">Area Belajar & Kerja</span>
                            <span class="text-slate-500 text-[11px]">Meja Kerja, Kursi & Stop Kontak Ganda</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-start space-x-2.5 shadow-sm">
                        <i class="fa-solid fa-door-closed text-orange-600 mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold text-navy-900 block">Lemari Pakaian</span>
                            <span class="text-slate-500 text-[11px]">Lemari 2 Pintu Luas + Cermin Rias</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-start space-x-2.5 shadow-sm">
                        <i class="fa-solid fa-wifi text-orange-600 mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold text-navy-900 block">Internet Wi-Fi</span>
                            <span class="text-slate-500 text-[11px]">High Speed Wi-Fi 50 Mbps Tanpa Batas</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-start space-x-2.5 shadow-sm">
                        <i class="fa-solid fa-bolt text-orange-600 mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold text-navy-900 block">Kelistrikan Kamar</span>
                            <span class="text-slate-500 text-[11px]">Token Mandiri (900 VA)</span>
                        </div>
                    </div>
                </div>

                <!-- Fasilitas Bersama Kost -->
                <div class="p-3.5 bg-orange-50/60 border border-orange-200/70 rounded-xl text-xs text-orange-950">
                    <p class="font-bold mb-1 flex items-center">
                        <i class="fa-solid fa-circle-check text-orange-600 mr-1.5"></i> Termasuk Fasilitas Bersama Kost:
                    </p>
                    <p class="text-[11px] text-orange-900 leading-relaxed">
                        Dispenser air minum galon gratis, dapur bersama & kulkas, tempat jemuran terlindung hujan, parkir motor & mobil aman di dalam pagar, dan pengawasan kamera CCTV 24 Jam.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL DASHBOARD PELANGGAN / PENYEWA -->
    <!-- ========================================================================= -->
    <div id="tenantDashboardModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl relative border border-slate-200">
            
            <div class="flex justify-between items-center pb-4 border-b border-slate-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy-900 text-orange-400 rounded-lg flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-navy-900" id="tenantWelcomeName">Portal Penghuni</h3>
                        <p class="text-xs text-slate-500">Kelola informasi sewa kamar dan pembayaran Anda</p>
                    </div>
                </div>
                <button onclick="closeDashboard('tenant')" class="text-slate-400 hover:text-navy-900 w-8 h-8 rounded bg-slate-100 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="mt-6 space-y-6">
                <!-- Status Sewa Aktif Card -->
                <div class="bg-navy-900 text-white p-5 rounded-xl border border-navy-800" id="tenantRoomCard">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <span class="px-2.5 py-0.5 bg-emerald-600 text-white rounded text-[11px] font-bold">Status Sewa: Aktif</span>
                            <h4 class="text-xl font-extrabold mt-2 text-white" id="tenantRoomNumber">Kamar 102 - Executive Deluxe</h4>
                            <p class="text-xs text-slate-300 mt-1"><i class="fa-regular fa-calendar mr-1.5 text-orange-400"></i> Jatuh Tempo Berikutnya: 15 Oktober 2026</p>
                        </div>
                        <div class="bg-navy-800 p-3 rounded-lg border border-navy-700 text-right min-w-[140px]">
                            <p class="text-[11px] text-slate-400">Sewa Bulanan</p>
                            <p class="text-lg font-extrabold text-orange-400" id="tenantRoomPrice">Rp 1.500.000</p>
                        </div>
                    </div>
                </div>

                <!-- Two-Column Cards: Unpaid Bill & History -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <!-- Tagihan Belum Dibayar -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h4 class="font-bold text-navy-900 text-xs mb-3 flex items-center uppercase tracking-wider">
                            <i class="fa-solid fa-file-invoice text-orange-600 mr-2"></i> Tagihan Belum Dibayar
                        </h4>
                        
                        <div id="pendingPaymentsList" class="space-y-2">
                            <div class="bg-white p-3.5 rounded-lg border border-slate-200 flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-xs text-navy-900">Sewa Bulan Oktober 2026</p>
                                    <p class="text-[11px] text-slate-500">Jatuh Tempo: 15 Okt 2026</p>
                                    <p class="text-xs font-bold text-orange-600 mt-1">Rp 1.500.000</p>
                                </div>
                                <span class="px-2 py-1 bg-amber-100 text-amber-800 text-[10px] font-bold rounded">Menunggu Bayar</span>
                            </div>
                        </div>

                        <button onclick="simulasiBayar()" class="w-full mt-3 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-lg transition flex items-center justify-center">
                            <i class="fa-solid fa-receipt mr-1.5"></i> Konfirmasi Bukti Transfer
                        </button>
                    </div>

                    <!-- Riwayat Pembayaran -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h4 class="font-bold text-navy-900 text-xs mb-3 flex items-center uppercase tracking-wider">
                            <i class="fa-solid fa-clock-rotate-left text-navy-700 mr-2"></i> Riwayat Pembayaran Lunas
                        </h4>
                        
                        <div class="space-y-2" id="paidPaymentsList">
                            <div class="bg-white p-3 rounded-lg border border-slate-200 flex justify-between items-center text-xs">
                                <div>
                                    <p class="font-bold text-navy-900">Sewa Bulan September 2026</p>
                                    <p class="text-[10px] text-slate-400">14 Sep 2026 • BCA Flash</p>
                                </div>
                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 font-bold rounded text-[10px]">Lunas</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Rekening Pembayaran Kost -->
                <div class="p-4 bg-orange-50 border border-orange-200 rounded-xl text-xs text-slate-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <p class="font-bold text-navy-900 mb-0.5">Rekening Resmi Pembayaran Kost:</p>
                        <p class="text-slate-600">Bank Central Asia (BCA) : <strong>8820-1928-334</strong> a/n <strong>Pemilik Wisma S</strong></p>
                    </div>
                    <a href="https://wa.me/6281234567890?text=Halo%20Pengelola%20Kost%20Wisma%20S,%20saya%20ingin%20konfirmasi%20pembayaran" target="_blank" class="px-3.5 py-2 bg-navy-900 text-white rounded-lg text-xs font-bold hover:bg-navy-800 transition shrink-0">
                        Kirim Bukti WA
                    </a>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 pt-4 border-t border-slate-200 flex justify-end">
                <button onclick="logout()" class="px-4 py-2 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar dari Akun
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL DASHBOARD OWNER / PENGELOLA KOST -->
    <!-- ========================================================================= -->
    <div id="ownerDashboardModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl max-w-5xl w-full max-h-[92vh] overflow-y-auto p-6 sm:p-7 shadow-2xl relative border border-slate-200">
            
            <!-- Owner Header -->
            <div class="flex justify-between items-center pb-4 border-b border-slate-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy-900 text-orange-400 rounded-lg flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-navy-900">Portal Manajemen Pengelola - Wisma S</h3>
                        <p class="text-xs text-slate-500">Monitor okupansi kamar, verifikasi pembayaran penyewa, dan fasilitas</p>
                    </div>
                </div>
                <button onclick="closeDashboard('owner')" class="text-slate-400 hover:text-navy-900 w-8 h-8 rounded bg-slate-100 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Financial & Occupancy Summary (No neon gradients, clean metric cards) -->
            <div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    <p class="text-[11px] font-bold text-slate-500 uppercase">Pemasukan Bulan Ini</p>
                    <p class="text-xl font-extrabold text-navy-900 mt-1" id="ownerTotalRevenue">Rp 18.500.000</p>
                    <span class="text-[10px] text-emerald-600 font-semibold"><i class="fa-solid fa-check-circle mr-0.5"></i> Pembayaran Terverifikasi</span>
                </div>

                <div class="p-4 bg-orange-50 border border-orange-200 rounded-xl">
                    <p class="text-[11px] font-bold text-orange-800 uppercase">Tagihan Tertunda</p>
                    <p class="text-xl font-extrabold text-orange-950 mt-1" id="ownerPendingAmount">Rp 3.000.000</p>
                    <span class="text-[10px] text-orange-700 font-semibold"><i class="fa-solid fa-clock mr-0.5"></i> Menunggu Verifikasi</span>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    <p class="text-[11px] font-bold text-slate-500 uppercase">Tingkat Hunian</p>
                    <p class="text-xl font-extrabold text-navy-900 mt-1" id="ownerOccupiedCount">4 / 6 Kamar</p>
                    <span class="text-[10px] text-navy-700 font-semibold">Tingkat Okupansi 67%</span>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    <p class="text-[11px] font-bold text-slate-500 uppercase">Estimasi Bersih</p>
                    <p class="text-xl font-extrabold text-navy-900 mt-1">Rp 14.200.000</p>
                    <span class="text-[10px] text-slate-500 font-semibold">Setelah Beban Operasional</span>
                </div>
            </div>

            <!-- Tab Navigation (Navy & Orange) -->
            <div class="mt-6 border-b border-slate-200 flex space-x-6 text-xs font-bold">
                <button id="ownerTabRooms" onclick="switchOwnerTab('rooms')" class="pb-3 border-b-2 border-orange-600 text-orange-600">
                    <i class="fa-solid fa-door-open mr-1.5"></i> Manajemen Kamar
                </button>
                <button id="ownerTabFinances" onclick="switchOwnerTab('finances')" class="pb-3 text-slate-500 hover:text-navy-900">
                    <i class="fa-solid fa-receipt mr-1.5"></i> Verifikasi Pembayaran
                </button>
                <button id="ownerTabFacilities" onclick="switchOwnerTab('facilities')" class="pb-3 text-slate-500 hover:text-navy-900">
                    <i class="fa-solid fa-list-check mr-1.5"></i> Fasilitas Kost
                </button>
            </div>

            <!-- TAB 1: KELOLA KAMAR & STATUS KETERSEDIAAN -->
            <div id="ownerSectionRooms" class="mt-5">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-bold text-navy-900 text-xs uppercase tracking-wider">Status & Tarif Kamar</h4>
                    <span class="text-[11px] text-slate-500">Klik tombol status atau pensil untuk mengedit</span>
                </div>

                <div class="overflow-x-auto border border-slate-200 rounded-lg">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-navy-900 text-white uppercase text-[10px] tracking-wider">
                                <th class="p-3">Nomor Kamar</th>
                                <th class="p-3">Tipe</th>
                                <th class="p-3">Harga / Bulan</th>
                                <th class="p-3">Status Saat Ini</th>
                                <th class="p-3 text-center">Tindakan Pengelola</th>
                            </tr>
                        </thead>
                        <tbody id="ownerRoomTable" class="divide-y divide-slate-200">
                            <!-- Populated via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: VERIFIKASI TRANSAKSI KEUANGAN -->
            <div id="ownerSectionFinances" class="mt-5 hidden">
                <h4 class="font-bold text-navy-900 text-xs uppercase tracking-wider mb-3">Daftar Pengajuan & Verifikasi Bukti Bayar</h4>
                <div class="space-y-3" id="ownerPendingPaymentsContainer">
                    <!-- Populated via JS -->
                </div>
            </div>

            <!-- TAB 3: KELOLA FASILITAS -->
            <div id="ownerSectionFacilities" class="mt-5 hidden">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-bold text-navy-900 text-xs uppercase tracking-wider">Fasilitas Kost Aktif</h4>
                    <button onclick="tambahFasilitasBaru()" class="px-3 py-1.5 bg-orange-600 text-white text-xs font-bold rounded hover:bg-orange-700 transition">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Fasilitas
                    </button>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3" id="ownerFacilityList">
                    <!-- Populated via JS -->
                </div>
            </div>

            <!-- Logout Owner -->
            <div class="mt-6 pt-4 border-t border-slate-200 flex justify-end">
                <button onclick="logout()" class="px-4 py-2 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar Portal Pengelola
                </button>
            </div>

        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL BUAT ULASAN PENGHUNI -->
    <!-- ========================================================================= -->
    <div id="reviewModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 sm:p-7 shadow-2xl relative border border-slate-200">
            <button onclick="closeReviewModal()" class="absolute top-4 right-4 text-slate-400 hover:text-navy-900 w-8 h-8 rounded bg-slate-100 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mb-5">
                <span class="text-xs font-bold uppercase tracking-wider text-orange-600">Ulasan Penghuni</span>
                <h3 class="text-lg font-bold text-navy-900 mt-0.5">Tulis Pengalaman Kost Anda</h3>
                <p class="text-xs text-slate-500 mt-1">Bagikan ulasan Anda selama tinggal di Kost Wisma S Purwokerto.</p>
            </div>

            <form id="formReview" onsubmit="handleReviewSubmit(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Rating Bintang</label>
                    <div class="flex items-center space-x-1.5 text-amber-500 text-2xl select-none" id="starRatingContainer">
                        <i class="fa-solid fa-star star-btn cursor-pointer transition transform hover:scale-110" onclick="setRating(1)"></i>
                        <i class="fa-solid fa-star star-btn cursor-pointer transition transform hover:scale-110" onclick="setRating(2)"></i>
                        <i class="fa-solid fa-star star-btn cursor-pointer transition transform hover:scale-110" onclick="setRating(3)"></i>
                        <i class="fa-solid fa-star star-btn cursor-pointer transition transform hover:scale-110" onclick="setRating(4)"></i>
                        <i class="fa-solid fa-star star-btn cursor-pointer transition transform hover:scale-110" onclick="setRating(5)"></i>
                        <span id="ratingValueText" class="text-xs font-bold text-slate-600 ml-2">5 dari 5 Bintang</span>
                    </div>
                    <input type="hidden" id="reviewRating" value="5">
                </div>

                <div>
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Pekerjaan / Profesi</label>
                    <input type="text" id="reviewOccupation" required placeholder="Contoh: Mahasiswi / Karyawan Swasta" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-navy-600 focus:outline-none text-xs font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Kamar yang Ditempati</label>
                    <input type="text" id="reviewRoom" placeholder="Contoh: Kamar 104" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-navy-600 focus:outline-none text-xs font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Isi Ulasan</label>
                    <textarea id="reviewText" rows="4" required placeholder="Ceritakan kenyamanan fasilitas, kebersihan, respon pengelola, dan suasana tinggal di Kost Wisma S..." class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-navy-600 focus:outline-none text-xs font-medium leading-relaxed"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg shadow-sm transition text-xs flex items-center justify-center">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- JAVASCRIPT LOGIC & INTERACTIONS -->
    <!-- ========================================================================= -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentRole = 'penghuni';

        // Filter Rooms by Tabs
        function filterRooms(status) {
            document.querySelectorAll('.filter-tab').forEach(btn => {
                btn.classList.remove('bg-navy-900', 'text-white', 'active');
                btn.classList.add('text-slate-700');
            });
            event.target.classList.add('bg-navy-900', 'text-white', 'active');
            event.target.classList.remove('text-slate-700');

            document.getElementById('filterStatusSelect').value = status;
            applyCustomFilters();
        }

        // Custom Multi-Parameter Filter (Type, Status, Price Range)
        function applyCustomFilters() {
            const typeFilter = document.getElementById('filterTypeSelect').value;
            const statusFilter = document.getElementById('filterStatusSelect').value;
            const priceFilter = document.getElementById('filterPriceSelect').value;

            const roomCards = document.querySelectorAll('.room-card');
            let visibleCount = 0;

            roomCards.forEach(card => {
                const roomStatus = (card.dataset.status || '').trim().toLowerCase();
                const roomPrice = parseInt(card.dataset.price) || 0;
                const roomType = (card.dataset.type || '').trim().toLowerCase();

                let matchStatus = (statusFilter === 'all' || roomStatus === statusFilter.toLowerCase());
                let matchType = (typeFilter === 'all' || roomType.includes(typeFilter.toLowerCase()) || typeFilter.toLowerCase().includes(roomType));
                
                let matchPrice = true;
                if (priceFilter === 'under13') {
                    matchPrice = (roomPrice < 1300000);
                } else if (priceFilter === '13to16') {
                    matchPrice = (roomPrice >= 1300000 && roomPrice <= 1600000);
                } else if (priceFilter === 'above16') {
                    matchPrice = (roomPrice > 1600000);
                }

                if (matchStatus && matchType && matchPrice) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const notice = document.getElementById('noRoomsNotice');
            if (visibleCount === 0) {
                notice.classList.remove('hidden');
            } else {
                notice.classList.add('hidden');
            }
        }

        // Custom Dropdown Handlers
        function toggleCustomDropdown(type) {
            const types = ['type', 'status', 'price'];
            types.forEach(t => {
                const cap = t.charAt(0).toUpperCase() + t.slice(1);
                const menu = document.getElementById(`menuFilter${cap}`);
                const arrow = document.getElementById(`arrowFilter${cap}`);
                if (t === type) {
                    const isHidden = menu.classList.contains('hidden');
                    menu.classList.toggle('hidden');
                    if (arrow) arrow.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
                } else {
                    if (menu) menu.classList.add('hidden');
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                }
            });
        }

        function selectCustomOption(filterType, val, labelText) {
            const cap = filterType.charAt(0).toUpperCase() + filterType.slice(1);
            
            // 1. Update hidden input
            const input = document.getElementById(`filter${cap}Select`);
            if (input) input.value = val;

            // 2. Update trigger display (1 kalimat text saja)
            const display = document.getElementById(`displayFilter${cap}`);
            if (display) {
                display.innerText = labelText;
            }

            // 3. Update active item highlight
            const menu = document.getElementById(`menuFilter${cap}`);
            if (menu) {
                menu.querySelectorAll('[class*="-opt-"]').forEach(item => {
                    const itemVal = item.dataset.val;
                    if (itemVal === String(val) || item.classList.contains(`${filterType}-opt-${val}`)) {
                        item.classList.add('bg-slate-100');
                    } else {
                        item.classList.remove('bg-slate-100');
                    }
                });
                menu.classList.add('hidden');
            }

            // 4. Reset arrow
            const arrow = document.getElementById(`arrowFilter${cap}`);
            if (arrow) arrow.style.transform = 'rotate(0deg)';

            // 5. Apply filter immediately
            applyCustomFilters();
        }

        // Close dropdown when clicked outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.filter-dropdown-wrapper')) {
                ['Type', 'Status', 'Price'].forEach(cap => {
                    const menu = document.getElementById(`menuFilter${cap}`);
                    const arrow = document.getElementById(`arrowFilter${cap}`);
                    if (menu) menu.classList.add('hidden');
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                });
            }
        });

        function resetFilters() {
            document.getElementById('filterTypeSelect').value = 'all';
            document.getElementById('filterStatusSelect').value = 'all';
            document.getElementById('filterPriceSelect').value = 'all';

            // Reset custom dropdown trigger labels
            const dispType = document.getElementById('displayFilterType');
            const dispStatus = document.getElementById('displayFilterStatus');
            const dispPrice = document.getElementById('displayFilterPrice');

            if (dispType) dispType.innerText = 'Semua Tipe Kamar';
            if (dispStatus) dispStatus.innerText = 'Semua Status';
            if (dispPrice) dispPrice.innerText = 'Semua Harga';

            // Reset active backgrounds
            ['type', 'status', 'price'].forEach(f => {
                const cap = f.charAt(0).toUpperCase() + f.slice(1);
                const menu = document.getElementById(`menuFilter${cap}`);
                if (menu) {
                    menu.querySelectorAll('[class*="-opt-"]').forEach(item => {
                        if (item.classList.contains(`${f}-opt-all`)) {
                            item.classList.add('bg-slate-100');
                        } else {
                            item.classList.remove('bg-slate-100');
                        }
                    });
                }
            });

            document.querySelectorAll('.filter-tab').forEach(btn => {
                btn.classList.remove('bg-navy-900', 'text-white', 'active');
                btn.classList.add('text-slate-700');
            });
            const allTab = document.querySelector('.filter-tab');
            if (allTab) {
                allTab.classList.add('bg-navy-900', 'text-white', 'active');
                allTab.classList.remove('text-slate-700');
            }

            applyCustomFilters();
        }

        // Auth Modal Operations
        function openAuthModal(mode = 'login', role = 'penghuni') {
            const modal = document.getElementById('authModal');
            if (modal) modal.classList.remove('hidden');
            switchAuthTab(mode);
        }

        function closeAuthModal() {
            const modal = document.getElementById('authModal');
            if (modal) modal.classList.add('hidden');
        }

        // Room Detail & Specification Navigation
        function handleRoomClick(roomId) {
            window.location.href = '/kamar/' + roomId;
        }

        function openRoomDetailModal(roomId, roomNumber, roomType, roomPrice, roomStatus, features) {
            document.getElementById('detailRoomNumber').textContent = `Kamar ${roomNumber}`;
            document.getElementById('detailRoomType').textContent = roomType;
            document.getElementById('detailRoomPrice').textContent = 'Rp ' + Number(roomPrice).toLocaleString('id-ID');
            
            const badge = document.getElementById('detailRoomBadge');
            const actionContainer = document.getElementById('detailActionContainer');

            if (roomStatus === 'available') {
                badge.className = "px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200";
                badge.textContent = "Tersedia";
                actionContainer.innerHTML = `
                    <button onclick="closeRoomDetailModal(); handleBooking(${roomId}, '${roomNumber}')" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow-sm hover:shadow transition flex items-center">
                        <i class="fa-solid fa-calendar-check mr-1.5"></i> Booking Kamar Ini
                    </button>
                `;
            } else {
                badge.className = "px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-300";
                badge.textContent = "Kamar Terisi";
                actionContainer.innerHTML = `
                    <span class="px-3.5 py-2 bg-slate-200 text-slate-500 font-bold text-xs rounded-xl flex items-center">
                        <i class="fa-solid fa-lock mr-1.5"></i> Kamar Terisi
                    </span>
                `;
            }

            document.getElementById('roomDetailModal').classList.remove('hidden');
        }

        function closeRoomDetailModal() {
            const modal = document.getElementById('roomDetailModal');
            if (modal) modal.classList.add('hidden');
        }

        function setAuthRole(role = 'penghuni') {
            currentRole = role;
        }

        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            if (!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function previewKtpFileName(input) {
            const label = document.getElementById('regKtpLabel');
            if (input && input.files && input.files[0]) {
                label.textContent = "File: " + input.files[0].name;
                label.classList.add('text-emerald-700');
            }
        }

        function switchAuthTab(mode) {
            const authModeInput = document.getElementById('authMode');
            if (authModeInput) authModeInput.value = mode;

            const tabLogin = document.getElementById('tabLogin');
            const tabRegister = document.getElementById('tabRegister');
            const regName = document.getElementById('registerFieldsName');
            const regPhone = document.getElementById('registerFieldsPhone');
            const regKtp = document.getElementById('registerFieldsKtp');
            const title = document.getElementById('authModalTitle');
            const subtitle = document.getElementById('authModalSubtitle');
            const btnSubmit = document.getElementById('btnAuthSubmit');

            if (mode === 'login') {
                if (tabLogin) tabLogin.className = "w-1/2 pb-2.5 text-xs font-bold border-b-2 border-orange-600 text-orange-600 transition";
                if (tabRegister) tabRegister.className = "w-1/2 pb-2.5 text-xs font-bold border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition";
                if (regName) regName.classList.add('hidden');
                if (regPhone) regPhone.classList.add('hidden');
                if (regKtp) regKtp.classList.add('hidden');
                if (title) title.textContent = "Masuk";
                if (subtitle) subtitle.textContent = "Masuk untuk melanjutkan booking kamar ini.";
                if (btnSubmit) btnSubmit.innerHTML = '<i class="fa-solid fa-right-to-bracket text-xs mr-1.5"></i><span>Masuk Sekarang</span>';
            } else {
                if (tabRegister) tabRegister.className = "w-1/2 pb-2.5 text-xs font-bold border-b-2 border-orange-600 text-orange-600 transition";
                if (tabLogin) tabLogin.className = "w-1/2 pb-2.5 text-xs font-bold border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition";
                if (regName) regName.classList.remove('hidden');
                if (regPhone) regPhone.classList.remove('hidden');
                if (regKtp) regKtp.classList.remove('hidden');
                if (title) title.textContent = "Daftar Akun";
                if (subtitle) subtitle.textContent = "Lengkapi data untuk proses pemesanan kamar.";
                if (btnSubmit) btnSubmit.innerHTML = '<i class="fa-solid fa-user-plus text-xs mr-1.5"></i><span>Daftar Sekarang</span>';
            }
        }

        async function handleAuthSubmit(e) {
            e.preventDefault();
            const mode = document.getElementById('authMode').value;
            const endpoint = mode === 'login' ? '/api/login' : '/api/register';
            let fetchOptions = {};

            if (mode === 'login') {
                const email = document.getElementById('authEmail').value.trim();
                const password = document.getElementById('authPassword').value;
                fetchOptions = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                };
            } else {
                const formData = new FormData();
                formData.append('name', document.getElementById('regName').value.trim());
                formData.append('email', document.getElementById('authEmail').value.trim());
                formData.append('phone', document.getElementById('regPhone').value.trim());
                formData.append('password', document.getElementById('authPassword').value);
                formData.append('role', 'penghuni');

                const ktpInput = document.getElementById('regKtp');
                if (ktpInput && ktpInput.files && ktpInput.files[0]) {
                    formData.append('ktp_file', ktpInput.files[0]);
                }

                fetchOptions = {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                };
            }

            try {
                const res = await fetch(endpoint, fetchOptions);
                const data = await res.json();
                if (res.ok && data.success) {
                    closeAuthModal();
                    alert(data.message);
                    if (data.user && (data.user.role === 'penghuni' || data.user.role === 'tenant')) {
                        sessionStorage.setItem('autoOpenTenantDashboard', 'true');
                    }
                    location.reload();
                } else {
                    let errMsg = data.message || 'Gagal autentikasi.';
                    if (data.errors) {
                        const errorList = Object.values(data.errors).flat();
                        if (errorList.length > 0) errMsg = errorList.join('\n');
                    }
                    alert(errMsg);
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan atau server.');
            }
        }

        async function logout() {
            try {
                const res = await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    location.reload();
                }
            } catch (err) {
                console.error(err);
            }
        }

        // Tenant Dashboard Functions
        async function openTenantDashboard() {
            try {
                const res = await fetch('/api/tenant/dashboard', {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.user) {
                    document.getElementById('tenantWelcomeName').innerText = `Portal Penghuni - ${data.user.name}`;
                    if (data.booking && data.booking.room) {
                        document.getElementById('tenantRoomNumber').innerText = `${data.booking.room.number} - ${data.booking.room.type}`;
                        document.getElementById('tenantRoomPrice').innerText = `Rp ${data.booking.room.price.toLocaleString('id-ID')}`;
                    }
                    document.getElementById('tenantDashboardModal').classList.remove('hidden');
                } else {
                    openAuthModal('login', 'penghuni');
                }
            } catch (err) {
                console.error(err);
                document.getElementById('tenantDashboardModal').classList.remove('hidden');
            }
        }

        // Owner Dashboard Functions
        async function openOwnerDashboard() {
            try {
                const res = await fetch('/api/owner/dashboard');
                const data = await res.json();
                
                // Render stats
                document.getElementById('ownerTotalRevenue').innerText = `Rp ${data.stats.totalRevenue.toLocaleString('id-ID')}`;
                document.getElementById('ownerPendingAmount').innerText = `Rp ${data.stats.pendingAmount.toLocaleString('id-ID')}`;
                document.getElementById('ownerOccupiedCount').innerText = `${data.stats.occupiedCount} / ${data.stats.totalRooms} Kamar`;

                // Render Rooms Table
                renderOwnerRoomsTable(data.rooms);
                renderOwnerFacilitiesList(data.facilities);
                renderOwnerPendingPayments(data.pendingPayments);

                document.getElementById('ownerDashboardModal').classList.remove('hidden');
            } catch (err) {
                console.error(err);
                document.getElementById('ownerDashboardModal').classList.remove('hidden');
            }
        }

        function renderOwnerRoomsTable(rooms) {
            const tbody = document.getElementById('ownerRoomTable');
            tbody.innerHTML = '';
            rooms.forEach(room => {
                const statusTag = room.status === 'available'
                    ? `<span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 font-bold rounded text-[11px]">Tersedia</span>`
                    : `<span class="px-2 py-0.5 bg-slate-200 text-slate-700 font-bold rounded text-[11px]">Terisi</span>`;

                const toggleBtn = room.status === 'available'
                    ? `<button onclick="toggleRoomStatus(${room.id})" class="px-2.5 py-1 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded transition text-[11px]">Set Terisi</button>`
                    : `<button onclick="toggleRoomStatus(${room.id})" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded transition text-[11px]">Set Tersedia</button>`;

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-bold text-navy-900">${room.number}</td>
                        <td class="p-3 text-slate-600">${room.type}</td>
                        <td class="p-3 font-bold text-navy-900">Rp ${room.price.toLocaleString('id-ID')}</td>
                        <td class="p-3">${statusTag}</td>
                        <td class="p-3 text-center space-x-1.5">
                            ${toggleBtn}
                            <button onclick="editRoomPrice(${room.id}, ${room.price})" class="px-2 py-1 bg-slate-100 text-slate-700 font-bold rounded hover:bg-slate-200 transition text-[11px]" title="Edit Harga"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                `;
            });
        }

        function renderOwnerFacilitiesList(facilities) {
            const container = document.getElementById('ownerFacilityList');
            container.innerHTML = '';
            facilities.forEach(fac => {
                container.innerHTML += `
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-lg flex justify-between items-center text-xs font-bold text-navy-900">
                        <span><i class="${fac.icon} text-orange-600 mr-2"></i>${fac.name}</span>
                        <button onclick="deleteFacility(${fac.id})" class="text-rose-500 hover:text-rose-700 p-1"><i class="fa-solid fa-trash"></i></button>
                    </div>
                `;
            });
        }

        function renderOwnerPendingPayments(payments) {
            const container = document.getElementById('ownerPendingPaymentsContainer');
            container.innerHTML = '';
            if (payments.length === 0) {
                container.innerHTML = `<p class="text-xs text-slate-500 p-4 bg-slate-50 rounded-lg border border-slate-200">Tidak ada bukti bayar pending yang memerlukan verifikasi saat ini.</p>`;
                return;
            }
            payments.forEach(p => {
                const userName = p.user ? p.user.name : 'Penyewa';
                const roomNum = p.room ? p.room.number : 'Kamar';
                container.innerHTML += `
                    <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-3">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-xs text-navy-900">${userName} (${roomNum})</span>
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-bold rounded">Menunggu Verifikasi</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">${p.title} • <strong>Rp ${p.amount.toLocaleString('id-ID')}</strong> • ${p.payment_method || 'Transfer Bank'}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="approvePayment(${p.id})" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded transition">
                                Setujui & Lunas
                            </button>
                            <button onclick="rejectPayment(${p.id})" class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold rounded transition">
                                Tolak
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        async function toggleRoomStatus(id) {
            const res = await fetch(`/api/owner/rooms/${id}/toggle`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                openOwnerDashboard();
            }
        }

        async function editRoomPrice(id, oldPrice) {
            const newPrice = prompt('Masukkan tarif sewa bulanan baru (Rp):', oldPrice);
            if (newPrice && !isNaN(newPrice)) {
                const res = await fetch(`/api/owner/rooms/${id}/price`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ price: parseInt(newPrice) })
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    openOwnerDashboard();
                }
            }
        }

        async function approvePayment(id) {
            const res = await fetch(`/api/owner/payments/${id}/approve`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                openOwnerDashboard();
            }
        }

        async function rejectPayment(id) {
            const res = await fetch(`/api/owner/payments/${id}/reject`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                openOwnerDashboard();
            }
        }

        async function tambahFasilitasBaru() {
            const name = prompt('Masukkan nama fasilitas kost baru:');
            if (name) {
                const res = await fetch('/api/owner/facilities', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name: name })
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    openOwnerDashboard();
                }
            }
        }

        async function deleteFacility(id) {
            if (confirm('Yakin ingin menghapus fasilitas ini?')) {
                const res = await fetch(`/api/owner/facilities/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    openOwnerDashboard();
                }
            }
        }

        function closeDashboard(type) {
            if (type === 'tenant') {
                document.getElementById('tenantDashboardModal').classList.add('hidden');
            } else {
                document.getElementById('ownerDashboardModal').classList.add('hidden');
            }
        }

        function switchOwnerTab(tab) {
            document.getElementById('ownerSectionRooms').classList.add('hidden');
            document.getElementById('ownerSectionFinances').classList.add('hidden');
            document.getElementById('ownerSectionFacilities').classList.add('hidden');

            document.getElementById('ownerTabRooms').className = "pb-3 text-slate-500 hover:text-navy-900";
            document.getElementById('ownerTabFinances').className = "pb-3 text-slate-500 hover:text-navy-900";
            document.getElementById('ownerTabFacilities').className = "pb-3 text-slate-500 hover:text-navy-900";

            if (tab === 'rooms') {
                document.getElementById('ownerSectionRooms').classList.remove('hidden');
                document.getElementById('ownerTabRooms').className = "pb-3 border-b-2 border-orange-600 text-orange-600 font-bold";
            } else if (tab === 'finances') {
                document.getElementById('ownerSectionFinances').classList.remove('hidden');
                document.getElementById('ownerTabFinances').className = "pb-3 border-b-2 border-orange-600 text-orange-600 font-bold";
            } else {
                document.getElementById('ownerSectionFacilities').classList.remove('hidden');
                document.getElementById('ownerTabFacilities').className = "pb-3 border-b-2 border-orange-600 text-orange-600 font-bold";
            }
        }

        async function handleBooking(roomId, roomNumber) {
            @guest
                try {
                    sessionStorage.setItem('pendingBookingRoomId', roomId);
                    sessionStorage.setItem('pendingBookingRoomNumber', roomNumber);
                } catch (e) {}
                openAuthModal('login', 'penghuni');
                return;
            @else
                const res = await fetch('/api/tenant/booking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ room_id: roomId })
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    openTenantDashboard();
                } else {
                    alert(data.message);
                }
            @endguest
        }

        function handleFooterBooking(e) {
            @guest
                if (e) e.preventDefault();
                openAuthModal('login', 'penghuni');
            @else
                const section = document.getElementById('kamar');
                if (section) section.scrollIntoView({ behavior: 'smooth' });
            @endguest
        }

        function handleFooterPengaduan(e) {
            @guest
                if (e) e.preventDefault();
                openAuthModal('login', 'penghuni');
            @else
                const section = document.getElementById('pengaduan');
                if (section) section.scrollIntoView({ behavior: 'smooth' });
            @endguest
        }

        function simulasiBayar() {
            alert('Formulir Pembayaran: Bukti transfer pembayaran berhasil diunggah! Menunggu konfirmasi verifikasi dari Pengelola Kost.');
        }

        function toggleFaq(element) {
            const p = element.querySelector('p');
            const icon = element.querySelector('i');
            p.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        function slideAturan(direction) {
            const container = document.getElementById('aturanSliderContainer');
            if (!container) return;
            const card = container.querySelector(':scope > div');
            const step = card ? (card.offsetWidth + 16) : (container.clientWidth * 0.75);
            if (direction === 'prev') {
                container.scrollBy({ left: -step, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: step, behavior: 'smooth' });
            }
        }

        (function initAturanSliderDrag() {
            const slider = document.getElementById('aturanSliderContainer');
            if (!slider) return;
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('cursor-grabbing');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });
            window.addEventListener('mouseup', () => {
                if (isDown) {
                    isDown = false;
                    slider.classList.remove('cursor-grabbing');
                }
            });
            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 1.5;
                slider.scrollLeft = scrollLeft - walk;
            });
        })();

        function slideUlasan(direction) {
            const container = document.getElementById('ulasanSliderContainer');
            if (!container) return;
            const card = container.querySelector(':scope > div');
            const step = card ? (card.offsetWidth + 16) : (container.clientWidth * 0.75);
            if (direction === 'prev') {
                container.scrollBy({ left: -step, behavior: 'smooth' });
            } else {
                if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 20) {
                    container.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    container.scrollBy({ left: step, behavior: 'smooth' });
                }
            }
        }

        (function initUlasanSliderDrag() {
            const slider = document.getElementById('ulasanSliderContainer');
            if (!slider) return;
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('cursor-grabbing');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });
            window.addEventListener('mouseup', () => {
                if (isDown) {
                    isDown = false;
                    slider.classList.remove('cursor-grabbing');
                }
            });
            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 1.5;
                slider.scrollLeft = scrollLeft - walk;
            });
        })();

        function handleBuatUlasan() {
            @guest
                try {
                    sessionStorage.setItem('autoOpenTenantDashboard', 'true');
                } catch (e) {}
                openAuthModal('login', 'penghuni');
                return;
            @else
                @if(Auth::user()->isOwner())
                    alert('Hanya akun Penghuni yang dapat mengakses halaman khusus penghuni.');
                @else
                    openTenantDashboard();
                @endif
            @endguest
        }

        function openReviewModal() {
            @auth
                openTenantDashboard();
            @else
                openAuthModal('login', 'penghuni');
            @endauth
        }

        function closeReviewModal() {
            const modal = document.getElementById('reviewModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function setRating(rating) {
            const input = document.getElementById('reviewRating');
            if (input) input.value = rating;
            const text = document.getElementById('ratingValueText');
            if (text) text.textContent = `${rating} dari 5 Bintang`;
            
            const stars = document.querySelectorAll('#starRatingContainer .star-btn');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.className = 'fa-solid fa-star star-btn cursor-pointer transition transform hover:scale-110 text-amber-500';
                } else {
                    star.className = 'fa-regular fa-star star-btn cursor-pointer transition transform hover:scale-110 text-slate-300';
                }
            });
        }

        function handleReviewSubmit(e) {
            e.preventDefault();
            const rating = parseInt(document.getElementById('reviewRating').value) || 5;
            const occupation = document.getElementById('reviewOccupation').value.trim();
            const room = document.getElementById('reviewRoom').value.trim() || 'Penghuni Kost';
            const text = document.getElementById('reviewText').value.trim();
            
            @auth
                const userName = @json(Auth::user()->name);
            @else
                const userName = "Penghuni Wisma S";
            @endauth

            // Inisial profil
            const initials = userName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() || 'PW';

            // Bintang
            let starsHtml = '';
            for (let i = 0; i < rating; i++) {
                starsHtml += '<i class="fa-solid fa-star"></i>';
            }

            // Kartu ulasan baru
            const newCard = document.createElement('div');
            newCard.className = "p-5 bg-white rounded-xl border-2 border-orange-400 shadow-md flex flex-col justify-between hover:shadow-lg transition w-[85%] sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)] shrink-0 snap-start";
            newCard.innerHTML = `
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex text-amber-500 text-xs space-x-1">
                            ${starsHtml}
                        </div>
                        <span class="text-[10px] bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-bold">Ulasan Anda</span>
                    </div>
                    <p class="text-slate-600 text-xs leading-relaxed mb-4">"${text}"</p>
                </div>
                <div class="flex items-center space-x-3 pt-3 border-t border-slate-100">
                    <div class="w-8 h-8 rounded-full bg-orange-600 text-white flex items-center justify-center font-bold text-xs">${initials}</div>
                    <div>
                        <p class="font-bold text-xs text-navy-900">${userName}</p>
                        <p class="text-[10px] text-slate-500">${room} • ${occupation}</p>
                    </div>
                </div>
            `;

            const container = document.getElementById('ulasanSliderContainer');
            if (container) {
                container.prepend(newCard);
                container.scrollTo({ left: 0, behavior: 'smooth' });
            }

            alert('Terima kasih! Ulasan Anda berhasil dikirim dan ditampilkan.');
            closeReviewModal();
            document.getElementById('formReview').reset();
            setRating(5);
        }

        // =========================================================================
        // PENGADUAN FASILITAS (HANYA OPSI, KOLOM PESAN & BUTTON KIRIM)
        // =========================================================================
        function pilihOpsiFasilitas(kategori) {
            const hiddenInput = document.getElementById('selectedKategoriFasilitas');
            if (hiddenInput) {
                hiddenInput.value = kategori;
            }

            const btnKost = document.getElementById('btnFasilitasKost');
            const btnKamar = document.getElementById('btnFasilitasKamar');

            const activeClass = 'inline-flex items-center px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm border transition shadow-sm active:scale-95 bg-navy-900 hover:bg-navy-800 text-white border-navy-900';
            const inactiveClass = 'inline-flex items-center px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm border transition shadow-sm active:scale-95 bg-white text-slate-700 border-slate-300 hover:bg-slate-50';

            if (kategori === 'Fasilitas Kost') {
                if (btnKost) btnKost.className = activeClass;
                if (btnKamar) btnKamar.className = inactiveClass;
            } else {
                if (btnKamar) btnKamar.className = activeClass;
                if (btnKost) btnKost.className = inactiveClass;
            }
        }

        async function kirimPengaduan() {
            const hiddenInput = document.getElementById('selectedKategoriFasilitas');
            const opsi = hiddenInput ? hiddenInput.value : 'Fasilitas Kost';
            const pesanEl = document.getElementById('pesanPengaduan');
            const pesan = (pesanEl && pesanEl.value.trim()) ? pesanEl.value.trim() : '';

            @guest
                if (pesan) {
                    try {
                        sessionStorage.setItem('pendingPengaduanPesan', pesan);
                        sessionStorage.setItem('pendingPengaduanKategori', opsi);
                    } catch (e) {}
                }
                try {
                    sessionStorage.setItem('autoOpenTenantDashboard', 'true');
                } catch (e) {}

                openAuthModal('login', 'penghuni');
                return;
            @else
                @if(Auth::user()->isOwner())
                    alert('Hanya akun Penghuni yang dapat mengirimkan pengaduan fasilitas.');
                    return;
                @endif
            @endguest

            if (!pesan) {
                alert('Silakan tuliskan pesan pengaduan fasilitas terlebih dahulu.');
                if (pesanEl) pesanEl.focus();
                return;
            }

            // Simpan pengaduan ke database (tercatat langsung di sistem pengelola kost)
            try {
                const res = await fetch('/api/tenant/complaints', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        category: opsi,
                        message: pesan
                    })
                });
                const data = await res.json();
                if (data.success) {
                    alert('Pengaduan Anda berhasil tercatat di sistem pengelola kost! Status: Belum Diperbaiki (Akan segera ditindaklanjuti).');
                }
            } catch (err) {
                console.error(err);
            }

            const alamatKost = "Kost Wisma S, Perumahan Griya Karang Indah Blok S-15 RT 01 RW 12, Kel. Karangpucung, Kec. Purwokerto Selatan, Kab. Banyumas 53142";
            const targetPhone = '6281234567890';

            @auth
                const pengirimNama = @json(Auth::user()->name);
                const pengirimPhone = @json(Auth::user()->phone ?? '-');
            @else
                const pengirimNama = 'Penghuni Wisma S';
                const pengirimPhone = '-';
            @endauth

            const waText = 
`*PENGADUAN ${opsi.toUpperCase()} - KOST WISMA S*
---------------------------------------
👤 *Pengirim:* ${pengirimNama} (${pengirimPhone})
📌 *Kategori:* ${opsi}
💬 *Pesan Pengaduan:*
"${pesan}"

📍 *Alamat Kost:*
${alamatKost}
---------------------------------------
_Pesan dikirim dari Formulir Pengaduan Kost Wisma S_`;

            if (pesanEl) pesanEl.value = '';
            const waUrl = `https://wa.me/${targetPhone}?text=${encodeURIComponent(waText)}`;
            window.open(waUrl, '_blank');
        }

        // Auto-resume action jika pengguna baru saja berhasil login/daftar
        document.addEventListener('DOMContentLoaded', function() {
            @auth
                try {
                    // Cek jika sebelumnya ingin mengajukan booking kamar
                    const pendingRoomId = sessionStorage.getItem('pendingBookingRoomId');
                    const pendingRoomNumber = sessionStorage.getItem('pendingBookingRoomNumber');
                    if (pendingRoomId && pendingRoomNumber) {
                        sessionStorage.removeItem('pendingBookingRoomId');
                        sessionStorage.removeItem('pendingBookingRoomNumber');
                        handleBooking(parseInt(pendingRoomId), pendingRoomNumber);
                        return;
                    }

                    // Pastikan flag ulasan dibersihkan agar form/modal ulasan tidak pernah terbuka otomatis
                    sessionStorage.removeItem('pendingOpenReview');

                    // Cek jika sebelumnya menulis draf pengaduan fasilitas
                    const savedPesan = sessionStorage.getItem('pendingPengaduanPesan');
                    const savedKategori = sessionStorage.getItem('pendingPengaduanKategori');
                    if (savedPesan) {
                        const pesanEl = document.getElementById('pesanPengaduan');
                        if (pesanEl) {
                            pesanEl.value = savedPesan;
                            const pengaduanSection = document.getElementById('pengaduan');
                            if (pengaduanSection) pengaduanSection.scrollIntoView({ behavior: 'smooth' });
                        }
                        sessionStorage.removeItem('pendingPengaduanPesan');
                    }
                    if (savedKategori) {
                        pilihOpsiFasilitas(savedKategori);
                        sessionStorage.removeItem('pendingPengaduanKategori');
                    }

                    // Auto open portal penghuni jika ada parameter ?portal=1 atau session
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.get('portal') === '1' || sessionStorage.getItem('autoOpenTenantDashboard') === 'true') {
                        sessionStorage.removeItem('autoOpenTenantDashboard');
                        setTimeout(() => {
                            openTenantDashboard();
                        }, 250);
                    }
                } catch (e) {}
            @endauth
        });
    </script>
</body>
</html>
