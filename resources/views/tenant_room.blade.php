<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar Anda - Kost Wisma S Purwokerto</title>
    <meta name="description" content="Informasi kamar hunian, tenggat waktu jatuh tempo pembayaran, dan riwayat pembayaran di Kost Wisma S.">
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
                            950: '#08142c',
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
            background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
        }
        .modal-overlay {
            background-color: rgba(8, 20, 44, 0.75);
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-orange-500 selection:text-white flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-40 glass-navbar shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 bg-white rounded-xl p-1 shadow-sm flex items-center justify-center overflow-hidden border border-slate-200 transition transform group-hover:scale-105 shrink-0">
                        <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="text-xs font-black text-orange-600 tracking-widest uppercase leading-none mb-0.5">Kost</span>
                        <span class="text-lg sm:text-xl font-black text-navy-950 tracking-tight leading-tight">WISMA S</span>
                    </div>
                </a>

                <!-- Desktop Navigation Menu (Sama dengan Beranda) -->
                <nav class="hidden lg:flex items-center space-x-7 text-xs font-bold text-slate-700 uppercase tracking-wider">
                    <a href="{{ route('home') }}#beranda" class="hover:text-orange-600 transition">Beranda</a>
                    <a href="{{ route('home') }}#kamar" class="hover:text-orange-600 transition">Kamar</a>
                    <a href="{{ route('home') }}#aturan" class="hover:text-orange-600 transition">Ketentuan</a>
                    <a href="{{ route('home') }}#pengaduan" class="hover:text-orange-600 transition">Pengaduan</a>
                    <a href="{{ route('home') }}#lokasi" class="hover:text-orange-600 transition">Lokasi</a>
                </nav>

                <!-- User Profile & Action Area (Sama dengan Beranda) -->
                <div class="flex items-center space-x-3">
                    <!-- Active Tenant Profile Badge -->
                    <div class="px-3.5 py-2 text-xs font-bold text-navy-950 bg-slate-100 border border-slate-300 rounded-lg flex items-center shadow-sm">
                        <i class="fa-solid fa-user text-orange-600 mr-2"></i>
                        <span>{{ $user->name }}</span>
                    </div>

                    <button onclick="logout()" class="px-3.5 py-2 text-xs font-bold text-slate-600 hover:text-red-600 hover:bg-slate-100 rounded-lg transition">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 pb-20">
        
        <!-- TOP BREADCRUMB & HEADER -->
        <section class="bg-gradient-to-b from-slate-100 to-slate-50 pt-8 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Tombol Kembali Ke Beranda -->
                <div class="mb-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-bold text-orange-600 hover:text-orange-700 transition group">
                        <i class="fa-solid fa-arrow-left mr-2 transition transform group-hover:-translate-x-1"></i>
                        <span>Kembali Ke Beranda</span>
                    </a>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-navy-950 tracking-tight">
                            Kamar Anda
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1">
                            Pantau status sewa kamar, tenggat waktu jatuh tempo pembayaran, dan riwayat transaksi Anda secara praktis.
                        </p>
                    </div>

                    <!-- Hubungi Pemilik / Pengelola Quick Contact -->
                    <div class="flex items-center space-x-2">
                        <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Pengelola Kost Wisma S, saya ' . $user->name . ' penghuni ' . ($room ? $room->number : 'kamar') . ', ingin bertanya sesuatu.') }}" target="_blank" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
                            <i class="fa-brands fa-whatsapp text-sm mr-2"></i> Bantuan Pengelola Kost
                        </a>
                    </div>
                </div>

            </div>
        </section>

        @if(!$room)
            <!-- STATE: BELUM MENYEWA KAMAR -->
            <div class="max-w-4xl mx-auto px-4 py-16 text-center">
                <div class="w-20 h-20 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-5 text-3xl shadow-sm">
                    <i class="fa-solid fa-bed"></i>
                </div>
                <h2 class="text-2xl font-black text-navy-950">Anda Belum Memiliki Kamar Aktif</h2>
                <p class="text-sm text-slate-600 max-w-md mx-auto mt-2 leading-relaxed">
                    Saat ini Anda belum terdaftar sebagai penyewa kamar aktif di Kost Wisma S. Silakan pilih dan booking kamar favorit Anda sekarang.
                </p>
                <div class="mt-6">
                    <a href="{{ route('home') }}#kamar" class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                        <i class="fa-solid fa-door-open mr-2"></i> Jelajahi Daftar Kamar Tersedia
                    </a>
                </div>
            </div>
        @else
            <!-- STATE: SUDAH MENJADI PENGHUNI KAMAR (CONTOH AGUNG) -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-10">

                <!-- SECTION 1: DETAIL KAMAR ANDA -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-100 px-6 py-4 flex flex-wrap items-center justify-between gap-3 bg-slate-50/70">
                        <div class="flex items-center">
                            <h2 class="text-base font-extrabold text-navy-950 uppercase tracking-wider">Detail Kamar</h2>
                        </div>
                        <span class="text-xs font-bold text-slate-500">ID Sewa: #BOOK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="p-6 lg:p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                            
                            <!-- Foto Kamar -->
                            <div class="lg:col-span-5 relative rounded-2xl overflow-hidden border border-slate-200 shadow-sm group h-full min-h-[300px] sm:min-h-[380px]">
                                <img src="{{ $room->image }}" alt="{{ $room->number }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            </div>

                            <!-- Informasi Rincian Kamar -->
                            <div class="lg:col-span-7 space-y-6">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <h3 class="text-2xl font-black text-navy-950">{{ $room->number }}</h3>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <i class="fa-solid fa-circle-check text-[10px] mr-1 text-emerald-600"></i> Kamar Sedang Ditempati
                                        </span>
                                    </div>
                                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-0.5">
                                        <p>Tipe: <b class="text-slate-800 font-bold">{{ $room->type }}</b></p>
                                        <p>Periode Tagihan: <b class="text-slate-800 font-bold">Bulanan</b></p>
                                    </div>
                                </div>

                                <!-- Informasi Umum -->
                                <div>
                                    <span class="text-xs font-bold text-navy-950 uppercase tracking-wider block mb-2.5">
                                        Informasi Umum
                                    </span>
                                    <div class="bg-slate-50/80 p-4 sm:p-5 rounded-2xl border border-slate-200">
                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                            <!-- Tarif Sewa -->
                                            <div class="space-y-0.5">
                                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Tarif Sewa</span>
                                                <p class="text-base font-black text-orange-600">
                                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                                    <span class="text-[11px] font-medium text-slate-500">/bln</span>
                                                </p>
                                                <p class="text-[11px] text-slate-500">Bulanan (Reguler)</p>
                                            </div>

                                            <!-- Mulai Masuk -->
                                            <div class="space-y-0.5">
                                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Mulai Masuk</span>
                                                <p class="text-sm font-black text-navy-950">
                                                    {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d F Y') }}
                                                </p>
                                                <p class="text-[11px] text-emerald-600 font-semibold">Aktif Menempati</p>
                                            </div>

                                            <!-- Siklus Tagihan -->
                                            <div class="space-y-0.5">
                                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Siklus Tagihan</span>
                                                <p class="text-sm font-black text-navy-950">
                                                    Setiap Tanggal 5
                                                </p>
                                                <p class="text-[11px] text-slate-500">Jatuh tempo bulanan</p>
                                            </div>

                                            <!-- Nama Penghuni -->
                                            <div class="space-y-0.5">
                                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Nama Penghuni</span>
                                                <p class="text-sm font-bold text-navy-950 truncate">
                                                    {{ $user->name }}
                                                </p>
                                                <p class="text-[11px] text-slate-500">Penghuni terdaftar</p>
                                            </div>

                                            <!-- No. Handphone -->
                                            <div class="space-y-0.5">
                                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">No. Handphone</span>
                                                <p class="text-sm font-bold text-navy-950">
                                                    {{ $user->phone ?? '-' }}
                                                </p>
                                                <p class="text-[11px] text-slate-500">Kontak WhatsApp</p>
                                            </div>

                                            <!-- Email Akun -->
                                            <div class="space-y-0.5">
                                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Email Akun</span>
                                                <p class="text-sm font-bold text-navy-950 truncate" title="{{ $user->email }}">
                                                    {{ $user->email }}
                                                </p>
                                                <p class="text-[11px] text-slate-500">Notifikasi sistem</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fasilitas Kamar -->
                                <div>
                                    <span class="text-xs font-bold text-navy-950 uppercase tracking-wider block mb-2.5">
                                        Fasilitas Kamar
                                    </span>
                                    <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200">
                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                                            @if(is_array($room->features))
                                                @foreach($room->features as $item)
                                                    <div class="flex items-center space-x-2">
                                                        <i class="fa-solid fa-check text-orange-500 text-xs shrink-0"></i>
                                                        <span class="font-semibold text-slate-800">{{ $item }}</span>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="flex items-center space-x-2">
                                                <i class="fa-solid fa-check text-orange-500 text-xs shrink-0"></i>
                                                <span class="font-semibold text-slate-800">Wi-Fi High Speed</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <i class="fa-solid fa-check text-orange-500 text-xs shrink-0"></i>
                                                <span class="font-semibold text-slate-800">Listrik & Air Lancar</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <i class="fa-solid fa-check text-orange-500 text-xs shrink-0"></i>
                                                <span class="font-semibold text-slate-800">Ventilasi Udara Segar</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: TENGGAT WAKTU PEMBAYARAN (DUE DATE REMINDER) -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-100 px-6 py-4 flex flex-wrap items-center justify-between gap-3 bg-slate-50/70">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-600"></span>
                            <h2 class="text-base font-extrabold text-navy-950 uppercase tracking-wider">Tenggat Waktu Tagihan Berikutnya</h2>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">
                            <i class="fa-solid fa-shield-halved text-emerald-600 mr-1"></i> Pembayaran Aman Terintegrasi Midtrans
                        </span>
                    </div>

                    <div class="p-6 lg:p-8">
                        @if($upcomingPayment)
                            <div class="bg-gradient-to-r from-orange-50 via-white to-amber-50 rounded-xl p-6 border-2 border-orange-200 relative overflow-hidden">
                                <div class="absolute -right-8 -bottom-8 opacity-10 text-orange-600 pointer-events-none">
                                    <i class="fa-solid fa-clock text-9xl"></i>
                                </div>

                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative z-10">
                                    <div class="space-y-2">
                                        <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-300">
                                            <i class="fa-solid fa-bell text-amber-700 animate-bounce"></i>
                                            <span>Menunggu Pembayaran</span>
                                        </div>
                                        <h3 class="text-xl sm:text-2xl font-black text-navy-950">
                                            {{ $upcomingPayment->title }}
                                        </h3>
                                        <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-xs text-slate-600">
                                            <span class="flex items-center font-bold text-orange-700">
                                                <i class="fa-solid fa-calendar-day mr-1.5"></i> Jatuh Tempo: {{ $upcomingPayment->due_date }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fa-solid fa-credit-card mr-1.5 text-slate-400"></i> Saluran: Midtrans Payment Gateway
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-600 pt-1 max-w-xl">
                                            Harap melakukan pembayaran sebelum batas jatuh tempo agar kenyamanan tinggal dan ketersediaan kamar tetap terjaga.
                                        </p>
                                    </div>

                                    <!-- Tagihan Nominal & Tombol Bayar -->
                                    <div class="bg-white p-5 rounded-xl border border-orange-200 shadow-sm flex flex-col items-center md:items-end justify-center min-w-[260px] text-center md:text-right shrink-0">
                                        <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Tagihan</span>
                                        <span class="text-2xl sm:text-3xl font-black text-orange-600 my-1">
                                            Rp {{ number_format($upcomingPayment->amount, 0, ',', '.') }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 mb-3">Termasuk seluruh fasilitas kamar</span>
                                        <button onclick="openPayModal({{ $upcomingPayment->id }}, '{{ addslashes($upcomingPayment->title) }}', {{ $upcomingPayment->amount }}, '{{ $upcomingPayment->due_date }}')" class="w-full inline-flex items-center justify-center px-5 py-3 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-extrabold rounded-lg shadow-md hover:shadow-lg transition">
                                            <i class="fa-solid fa-lock mr-2"></i> Bayar Tagihan Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- ALL BILLS PAID -->
                            <div class="bg-emerald-50/70 border border-emerald-200 rounded-xl p-6 sm:p-8 text-center flex flex-col items-center justify-center space-y-3">
                                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl shadow-inner">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <h3 class="text-lg font-black text-navy-950">Semua Tagihan Anda Saat Ini Lunas!</h3>
                                <p class="text-xs sm:text-sm text-slate-600 max-w-lg">
                                    Terima kasih! Tidak ada tagihan jatuh tempo saat ini. Tagihan periode berikutnya akan secara otomatis diinformasikan menjelang tanggal tagihan baru.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- SECTION 3: RIWAYAT PEMBAYARAN (PAYMENT HISTORY) -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-100 px-6 py-4 flex flex-wrap items-center justify-between gap-3 bg-slate-50/70">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-600"></span>
                            <h2 class="text-base font-extrabold text-navy-950 uppercase tracking-wider">Riwayat Pembayaran</h2>
                        </div>
                        <span class="text-xs font-bold text-slate-500">{{ $payments->count() }} Total Catatan Tagihan</span>
                    </div>

                    <div class="p-6 lg:p-8">
                        @if($payments->isEmpty())
                            <div class="text-center py-10 text-slate-400">
                                <i class="fa-solid fa-file-invoice text-4xl mb-3 text-slate-300"></i>
                                <p class="text-sm font-semibold">Belum ada riwayat transaksi pembayaran.</p>
                            </div>
                        @else
                            <!-- Responsive Desktop Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-slate-200 text-[11px] font-extrabold uppercase text-slate-500 tracking-wider bg-slate-50/80">
                                            <th class="py-3 px-4">No. Invoice</th>
                                            <th class="py-3 px-4">Deskripsi Tagihan</th>
                                            <th class="py-3 px-4">Jatuh Tempo</th>
                                            <th class="py-3 px-4">Metode Bayar</th>
                                            <th class="py-3 px-4 text-right">Nominal</th>
                                            <th class="py-3 px-4 text-center">Status</th>
                                            <th class="py-3 px-4 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-xs">
                                        @foreach($payments as $pay)
                                            <tr class="hover:bg-slate-50/80 transition">
                                                <!-- Invoice Code -->
                                                <td class="py-4 px-4 font-mono font-bold text-navy-900">
                                                    #INV-{{ str_pad($pay->id, 5, '0', STR_PAD_LEFT) }}
                                                </td>

                                                <!-- Description -->
                                                <td class="py-4 px-4">
                                                    <span class="font-bold text-slate-800 block text-sm">{{ $pay->title }}</span>
                                                    <span class="text-[11px] text-slate-400">Kamar: {{ $room->number }}</span>
                                                </td>

                                                <!-- Due Date -->
                                                <td class="py-4 px-4 font-medium text-slate-600">
                                                    {{ $pay->due_date }}
                                                </td>

                                                <!-- Payment Method -->
                                                <td class="py-4 px-4">
                                                    <div class="flex items-center space-x-1.5 text-slate-700 font-medium">
                                                        <i class="fa-solid fa-shield-check text-emerald-600 text-xs"></i>
                                                        <span>{{ $pay->payment_method ?: 'Midtrans Gateway' }}</span>
                                                    </div>
                                                </td>

                                                <!-- Amount -->
                                                <td class="py-4 px-4 text-right font-black text-slate-900 text-sm">
                                                    Rp {{ number_format($pay->amount, 0, ',', '.') }}
                                                </td>

                                                <!-- Status Badge -->
                                                <td class="py-4 px-4 text-center">
                                                    @if($pay->status === 'approved')
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                            <i class="fa-solid fa-check text-[9px] mr-1 text-emerald-600"></i> LUNAS
                                                        </span>
                                                    @elseif($pay->status === 'pending')
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-black bg-amber-100 text-amber-800 border border-amber-200">
                                                            <i class="fa-solid fa-clock text-[9px] mr-1 text-amber-600"></i> MENUNGGU
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-black bg-red-100 text-red-800 border border-red-200">
                                                            <i class="fa-solid fa-xmark text-[9px] mr-1 text-red-600"></i> DITOLAK
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- Action Buttons -->
                                                <td class="py-4 px-4 text-center">
                                                    @if($pay->status === 'approved')
                                                        <button onclick="openReceiptModal({{ $pay->id }}, '{{ addslashes($pay->title) }}', {{ $pay->amount }}, '{{ $pay->due_date }}', '{{ addslashes($pay->payment_method ?: 'Midtrans Payment Gateway') }}', '{{ $pay->created_at ? $pay->created_at->translatedFormat('d M Y H:i') : $pay->due_date }}')" class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-navy-950 font-bold text-[11px] rounded-lg transition border border-slate-300 shadow-2xs">
                                                            <i class="fa-solid fa-receipt mr-1.5 text-orange-600"></i> Struk
                                                        </button>
                                                    @else
                                                        <button onclick="openPayModal({{ $pay->id }}, '{{ addslashes($pay->title) }}', {{ $pay->amount }}, '{{ $pay->due_date }}')" class="inline-flex items-center px-3 py-1.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-[11px] rounded-lg transition shadow-2xs">
                                                            <i class="fa-solid fa-credit-card mr-1.5"></i> Bayar
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        @endif

    </main>

    <!-- FOOTER (DISAMAKAN DENGAN BERANDA) -->
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
                        <li><a href="{{ route('tenant.room') }}" class="hover:text-orange-400 transition font-bold text-orange-400">Kamar Anda</a></li>
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

    <!-- MODAL PEMBAYARAN MIDTRANS SIMULATOR -->
    <div id="payModal" class="hidden fixed inset-0 z-50 overflow-y-auto modal-overlay flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 relative text-left">
            <button onclick="closePayModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <!-- Logo Center At Atas -->
            <div class="text-center mb-4">
                <div class="w-14 h-14 bg-white rounded-xl p-1 shadow-sm flex items-center justify-center overflow-hidden border border-slate-200 mx-auto mb-2">
                    <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg font-black text-navy-950">Pembayaran Tagihan Kamar</h3>
                <p class="text-xs text-slate-500">Kost Wisma S &bull; Terintegrasi Midtrans</p>
            </div>

            <!-- Rincian Tagihan Box -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 space-y-2.5 mb-5 text-xs">
                <div class="flex justify-between items-center text-slate-500">
                    <span>Penghuni:</span>
                    <span class="font-bold text-slate-800">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between items-center text-slate-500">
                    <span>Kamar:</span>
                    <span class="font-bold text-slate-800">{{ $room ? $room->number : '-' }}</span>
                </div>
                <div class="flex justify-between items-center text-slate-500">
                    <span>Uraian Tagihan:</span>
                    <span id="payModalTitle" class="font-bold text-navy-950 text-right"></span>
                </div>
                <div class="flex justify-between items-center text-slate-500">
                    <span>Jatuh Tempo:</span>
                    <span id="payModalDueDate" class="font-bold text-orange-600"></span>
                </div>
                <div class="border-t border-slate-200 pt-2.5 flex justify-between items-center">
                    <span class="font-extrabold text-navy-950 text-sm">Total Bayar:</span>
                    <span id="payModalAmount" class="font-black text-orange-600 text-lg"></span>
                </div>
            </div>

            <!-- Pilihan Metode Midtrans -->
            <div class="space-y-3 mb-6">
                <label class="block text-xs font-extrabold text-navy-950 uppercase tracking-wider">
                    Pilih Metode Pembayaran Online:
                </label>
                
                <div class="space-y-2 text-xs">
                    <!-- Midtrans VA -->
                    <label class="flex items-center p-3 rounded-xl border border-slate-200 bg-white hover:bg-orange-50/50 hover:border-orange-300 cursor-pointer transition">
                        <input type="radio" name="payment_channel" value="Midtrans (BCA Virtual Account)" checked class="text-orange-600 focus:ring-orange-500">
                        <div class="ml-3 flex-1">
                            <span class="font-extrabold text-navy-950 block">BCA Virtual Account (Otomatis)</span>
                            <span class="text-[10px] text-slate-500">Verifikasi instan 24 jam via Midtrans</span>
                        </div>
                        <i class="fa-solid fa-bolt text-orange-500"></i>
                    </label>

                    <!-- Mandiri / BNI VA -->
                    <label class="flex items-center p-3 rounded-xl border border-slate-200 bg-white hover:bg-orange-50/50 hover:border-orange-300 cursor-pointer transition">
                        <input type="radio" name="payment_channel" value="Midtrans (Mandiri / BNI Virtual Account)" class="text-orange-600 focus:ring-orange-500">
                        <div class="ml-3 flex-1">
                            <span class="font-extrabold text-navy-950 block">Mandiri / BNI Virtual Account</span>
                            <span class="text-[10px] text-slate-500">Pembayaran melalui ATM / Mobile Banking</span>
                        </div>
                    </label>

                    <!-- QRIS & E-Wallet -->
                    <label class="flex items-center p-3 rounded-xl border border-slate-200 bg-white hover:bg-orange-50/50 hover:border-orange-300 cursor-pointer transition">
                        <input type="radio" name="payment_channel" value="Midtrans (QRIS / GoPay / ShopeePay)" class="text-orange-600 focus:ring-orange-500">
                        <div class="ml-3 flex-1">
                            <span class="font-extrabold text-navy-950 block">QRIS / GoPay / ShopeePay / Dana</span>
                            <span class="text-[10px] text-slate-500">Scan QRIS dari aplikasi e-wallet mana saja</span>
                        </div>
                        <i class="fa-solid fa-qrcode text-slate-600"></i>
                    </label>
                </div>
            </div>

            <input type="hidden" id="payModalPaymentId" value="">

            <!-- Tombol Konfirmasi Bayar -->
            <button id="btnConfirmPay" onclick="submitPayPendingBill()" class="w-full py-3 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-black rounded-xl shadow-md transition flex items-center justify-center">
                <i class="fa-solid fa-credit-card mr-2"></i> Lanjutkan Pembayaran Midtrans
            </button>
        </div>
    </div>

    <!-- MODAL STRUK / KUITANSI DIGITAL PEMBAYARAN -->
    <div id="receiptModal" class="hidden fixed inset-0 z-50 overflow-y-auto modal-overlay flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 relative text-left">
            <button onclick="closeReceiptModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <!-- Kuitansi Header -->
            <div class="text-center pb-4 border-b border-dashed border-slate-300">
                <div class="w-12 h-12 bg-white rounded-xl p-1 shadow-sm flex items-center justify-center overflow-hidden border border-slate-200 mx-auto mb-2">
                    <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-full h-full object-contain">
                </div>
                <h3 class="text-base font-black text-navy-950 uppercase tracking-wider">Kuitansi Pembayaran Digital</h3>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kost Wisma S Purwokerto</span>
                <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                    <i class="fa-solid fa-circle-check text-emerald-600 mr-1.5"></i> LUNAS TERVERIFIKASI
                </div>
            </div>

            <!-- Kuitansi Body -->
            <div class="py-4 space-y-3 text-xs">
                <div class="flex justify-between">
                    <span class="text-slate-500">Nomor Transaksi:</span>
                    <span id="rcpInvoiceId" class="font-mono font-bold text-slate-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Waktu Bayar:</span>
                    <span id="rcpDate" class="font-bold text-slate-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Nama Penghuni:</span>
                    <span class="font-bold text-slate-800">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Kamar Hunian:</span>
                    <span class="font-bold text-slate-800">{{ $room ? $room->number . ' (' . $room->type . ')' : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Keterangan:</span>
                    <span id="rcpTitle" class="font-bold text-navy-950 text-right"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Metode:</span>
                    <span id="rcpMethod" class="font-semibold text-slate-700"></span>
                </div>
                <div class="border-t border-dashed border-slate-300 pt-3 flex justify-between items-center">
                    <span class="text-sm font-extrabold text-navy-950">Jumlah Dibayar:</span>
                    <span id="rcpAmount" class="text-lg font-black text-emerald-600"></span>
                </div>
            </div>

            <!-- Footer / Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex gap-2">
                <button onclick="window.print()" class="w-1/2 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition flex items-center justify-center">
                    <i class="fa-solid fa-print mr-1.5"></i> Cetak Struk
                </button>
                <button onclick="closeReceiptModal()" class="w-1/2 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl transition flex items-center justify-center">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT ACTIONS -->
    <script>
        const csrfToken = "{{ csrf_token() }}";

        // Logout function
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
                    alert('Anda telah berhasil keluar.');
                    window.location.href = "{{ route('home') }}";
                }
            } catch (err) {
                console.error(err);
                window.location.href = "{{ route('home') }}";
            }
        }

        // Pay Modal Controls
        function openPayModal(id, title, amount, dueDate) {
            document.getElementById('payModalPaymentId').value = id;
            document.getElementById('payModalTitle').textContent = title;
            document.getElementById('payModalDueDate').textContent = dueDate;
            document.getElementById('payModalAmount').textContent = 'Rp ' + Number(amount).toLocaleString('id-ID');
            document.getElementById('payModal').classList.remove('hidden');
        }

        function closePayModal() {
            document.getElementById('payModal').classList.add('hidden');
        }

        // Submit Pay Pending Bill via Midtrans
        async function submitPayPendingBill() {
            const btn = document.getElementById('btnConfirmPay');
            const paymentId = document.getElementById('payModalPaymentId').value;
            const channel = document.querySelector('input[name="payment_channel"]:checked')?.value || 'Midtrans Payment Gateway';

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i><span>Memproses Midtrans...</span>';

            try {
                const res = await fetch("{{ route('tenant.payBill') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_id: paymentId,
                        payment_method: channel
                    })
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message || 'Gagal memproses pembayaran.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-shield-check mr-2"></i> Lanjutkan Pembayaran Midtrans';
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan koneksi.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-shield-check mr-2"></i> Lanjutkan Pembayaran Midtrans';
            }
        }

        // Receipt Modal Controls
        function openReceiptModal(id, title, amount, dueDate, method, datePaid) {
            document.getElementById('rcpInvoiceId').textContent = '#INV-' + String(id).padStart(5, '0');
            document.getElementById('rcpTitle').textContent = title;
            document.getElementById('rcpAmount').textContent = 'Rp ' + Number(amount).toLocaleString('id-ID');
            document.getElementById('rcpMethod').textContent = method;
            document.getElementById('rcpDate').textContent = datePaid;
            document.getElementById('receiptModal').classList.remove('hidden');
        }

        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.add('hidden');
        }
    </script>
</body>
</html>
