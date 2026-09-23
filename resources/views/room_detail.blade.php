<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $room->number }} - {{ $room->type }} | Kost Wisma S Purwokerto</title>
    <meta name="description" content="Rincian spesifikasi fasilitas dan harga {{ $room->number }} tipe {{ $room->type }} di Kost Wisma S Purwokerto Selatan.">
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
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
        }
        .modal-overlay {
            background-color: rgba(23, 37, 84, 0.75);
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-orange-500 selection:text-white flex flex-col min-h-screen">

    <!-- MAIN NAVBAR -->
    <header class="sticky top-0 z-40 glass-navbar shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo (Kost di atas orange, WISMA S di bawah biru) -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
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
                    <a href="{{ route('home') }}#beranda" class="hover:text-orange-600 transition">Beranda</a>
                    <a href="{{ route('home') }}#kamar" class="text-orange-600 font-extrabold transition">Kamar</a>
                    <a href="{{ route('home') }}#aturan" class="hover:text-orange-600 transition">Ketentuan</a>
                    <a href="{{ route('home') }}#pengaduan" class="hover:text-orange-600 transition">Pengaduan</a>
                    <a href="{{ route('home') }}#lokasi" class="hover:text-orange-600 transition">Lokasi</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                        @if(Auth::user()->isOwner())
                            <a href="{{ route('home') }}" class="px-4 py-2.5 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition shadow-sm flex items-center">
                                <i class="fa-solid fa-gauge-high mr-2"></i> Sistem Manajemen Owner
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="px-4 py-2.5 text-xs font-bold text-navy-950 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-lg transition shadow-sm flex items-center">
                                <i class="fa-solid fa-user text-orange-600 mr-2"></i> Akun Saya
                            </a>
                        @endif
                        <button onclick="logout()" class="px-3.5 py-2 text-xs font-bold text-slate-600 hover:text-red-600 hover:bg-slate-100 rounded-lg transition">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                        </button>
                    @else
                        <button onclick="openAuthModal('login', 'tenant')" class="px-4 py-2.5 text-xs font-bold text-slate-700 hover:text-orange-600 transition flex items-center">
                            <i class="fa-solid fa-arrow-right-to-bracket mr-1.5"></i> Masuk
                        </button>
                        <button onclick="openAuthModal('register', 'tenant')" class="px-5 py-2.5 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-lg shadow-sm transition">
                            <i class="fa-solid fa-user-plus mr-1.5"></i> Daftar
                        </button>
                    @endauth
                </div>

                <!-- Mobile Action Menu -->
                <div class="sm:hidden flex items-center space-x-1.5">
                    @guest
                        <button onclick="openAuthModal('login', 'tenant')" class="px-2.5 py-1.5 text-xs font-bold text-slate-700 border border-slate-300 rounded-md hover:bg-slate-50 transition">Masuk</button>
                        <button onclick="openAuthModal('register', 'tenant')" class="px-3 py-1.5 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-md shadow-sm transition">Daftar</button>
                    @else
                        <button onclick="logout()" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-slate-100 rounded-md">Keluar</button>
                    @endguest
                </div>

            </div>
        </div>
    </header>

    <!-- MAIN DETAIL CONTENT -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-8 w-full">

        <!-- TITLE & ACTION HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-200 mb-8">
            <div>
                <div class="flex items-center space-x-3 mb-2 flex-wrap gap-y-2">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-navy-900 tracking-tight">{{ $room->number }}</h1>
                    @if($room->status === 'available')
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-300 font-bold text-xs rounded-full inline-flex items-center shadow-sm">
                            <i class="fa-solid fa-circle-check mr-1.5 text-emerald-600"></i> Kamar Tersedia (Siap Huni)
                        </span>
                    @else
                        <span class="px-3 py-1 bg-slate-100 text-slate-700 border border-slate-300 font-bold text-xs rounded-full inline-flex items-center shadow-sm">
                            <i class="fa-solid fa-lock mr-1.5 text-slate-500"></i> Kamar Terisi (Penuh)
                        </span>
                    @endif
                </div>
                <div class="flex items-center flex-wrap gap-y-1 gap-x-4 text-xs sm:text-sm text-slate-600">
                    <span class="font-bold text-orange-600 flex items-center">
                        <i class="fa-solid fa-tag mr-1.5"></i> {{ $room->type }}
                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="flex items-center">
                        <i class="fa-solid fa-location-dot text-slate-400 mr-1.5"></i> Kost Wisma S, Blok S-15 Karangpucung, Purwokerto Selatan
                    </span>
                </div>
            </div>

            <!-- Tombol Kembali ke Daftar Kamar (Di Sebelah Kanan & Sejajar) -->
            <div class="self-start md:self-auto">
                <a href="{{ route('home') }}#kamar" class="inline-flex items-center text-xs sm:text-sm font-bold text-orange-600 hover:text-orange-700 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Kamar
                </a>
            </div>
        </div>

        @php
            // Highlight photos based on room type
            $mainImg = $room->image;
            if ($room->type === 'VIP King Suite') {
                $highlightPhotos = [
                    ['url' => $mainImg, 'label' => 'Kamar Tidur Utama & Kasur King', 'sub' => 'Springbed King, AC Dingin, Suasana Tenang'],
                    ['url' => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=80', 'label' => 'Sudut Ruang & Smart TV', 'sub' => 'Dilengkapi Smart TV & Meja Kerja Eksklusif'],
                    ['url' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80', 'label' => 'Kamar Mandi Dalam & Water Heater', 'sub' => 'Kloset Duduk, Shower Air Hangat & Higienis'],
                    ['url' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80', 'label' => 'Dapur Bersama Kost', 'sub' => 'Kompor, Tabung Gas Gratis, & Kulkas Pantry'],
                    ['url' => asset('images/foto-kost.jpg'), 'label' => 'Gedung Kost & Parkir Luas', 'sub' => 'Parkiran Motor Luas Berpagar Tertutup & CCTV 24 Jam'],
                ];
                $dimensi = '4.0 x 5.0 Meter (20 m²)';
                $kasur = 'Springbed King Size (180x200) + Sprei & Bantal';
                $km = 'Kamar Mandi Dalam + Water Heater + Kloset Duduk & Shower';
                $ac = 'AC Split 1 PK (Dingin & Hemat Energi)';
                $lemari = 'Lemari Pakaian 3 Pintu + Cermin Full Body';
            } elseif ($room->type === 'Executive Deluxe') {
                $highlightPhotos = [
                    ['url' => $mainImg, 'label' => 'Kamar Tidur Utama & Fasilitas', 'sub' => 'Kasur Nyaman, AC Dingin, Pencahayaan Alami'],
                    ['url' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=1200&q=80', 'label' => 'Meja Belajar & Lemari Pakaian', 'sub' => 'Meja Kerja Ergonomis & Stop Kontak Banyak'],
                    ['url' => 'https://images.unsplash.com/photo-1620626011761-996317b8d101?auto=format&fit=crop&w=1200&q=80', 'label' => 'Kamar Mandi Dalam', 'sub' => 'Kamar Mandi Dalam Bersih, Kloset Duduk & Shower'],
                    ['url' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80', 'label' => 'Fasilitas Dapur Bersama', 'sub' => 'Area Masak Lengkap, Gas Gratis & Wastafel Bersih'],
                    ['url' => asset('images/foto-kost.jpg'), 'label' => 'Gedung Kost Wisma S', 'sub' => 'Akses Gerbang 24 Jam & Lingkungan Nyaman'],
                ];
                $dimensi = '3.5 x 4.5 Meter (15.75 m²)';
                $kasur = 'Springbed Queen/Single Premium + Bantal & Sprei';
                $km = 'Kamar Mandi Dalam + Kloset Duduk & Shower';
                $ac = 'AC Split 1/2 PK (Dingin & Suara Hening)';
                $lemari = 'Lemari Pakaian 2 Pintu + Cermin Rias';
            } else {
                $highlightPhotos = [
                    ['url' => $mainImg, 'label' => 'Kamar Tidur Standard Single', 'sub' => 'Ruangan Rapi, Bersih, dan Sirkulasi Udara Baik'],
                    ['url' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80', 'label' => 'Tempat Tidur & Kasur Single', 'sub' => 'Kasur Busa Premium Nyaman + Bantal & Sprei'],
                    ['url' => 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&w=1200&q=80', 'label' => 'Meja Belajar & Kursi Kerja', 'sub' => 'Cocok untuk Mahasiswa & Karyawan Work from Room'],
                    ['url' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80', 'label' => 'Kamar Mandi Bersih', 'sub' => 'Rutin Dibersihkan & Sumber Air Jernih Lancar'],
                    ['url' => asset('images/foto-kost.jpg'), 'label' => 'Gedung Kost & Area Parkir', 'sub' => 'Area Parkir Motor Tertata Rapi di Dalam Pagar'],
                ];
                $dimensi = '3.0 x 4.0 Meter (12 m²)';
                $kasur = 'Kasur Single Premium (100x200) + Bantal & Sprei';
                $km = 'Kamar Mandi Bersih (Dekat Kamar) + Shower & Kloset';
                $ac = 'Kipas Angin / Ventilasi Jendela Alami';
                $lemari = 'Lemari Pakaian 2 Pintu & Meja Belajar';
            }
        @endphp

        <!-- HIGHLIGHT FOTO KAMAR SLIDER (UNIFIED CAROUSEL DENGAN SLIDE & TOMBOL NEXT/PREV) -->
        <section class="mb-10">
            <!-- Unified Photo Slider Container -->
            <div id="roomPhotoSliderContainer" class="relative bg-slate-950 rounded-2xl overflow-hidden shadow-xl border border-slate-200 group h-72 sm:h-96 md:h-[480px] select-none cursor-grab active:cursor-grabbing">
                
                <!-- Slide Track -->
                <div id="photoSlideTrack" class="flex h-full w-full transition-transform duration-500 ease-out">
                    @foreach($highlightPhotos as $index => $photo)
                    <div class="w-full h-full shrink-0 relative">
                        <img src="{{ $photo['url'] }}" alt="{{ $photo['label'] }}" class="w-full h-full object-cover pointer-events-none">
                    </div>
                    @endforeach
                </div>

                <!-- Tombol Prev -->
                <button type="button" 
                        onclick="prevPhotoSlide()" 
                        class="absolute left-3 sm:left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/45 hover:bg-orange-600 text-white backdrop-blur-md border border-white/30 flex items-center justify-center shadow-lg transition-all duration-200 active:scale-95 focus:outline-none" 
                        title="Foto Sebelumnya" 
                        aria-label="Foto Sebelumnya">
                    <i class="fa-solid fa-chevron-left text-sm sm:text-base"></i>
                </button>

                <!-- Tombol Next -->
                <button type="button" 
                        onclick="nextPhotoSlide()" 
                        class="absolute right-3 sm:right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/45 hover:bg-orange-600 text-white backdrop-blur-md border border-white/30 flex items-center justify-center shadow-lg transition-all duration-200 active:scale-95 focus:outline-none" 
                        title="Foto Selanjutnya" 
                        aria-label="Foto Selanjutnya">
                    <i class="fa-solid fa-chevron-right text-sm sm:text-base"></i>
                </button>

                <!-- Dots Indicator di Bagian Bawah Tengah -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center space-x-1.5 sm:space-x-2 px-3 py-1.5 rounded-full bg-black/35 backdrop-blur-md border border-white/20">
                    @foreach($highlightPhotos as $index => $photo)
                    <button type="button" 
                            onclick="goToPhotoSlide({{ $index }})" 
                            class="slider-dot w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-orange-500 w-5 sm:w-6' : 'bg-white/50 hover:bg-white' }}" 
                            aria-label="Ke Slide {{ $index + 1 }}">
                    </button>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- 2-COLUMN SECTION: DETAIL FASILITAS & STICKY BOOKING SIDEBAR -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: DETAIL & SPESIFIKASI FASILITAS (7 COLS) -->
            <div class="lg:col-span-8 space-y-8">

                <!-- 1. Rincian & Spesifikasi Kamar -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-6">
                    <div>
                        <h3 class="text-base font-extrabold text-navy-900 uppercase tracking-wider mb-2">
                            Rincian & Spesifikasi Kamar
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Kamar {{ $room->number }} dirancang khusus untuk kenyamanan istirahat maksimal, privasi terjaga, dan produktivitas belajar maupun bekerja dengan standar kebersihan tinggi.
                        </p>
                    </div>

                    <!-- Tabel Spesifikasi Detail -->
                    <div class="overflow-hidden border border-slate-200 rounded-xl">
                        <table class="w-full text-left text-xs">
                            <tbody class="divide-y divide-slate-100">
                                <tr class="bg-slate-50">
                                    <td class="py-3 px-4 font-bold text-navy-900 w-2/5 sm:w-[38%] whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-ruler-combined text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Ukuran / Dimensi</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700 font-medium">{{ $dimensi }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-bed text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Kasur & Ranjang</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">{{ $kasur }}</td>
                                </tr>
                                <tr class="bg-slate-50">
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-snowflake text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Pendingin Ruangan</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">{{ $ac }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-bath text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Kamar Mandi</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">{{ $km }}</td>
                                </tr>
                                <tr class="bg-slate-50">
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-door-closed text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Lemari Pakaian</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">{{ $lemari }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-chair text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Meja & Kursi Kerja</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Meja Belajar Kayu Solid + Kursi Nyaman + Stop Kontak Ganda</td>
                                </tr>
                                <tr class="bg-slate-50">
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-wifi text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Koneksi Internet</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Wi-Fi High-Speed 50 Mbps Gratis Tanpa Batas Kuota</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-bolt text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Kelistrikan</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Meteran Listrik Token Mandiri 900 VA (Isi sesuai pemakaian sendiri)</td>
                                </tr>
                                <tr class="bg-slate-50">
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-wind text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Sirkulasi & Jendela</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Jendela Luar dengan Teralis Keamanan & Gorden Rapi (Pencahayaan Segar)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Fasilitas Bersama (Bentuk Tabel) -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-4">
                    <h3 class="text-base font-extrabold text-navy-900 uppercase tracking-wider mb-2">
                        Fasilitas Bersama
                    </h3>
                    
                    <!-- Tabel Fasilitas Bersama -->
                    <div class="overflow-hidden border border-slate-200 rounded-xl">
                        <table class="w-full text-left text-xs">
                            <tbody class="divide-y divide-slate-100">
                                <tr class="bg-slate-50">
                                    <td class="py-3 px-4 font-bold text-navy-900 w-2/5 sm:w-[38%] whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-fire-burner text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Dapur Bersama</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Kompor gas, tabung gas gratis, dan wastafel cuci piring</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-cubes-stacked text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Kulkas & Dispenser</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Kulkas pantry dan air galon minum siap pakai bersama</td>
                                </tr>
                                <tr class="bg-slate-50">
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-shirt text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Area Jemuran Pakaian</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Area jemuran pakaian luas terlindung hujan & terkena sinar matahari optimal</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-motorcycle text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Parkir Motor</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Parkir motor aman dan tertata rapi di dalam gerbang tertutup dengan kunci mandiri</td>
                                </tr>
                                <tr class="bg-slate-50">
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-video text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Keamanan CCTV 24 Jam</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Area koridor, gerbang masuk, dan parkiran termonitor demi rasa aman penghuni</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-bold text-navy-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-broom text-orange-500 mr-2.5 shrink-0"></i>
                                            <span>Kebersihan Lingkungan</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700">Area koridor, dapur, dan lingkungan luar dibersihkan secara teratur oleh pengelola</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3. Ketentuan Sewa -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-4">
                    <h3 class="text-base font-extrabold text-navy-900 uppercase tracking-wider mb-2">
                        Ketentuan Sewa
                    </h3>
                    <ul class="space-y-2.5 text-xs text-slate-700">
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>Bebas Jam Malam:</strong> Setiap penghuni memegang kunci gerbang masing-masing sehingga leluasa beraktivitas tanpa khawatir terkunci.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>Tamu Berkunjung:</strong> Tamu diterima di ruang tamu bersama. Tamu lawan jenis dilarang menginap atau masuk ke dalam kamar tidur.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>Ketenangan & Kebersihan:</strong> Menjaga jam tenang setelah pukul 22.00 WIB demi kenyamanan istirahat sesama penghuni kost.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>Pembayaran Tepat Waktu:</strong> Pembayaran sewa bulanan ditagihkan melalui sistem dan dibayarkan via transfer bank sebelum jatuh tempo.</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- RIGHT COLUMN: STICKY BOOKING CARD (4 COLS) -->
            <div class="lg:col-span-4 sticky top-28 space-y-5">
                
                <!-- Main Booking Card -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border-2 border-orange-500 shadow-xl space-y-5">
                    
                    @php
                        $basePrice = $room->price;
                        $priceWeekly = round(($basePrice * 0.35) / 10000) * 10000;
                        $priceMonthly = $basePrice;
                        $priceSemester = round(($basePrice * 6 * 0.95) / 50000) * 50000;
                        $priceYearly = $basePrice * 11;

                        $rentalOptions = [
                            'mingguan' => [
                                'label' => 'Mingguan',
                                'suffix' => '/ minggu',
                                'price' => $priceWeekly,
                                'price_formatted' => 'Rp ' . number_format($priceWeekly, 0, ',', '.')
                            ],
                            'bulanan' => [
                                'label' => 'Bulanan',
                                'suffix' => '/ bulan',
                                'price' => $priceMonthly,
                                'price_formatted' => 'Rp ' . number_format($priceMonthly, 0, ',', '.')
                            ],
                            'semester' => [
                                'label' => 'Semesteran',
                                'suffix' => '/ semester',
                                'price' => $priceSemester,
                                'price_formatted' => 'Rp ' . number_format($priceSemester, 0, ',', '.')
                            ],
                            'tahunan' => [
                                'label' => 'Tahunan',
                                'suffix' => '/ tahun',
                                'price' => $priceYearly,
                                'price_formatted' => 'Rp ' . number_format($priceYearly, 0, ',', '.')
                            ]
                        ];
                    @endphp

                    <!-- Harga Sewa & Pilihan Durasi -->
                    <div>
                        <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold block mb-1.5">Harga Sewa</span>
                        <div class="flex items-baseline space-x-2 flex-wrap gap-y-1">
                            <span id="displayedPrice" class="text-2xl sm:text-3xl font-black text-navy-900 transition-all duration-200">
                                Rp {{ number_format($priceMonthly, 0, ',', '.') }}
                            </span>
                            <span id="displayedSuffix" class="text-xs text-slate-500 font-semibold transition-all duration-200">
                                / bulan
                            </span>
                        </div>

                        <!-- Pill Buttons Pilihan Opsi Durasi Sewa -->
                        <div class="grid grid-cols-4 gap-1.5 mt-3">
                            <button type="button" 
                                    onclick="updateRentalOption('mingguan')" 
                                    id="pill_mingguan"
                                    class="rental-pill py-1.5 px-1 text-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-[11px] font-bold text-slate-700 transition">
                                Mingguan
                            </button>
                            <button type="button" 
                                    onclick="updateRentalOption('bulanan')" 
                                    id="pill_bulanan"
                                    class="rental-pill py-1.5 px-1 text-center rounded-lg border-2 border-navy-900 bg-navy-900 text-[11px] font-bold text-white transition shadow-sm">
                                Bulanan
                            </button>
                            <button type="button" 
                                    onclick="updateRentalOption('semester')" 
                                    id="pill_semester"
                                    class="rental-pill py-1.5 px-1 text-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-[11px] font-bold text-slate-700 transition">
                                Semesteran
                            </button>
                            <button type="button" 
                                    onclick="updateRentalOption('tahunan')" 
                                    id="pill_tahunan"
                                    class="rental-pill py-1.5 px-1 text-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-[11px] font-bold text-slate-700 transition">
                                Tahunan
                            </button>
                        </div>

                        <!-- Teks Kecil Harga Special -->
                        <p class="text-[11px] text-slate-500 font-medium mt-2 text-left">
                            Harga special untuk sewa tahunan!
                        </p>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex items-center">
                        @if($room->status === 'available')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-circle-check mr-1.5 text-emerald-600 text-xs"></i> Kamar Tersedia (Siap Huni)
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 border border-slate-300 text-slate-700 text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-lock mr-1.5 text-slate-500 text-xs"></i> Kamar Terisi (Penuh)
                            </span>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-1">
                        @if($room->status === 'available')
                            <button type="button" 
                                    onclick="triggerBookingAction()" 
                                    class="w-full py-3.5 px-4 bg-orange-600 hover:bg-orange-700 active:scale-95 text-white font-extrabold text-sm rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-calendar-check text-base"></i>
                                <span>Booking Kamar</span>
                            </button>
                        @else
                            <button disabled 
                                    class="w-full py-3.5 px-4 bg-slate-200 text-slate-400 font-bold text-sm rounded-xl cursor-not-allowed flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-lock text-base"></i>
                                <span>Kamar Sudah Terisi</span>
                            </button>
                        @endif
                    </div>

                    <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                        <i class="fa-solid fa-info-circle mr-1 text-orange-500"></i>
                        Booking aman & verifikasi langsung..
                    </p>

                </div>

                <!-- Info Lokasi Mini Card -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 text-xs space-y-3 text-slate-600 shadow-sm">
                    <h4 class="font-extrabold text-navy-900 uppercase tracking-wider">
                        Lokasi Strategis
                    </h4>
                    <div class="space-y-1 text-[11px] text-slate-500">
                        <p>• 7 Menit ke Kampus & Fasilitas Kuliner</p>
                        <p>• 10 Menit ke Stasiun Purwokerto</p>
                        <p>• Lingkungan aman, tenang, dan bebas banjir</p>
                    </div>

                    <!-- Embed Google Maps -->
                    <div class="rounded-xl overflow-hidden border border-slate-200 shadow-xs">
                        <iframe 
                            class="w-full h-44 rounded-xl border-0" 
                            src="https://maps.google.com/maps?q=Perumahan+Griya+Karang+Indah+Blok+S-15+RT+01+RW+12+Karangpucung+Purwokerto+Selatan+Banyumas+53142&t=&z=17&ie=UTF8&iwloc=&output=embed" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <!-- Akses Buka Maps -->
                    <a href="https://www.google.com/maps/search/?api=1&query=Perumahan+Griya+Karang+Indah+Blok+S-15+RT+01+RW+12+Karangpucung+Purwokerto+Selatan+Banyumas+53142" 
                       target="_blank" 
                       class="inline-flex items-center justify-center w-full py-2 px-3 bg-orange-50 hover:bg-orange-100 text-orange-700 font-bold text-xs rounded-xl border border-orange-200 transition space-x-1.5 shadow-xs">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <span>Buka di Google Maps</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-0.5"></i>
                    </a>

                    <!-- Alamat Lengkap -->
                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            <strong class="text-navy-900 block mb-0.5">Alamat Lengkap:</strong>
                            Perumahan Griya Karang Indah Blok S-15 RT 01 RW 12, Kel. Karangpucung, Kec. Purwokerto Selatan, Kab. Banyumas 53142
                        </p>
                    </div>
                </div>

            </div>

        </div>

        <!-- OTHER ROOM RECOMMENDATIONS -->
        @if(isset($otherRooms) && $otherRooms->count() > 0)
        <section class="mt-16 pt-10 border-t border-slate-200">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-navy-900">Kamar Lainnya</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilihan kamar lain yang tersedia untuk Anda huni</p>
                </div>
                <a href="{{ route('home') }}#kamar" class="text-xs font-bold text-orange-600 hover:text-orange-700 transition flex items-center">
                    Lihat Semua Kamar <i class="fa-solid fa-arrow-right ml-1.5"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($otherRooms as $other)
                <a href="{{ route('rooms.show', $other->id) }}" class="bg-white rounded-xl overflow-hidden border border-slate-200 hover:border-orange-500 shadow-sm hover:shadow-md transition duration-200 group flex flex-col justify-between">
                    <div class="relative h-44 bg-slate-100 overflow-hidden">
                        <img src="{{ $other->image }}" alt="{{ $other->number }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-2.5 left-2.5">
                            @if($other->status === 'available')
                                <span class="px-2.5 py-1 bg-emerald-600 text-white font-bold text-[10px] rounded shadow inline-flex items-center">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Tersedia
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-700 text-white font-bold text-[10px] rounded shadow inline-flex items-center">
                                    <i class="fa-solid fa-lock mr-1"></i> Kamar Terisi
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-1.5">
                            <div>
                                <h4 class="font-extrabold text-navy-900 group-hover:text-orange-600 transition">{{ $other->number }}</h4>
                                <p class="text-[11px] text-orange-600 font-semibold">{{ $other->type }}</p>
                            </div>
                            <div class="text-right">
                                <span class="font-black text-navy-900 text-sm">Rp {{ number_format($other->price, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-slate-500 block">/ bulan</span>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span class="text-[11px] text-navy-900 font-bold group-hover:text-orange-600 transition">Rincian Kamar <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i></span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

    </main>

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
                        <li><a href="{{ route('home') }}#beranda" class="hover:text-orange-400 transition">Beranda</a></li>
                        <li><a href="{{ route('home') }}#kamar" class="hover:text-orange-400 transition">Kamar</a></li>
                        <li><a href="{{ route('home') }}#aturan" class="hover:text-orange-400 transition">Ketentuan</a></li>
                        <li><a href="{{ route('home') }}#pengaduan" class="hover:text-orange-400 transition">Pengaduan</a></li>
                        <li><a href="{{ route('home') }}#lokasi" class="hover:text-orange-400 transition">Lokasi</a></li>
                    </ul>
                </div>

                <!-- LAYANAN (Digeser ke kanan bersama MENU) -->
                <div class="md:col-span-2 lg:col-span-2 md:pl-4 lg:pl-8">
                    <h4 class="text-xs font-bold text-white uppercase mb-3 tracking-wider">Layanan</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}#kamar" class="hover:text-orange-400 transition">Booking</a></li>
                        <li><a href="{{ route('home') }}#pengaduan" class="hover:text-orange-400 transition">Pengaduan</a></li>
                        @auth
                            @if(Auth::user()->isOwner())
                                <li><a href="{{ route('home') }}" class="hover:text-orange-400 transition">Portal Owner</a></li>
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
    <!-- AUTH MODAL (LOGIN & REGISTER PENYAMBUNG BOOKING) -->
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
                <input type="hidden" id="authRole" value="tenant">

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

    <!-- JAVASCRIPT LOGIC -->
    <script>
        const csrfToken = "{{ csrf_token() }}";
        const currentRoomId = {{ $room->id }};
        const currentRoomNumber = "{{ $room->number }}";
        const currentRoomStatus = "{{ $room->status }}";

        // Photo Slider Logic (Slide & Next/Prev)
        let currentPhotoIndex = 0;
        const totalPhotos = {{ count($highlightPhotos) }};

        function updatePhotoSlide() {
            const track = document.getElementById('photoSlideTrack');
            if (track) {
                track.style.transform = `translateX(-${currentPhotoIndex * 100}%)`;
            }
            const dots = document.querySelectorAll('.slider-dot');
            dots.forEach((dot, idx) => {
                if (idx === currentPhotoIndex) {
                    dot.className = 'slider-dot w-5 sm:w-6 h-2 sm:h-2.5 rounded-full bg-orange-500 transition-all duration-300';
                } else {
                    dot.className = 'slider-dot w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-white/50 hover:bg-white transition-all duration-300';
                }
            });
        }

        function nextPhotoSlide() {
            currentPhotoIndex = (currentPhotoIndex + 1) % totalPhotos;
            updatePhotoSlide();
        }

        function prevPhotoSlide() {
            currentPhotoIndex = (currentPhotoIndex - 1 + totalPhotos) % totalPhotos;
            updatePhotoSlide();
        }

        function goToPhotoSlide(index) {
            currentPhotoIndex = index;
            updatePhotoSlide();
        }

        // Swipe & Drag Gesture Support for Photo Slider
        (function initPhotoSliderSwipe() {
            const slider = document.getElementById('roomPhotoSliderContainer');
            if (!slider) return;

            let startX = 0;
            let currentX = 0;
            let isDragging = false;

            // Touch events for mobile/tablet
            slider.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                currentX = startX;
            }, { passive: true });

            slider.addEventListener('touchmove', (e) => {
                currentX = e.touches[0].clientX;
            }, { passive: true });

            slider.addEventListener('touchend', () => {
                const diff = startX - currentX;
                if (Math.abs(diff) > 40) {
                    if (diff > 0) nextPhotoSlide();
                    else prevPhotoSlide();
                }
            });

            // Mouse drag events for desktop
            slider.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.clientX;
                currentX = startX;
            });

            window.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                currentX = e.clientX;
            });

            window.addEventListener('mouseup', () => {
                if (!isDragging) return;
                isDragging = false;
                const diff = startX - currentX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0) nextPhotoSlide();
                    else prevPhotoSlide();
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') prevPhotoSlide();
                if (e.key === 'ArrowRight') nextPhotoSlide();
            });
        })();

        // Rental Period Selector Logic
        const rentalData = @json($rentalOptions);
        let selectedPeriod = 'bulanan';

        function updateRentalOption(period) {
            if (!rentalData || !rentalData[period]) return;
            selectedPeriod = period;

            // Update displayed price & suffix
            const priceEl = document.getElementById('displayedPrice');
            const suffixEl = document.getElementById('displayedSuffix');
            if (priceEl) {
                priceEl.textContent = rentalData[period].price_formatted;
            }
            if (suffixEl) {
                suffixEl.textContent = rentalData[period].suffix;
            }

            // Sync pill buttons (active becomes dark navy / biru tua)
            const pills = ['mingguan', 'bulanan', 'semester', 'tahunan'];
            pills.forEach(p => {
                const btn = document.getElementById('pill_' + p);
                if (btn) {
                    if (p === period) {
                        btn.className = "rental-pill py-1.5 px-1 text-center rounded-lg border-2 border-navy-900 bg-navy-900 text-[11px] font-bold text-white transition shadow-sm";
                    } else {
                        btn.className = "rental-pill py-1.5 px-1 text-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-[11px] font-bold text-slate-700 transition";
                    }
                }
            });
        }

        // Trigger Booking Action
        async function triggerBookingAction() {
            if (currentRoomStatus !== 'available') {
                alert('Kamar ini saat ini sedang terisi (penuh). Silakan pilih kamar lainnya yang tersedia.');
                return;
            }

            @guest
                // Simpan ID kamar di sessionStorage agar langsung dieksekusi setelah berhasil login/daftar
                try {
                    sessionStorage.setItem('pendingBookingRoomId', currentRoomId);
                    sessionStorage.setItem('pendingBookingRoomNumber', currentRoomNumber);
                    sessionStorage.setItem('pendingBookingPeriod', selectedPeriod);
                } catch (e) {}

                openAuthModal('login', 'tenant');
                return;
            @else
                @if(Auth::user()->isOwner())
                    alert('Akun Owner tidak dapat melakukan booking kamar. Silakan masuk menggunakan akun penghuni.');
                    return;
                @endif

                const periodLabel = (rentalData && rentalData[selectedPeriod]) ? rentalData[selectedPeriod].label : 'Bulanan';
                const periodPrice = (rentalData && rentalData[selectedPeriod]) ? rentalData[selectedPeriod].price_formatted : '';
                if (!confirm(`Konfirmasi: Apakah Anda ingin mengajukan booking untuk ${currentRoomNumber} (Paket ${periodLabel} - ${periodPrice})?`)) {
                    return;
                }

                try {
                    const res = await fetch('/api/tenant/booking', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ room_id: currentRoomId })
                    });
                    const data = await res.json();
                    if (data.success) {
                        alert(data.message);
                        window.location.href = "{{ route('home') }}";
                    } else {
                        alert(data.message || 'Gagal mengajukan booking kamar.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Terjadi kesalahan saat memproses booking.');
                }
            @endguest
        }

        // Auth Modal Operations
        function openAuthModal(mode = 'login', role = 'tenant') {
            const modal = document.getElementById('authModal');
            if (modal) modal.classList.remove('hidden');
            switchAuthTab(mode);
        }

        function closeAuthModal() {
            const modal = document.getElementById('authModal');
            if (modal) modal.classList.add('hidden');
        }

        function switchAuthTab(mode) {
            document.getElementById('authMode').value = mode;
            const tabLogin = document.getElementById('tabLogin');
            const tabRegister = document.getElementById('tabRegister');
            const regName = document.getElementById('registerFieldsName');
            const regPhone = document.getElementById('registerFieldsPhone');
            const regKtp = document.getElementById('registerFieldsKtp');
            const title = document.getElementById('authModalTitle');
            const subtitle = document.getElementById('authModalSubtitle');
            const btnSubmit = document.getElementById('btnAuthSubmit');

            if (mode === 'login') {
                tabLogin.className = "w-1/2 pb-2.5 text-xs font-bold border-b-2 border-orange-600 text-orange-600 transition";
                tabRegister.className = "w-1/2 pb-2.5 text-xs font-bold border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition";
                regName.classList.add('hidden');
                regPhone.classList.add('hidden');
                regKtp.classList.add('hidden');
                title.textContent = "Masuk";
                subtitle.textContent = "Masuk untuk melanjutkan booking kamar ini.";
                btnSubmit.innerHTML = '<i class="fa-solid fa-right-to-bracket text-xs mr-1.5"></i><span>Masuk Sekarang</span>';
            } else {
                tabRegister.className = "w-1/2 pb-2.5 text-xs font-bold border-b-2 border-orange-600 text-orange-600 transition";
                tabLogin.className = "w-1/2 pb-2.5 text-xs font-bold border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition";
                regName.classList.remove('hidden');
                regPhone.classList.remove('hidden');
                regKtp.classList.remove('hidden');
                title.textContent = "Daftar Akun";
                subtitle.textContent = "Lengkapi data untuk proses pemesanan kamar.";
                btnSubmit.innerHTML = '<i class="fa-solid fa-user-plus text-xs mr-1.5"></i><span>Daftar Sekarang</span>';
            }
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
                formData.append('role', 'tenant');

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
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    window.location.href = "{{ route('home') }}";
                }
            } catch (err) {
                console.error(err);
            }
        }

        // Auto-resume booking setelah berhasil login
        document.addEventListener('DOMContentLoaded', function() {
            @auth
                try {
                    const pendingRoomId = sessionStorage.getItem('pendingBookingRoomId');
                    if (pendingRoomId && parseInt(pendingRoomId) === currentRoomId) {
                        sessionStorage.removeItem('pendingBookingRoomId');
                        sessionStorage.removeItem('pendingBookingRoomNumber');
                        triggerBookingAction();
                    }
                } catch (e) {}
            @endauth
        });
    </script>
</body>
</html>
