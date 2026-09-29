<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Manajemen Pemilik - Kost Wisma S</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-navbar {
            background-color: rgba(255, 255, 255, 0.94);
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

    <!-- TOP NAVBAR (DISESUAIKAN DENGAN HALAMAN PENGHUNI) -->
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

                <!-- Desktop Navigation Menu (Kamar & Penghuni, Tenggat Waktu Bayar, Keuangan, Daftar Pengaduan) -->
                <nav class="hidden lg:flex items-center space-x-7 text-xs font-bold uppercase tracking-wider">
                    <button type="button" onclick="switchSection('rooms')" id="navLinkRooms" class="text-orange-600 hover:text-orange-600 transition">KAMAR & PENGHUNI</button>
                    <button type="button" onclick="switchSection('dueDate')" id="navLinkDueDate" class="text-slate-700 hover:text-orange-600 transition">TENGGAT WAKTU BAYAR</button>
                    <button type="button" onclick="switchSection('finances')" id="navLinkFinances" class="text-slate-700 hover:text-orange-600 transition">KEUANGAN</button>
                    <button type="button" onclick="switchSection('complaints')" id="navLinkComplaints" class="text-slate-700 hover:text-orange-600 transition">DAFTAR PENGADUAN</button>
                </nav>

                <!-- Action Buttons & Owner Profile (Sama dengan Halaman Penghuni) -->
                <div class="flex items-center space-x-3">
                    <!-- Owner Profile Badge -->
                    <div class="hidden sm:flex px-3.5 py-2 text-xs font-bold text-navy-950 bg-slate-100 border border-slate-300 rounded-lg items-center shadow-sm">
                        <i class="fa-solid fa-user-shield text-orange-600 mr-2"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </div>

                    <!-- Logout Button -->
                    <button onclick="logout()" class="px-3.5 py-2 text-xs font-bold text-slate-600 hover:text-red-600 hover:bg-slate-100 rounded-lg transition flex items-center">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                    </button>

                    <!-- Mobile Menu Hamburger -->
                    <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div id="mobileMenu" class="lg:hidden hidden border-t border-slate-200 bg-white/95 px-4 pt-3 pb-4 space-y-1.5 text-xs font-bold uppercase tracking-wider">
            <button type="button" onclick="switchSection('rooms'); toggleMobileMenu();" class="w-full text-left py-2.5 px-3 rounded-lg text-slate-700 hover:bg-orange-50 hover:text-orange-600">
                KAMAR & PENGHUNI
            </button>
            <button type="button" onclick="switchSection('dueDate'); toggleMobileMenu();" class="w-full text-left py-2.5 px-3 rounded-lg text-slate-700 hover:bg-orange-50 hover:text-orange-600">
                TENGGAT WAKTU BAYAR
            </button>
            <button type="button" onclick="switchSection('finances'); toggleMobileMenu();" class="w-full text-left py-2.5 px-3 rounded-lg text-slate-700 hover:bg-orange-50 hover:text-orange-600">
                KEUANGAN
            </button>
            <button type="button" onclick="switchSection('complaints'); toggleMobileMenu();" class="w-full text-left py-2.5 px-3 rounded-lg text-slate-700 hover:bg-orange-50 hover:text-orange-600">
                DAFTAR PENGADUAN
            </button>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 pb-20">

        <!-- HEADER BANNER AREA (DISAMAKAN DENGAN HALAMAN PENGHUNI) -->
        <section class="bg-gradient-to-b from-slate-100 to-slate-50 pt-8 pb-8 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-navy-950 tracking-tight">
                        Manajemen Kost
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-3xl">
                        Kelola ketersediaan kamar dan data penghuni, pantau tenggat waktu jatuh tempo sewa, kelola arus kas keuangan keluar dan masuk, serta tindak lanjuti laporan pengaduan fasilitas.
                    </p>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 3 STATS OVERVIEW CARDS (SIMPLE, SLIM, NO ICONS, NOT A BUTTON) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 mb-8">
                
                <!-- Card 1: Okupansi Kamar -->
                <div class="bg-white p-4 rounded-xl border border-slate-200/90 shadow-2xs">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Okupansi Kamar</div>
                    <div class="flex items-baseline space-x-1.5">
                        <span id="statOccupied" class="text-xl sm:text-2xl font-black text-navy-950">-</span>
                        <span class="text-xs text-slate-400">terisi dari</span>
                        <span id="statTotalRooms" class="text-sm font-bold text-slate-700">-</span>
                        <span class="text-xs text-slate-400">kamar</span>
                    </div>
                    <div class="mt-2.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                            <span id="statAvailableCount">-</span>&nbsp;Kamar Tersedia
                        </span>
                    </div>
                </div>

                <!-- Card 2: Tenggat Waktu Bayar -->
                <div class="bg-white p-4 rounded-xl border border-slate-200/90 shadow-2xs">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Tenggat Waktu Bayar</div>
                    <div class="text-xl sm:text-2xl font-black text-orange-600" id="statPendingAmount">Rp 0</div>
                    <div class="mt-2.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-900 border border-amber-200/80">
                            <span id="statPendingCount">0</span>&nbsp;tagihan menunggu verifikasi
                        </span>
                    </div>
                </div>

                <!-- Card 3: Pengaduan Aktif -->
                <div class="bg-white p-4 rounded-xl border border-slate-200/90 shadow-2xs">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Pengaduan Aktif</div>
                    <div class="flex items-baseline space-x-1.5">
                        <span id="statUnresolvedComplaints" class="text-xl sm:text-2xl font-black text-red-600">-</span>
                        <span class="text-xs text-slate-400">laporan kendala</span>
                    </div>
                    <div class="mt-2.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-rose-50 text-rose-800 border border-rose-200/80">
                            Perlu tindak lanjut owner
                        </span>
                    </div>
                </div>

            </div>

            <!-- ========================================================================= -->
            <!-- 1. HALAMAN: KAMAR & PENGHUNI (UNTUK MANAJEMEN) -->
            <!-- ========================================================================= -->
            <div id="sectionRooms" class="page-section">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-base font-extrabold text-navy-950 uppercase tracking-wider">Manajemen Kamar & Penghuni</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola status ketersediaan kamar, tarif sewa bulanan, data penghuni aktif, dan dokumen KTP.</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="relative custom-dropdown-wrapper">
                                <input type="hidden" id="filterRoomStatus" value="all">
                                <button type="button" onclick="toggleOwnerDropdown('RoomStatus', event)" id="btnFilterRoomStatus" class="bg-slate-50 hover:bg-white border border-slate-300 hover:border-slate-400 text-slate-900 text-xs rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:outline-none font-medium flex items-center justify-between transition shadow-2xs min-w-[175px]">
                                    <span id="displayFilterRoomStatus" class="truncate text-left font-semibold">Semua Status Kamar</span>
                                    <i id="arrowFilterRoomStatus" class="fa-solid fa-chevron-down text-slate-500 text-[10px] shrink-0 ml-2 transition-transform duration-200"></i>
                                </button>
                                <div id="menuFilterRoomStatus" class="hidden absolute left-0 top-full mt-1.5 z-50 bg-white rounded-xl shadow-xl border border-slate-200 p-1 space-y-0.5 min-w-full">
                                    <div onclick="selectOwnerFilterOption('RoomStatus', 'all', 'Semua Status Kamar')" data-val="all" class="room-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-semibold text-slate-900 bg-slate-100 truncate">
                                        Semua Status Kamar
                                    </div>
                                    <div onclick="selectOwnerFilterOption('RoomStatus', 'available', 'Hanya Kamar Tersedia')" data-val="available" class="room-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                        Hanya Kamar Tersedia
                                    </div>
                                    <div onclick="selectOwnerFilterOption('RoomStatus', 'occupied', 'Hanya Kamar Terisi')" data-val="occupied" class="room-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                        Hanya Kamar Terisi
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto border border-slate-200 rounded-xl min-h-[260px]">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="border-b border-slate-200 text-[11px] font-extrabold uppercase text-slate-500 tracking-wider bg-slate-50/80">
                                        <th class="py-3 px-4">Kamar</th>
                                        <th class="py-3 px-4">Tipe Kamar</th>
                                        <th class="py-3 px-4">Harga Sewa</th>
                                        <th class="py-3 px-4">Periode Sewa</th>
                                        <th class="py-3 px-4">Penghuni</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="roomsTableBody" class="divide-y divide-slate-100">
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-slate-400">Memuat data kamar & penghuni...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- 2. HALAMAN: TENGGAT WAKTU BAYAR (MELIHAT & MANAJEMEN PEMBAYARAN PENGHUNI) -->
            <!-- ========================================================================= -->
            <div id="sectionDueDate" class="page-section hidden">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-base font-extrabold text-navy-950 uppercase tracking-wider">Tenggat Waktu Bayar & Tagihan</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Pantau waktu jatuh tempo sewa, verifikasi bukti transfer masuk, serta konfirmasi status pelunasan penghuni.</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="relative custom-dropdown-wrapper">
                                <input type="hidden" id="filterPaymentStatus" value="all">
                                <button type="button" onclick="toggleOwnerDropdown('PaymentStatus', event)" id="btnFilterPaymentStatus" class="bg-slate-50 hover:bg-white border border-slate-300 hover:border-slate-400 text-slate-900 text-xs rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:outline-none font-medium flex items-center justify-between transition shadow-2xs min-w-[200px]">
                                    <span id="displayFilterPaymentStatus" class="truncate text-left font-semibold">Semua Status Tagihan</span>
                                    <i id="arrowFilterPaymentStatus" class="fa-solid fa-chevron-down text-slate-500 text-[10px] shrink-0 ml-2 transition-transform duration-200"></i>
                                </button>
                                <div id="menuFilterPaymentStatus" class="hidden absolute left-0 top-full mt-1.5 z-50 bg-white rounded-xl shadow-xl border border-slate-200 p-1 space-y-0.5 min-w-full">
                                    <div onclick="selectOwnerFilterOption('PaymentStatus', 'all', 'Semua Status Tagihan')" data-val="all" class="payment-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-semibold text-slate-900 bg-slate-100 truncate">
                                        Semua Status Tagihan
                                    </div>
                                    <div onclick="selectOwnerFilterOption('PaymentStatus', 'pending', 'Menunggu Verifikasi')" data-val="pending" class="payment-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                        Menunggu Verifikasi
                                    </div>
                                    <div onclick="selectOwnerFilterOption('PaymentStatus', 'approved', 'Lunas')" data-val="approved" class="payment-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                        Lunas
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto border border-slate-200 rounded-xl">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="border-b border-slate-200 text-[11px] font-extrabold uppercase text-slate-500 tracking-wider bg-slate-50/80">
                                        <th class="py-3 px-4">No. Invoice</th>
                                        <th class="py-3 px-4">Nama Penghuni</th>
                                        <th class="py-3 px-4">Nominal</th>
                                        <th class="py-3 px-4">Tenggat Waktu Bayar</th>
                                        <th class="py-3 px-4">Metode Bayar & Bukti</th>
                                        <th class="py-3 px-4 text-center">Status</th>
                                        <th class="py-3 px-4 text-center">Invoice</th>
                                    </tr>
                                </thead>
                                <tbody id="dueDateTableBody" class="divide-y divide-slate-100">
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-slate-400">Memuat data tagihan & tenggat waktu...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- 3. HALAMAN: KEUANGAN (MENGELOLA KEUANGAN KELUAR DAN MASUK) -->
            <!-- ========================================================================= -->
            <div id="sectionFinances" class="page-section hidden">
                <div class="space-y-6">
                    
                    <!-- Ringkasan Arus Kas Keuangan -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">Total Pemasukan (Kas Masuk)</span>
                            <p class="text-2xl font-black text-emerald-600" id="finTotalIncome">Rp 0</p>
                            <p class="text-[11px] text-slate-500 mt-2 font-medium">
                                <i class="fa-solid fa-circle-arrow-down text-emerald-500 mr-1"></i> Dari seluruh pembayaran sewa lunas
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">Total Pengeluaran (Kas Keluar)</span>
                            <p class="text-2xl font-black text-rose-600" id="finTotalExpense">Rp 0</p>
                            <p class="text-[11px] text-slate-500 mt-2 font-medium">
                                <i class="fa-solid fa-circle-arrow-up text-rose-500 mr-1"></i> Biaya operasional kost terverifikasi
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">Saldo Bersih Saat Ini</span>
                            <p class="text-2xl font-black text-navy-950" id="finNetBalance">Rp 0</p>
                            <p class="text-[11px] text-slate-500 mt-2 font-medium">
                                <i class="fa-solid fa-scale-balanced text-orange-500 mr-1"></i> Total Kas Masuk - Total Kas Keluar
                            </p>
                        </div>
                    </div>

                    <!-- Tabel Arus Kas Keluar & Masuk -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-extrabold text-navy-950 uppercase tracking-wider">Kelola Keuangan Keluar & Masuk Kost</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Catatan seluruh arus kas pemasukan sewa kamar dan biaya operasional kost.</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="relative custom-dropdown-wrapper">
                                    <input type="hidden" id="filterFinanceType" value="all">
                                    <button type="button" onclick="toggleOwnerDropdown('FinanceType', event)" id="btnFilterFinanceType" class="bg-slate-50 hover:bg-white border border-slate-300 hover:border-slate-400 text-slate-900 text-xs rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:outline-none font-medium flex items-center justify-between transition shadow-2xs min-w-[210px]">
                                        <span id="displayFilterFinanceType" class="truncate text-left font-semibold">Semua Transaksi (Keluar & Masuk)</span>
                                        <i id="arrowFilterFinanceType" class="fa-solid fa-chevron-down text-slate-500 text-[10px] shrink-0 ml-2 transition-transform duration-200"></i>
                                    </button>
                                    <div id="menuFilterFinanceType" class="hidden absolute left-0 top-full mt-1.5 z-50 bg-white rounded-xl shadow-xl border border-slate-200 p-1 space-y-0.5 min-w-full">
                                        <div onclick="selectOwnerFilterOption('FinanceType', 'all', 'Semua Transaksi (Keluar & Masuk)')" data-val="all" class="finance-type-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-semibold text-slate-900 bg-slate-100 truncate">
                                            Semua Transaksi (Keluar & Masuk)
                                        </div>
                                        <div onclick="selectOwnerFilterOption('FinanceType', 'in', 'Hanya Uang Masuk (Pemasukan)')" data-val="in" class="finance-type-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                            Hanya Uang Masuk (Pemasukan)
                                        </div>
                                        <div onclick="selectOwnerFilterOption('FinanceType', 'out', 'Hanya Uang Keluar (Pengeluaran)')" data-val="out" class="finance-type-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                            Hanya Uang Keluar (Pengeluaran)
                                        </div>
                                    </div>
                                </div>
                                <button onclick="openAddExpenseModal()" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center shrink-0">
                                    <i class="fa-solid fa-plus mr-1.5"></i> Catat Pengeluaran Baru
                                </button>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="border-b border-slate-200 text-[11px] font-extrabold uppercase text-slate-500 tracking-wider bg-slate-50/80">
                                            <th class="py-3 px-4">Tanggal</th>
                                            <th class="py-3 px-4">Deskripsi Transaksi</th>
                                            <th class="py-3 px-4">Kategori</th>
                                            <th class="py-3 px-4 text-center">Arus Kas</th>
                                            <th class="py-3 px-4 text-right">Nominal</th>
                                            <th class="py-3 px-4">Catatan</th>
                                            <th class="py-3 px-4 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="financesTableBody" class="divide-y divide-slate-100">
                                        <tr>
                                            <td colspan="7" class="py-8 text-center text-slate-400">Memuat catatan transaksi keuangan...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- 4. HALAMAN: DAFTAR PENGADUAN PENGHUNI -->
            <!-- ========================================================================= -->
            <div id="sectionComplaints" class="page-section hidden">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-base font-extrabold text-navy-950 uppercase tracking-wider">Daftar Pengaduan Kendala Fasilitas</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Tinjau laporan kendala fasilitas penghuni yang belum diperbaiki agar segera ditindaklanjuti.</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="relative custom-dropdown-wrapper">
                                <input type="hidden" id="filterComplaintStatus" value="all">
                                <button type="button" onclick="toggleOwnerDropdown('ComplaintStatus', event)" id="btnFilterComplaintStatus" class="bg-slate-50 hover:bg-white border border-slate-300 hover:border-slate-400 text-slate-900 text-xs rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:outline-none font-medium flex items-center justify-between transition shadow-2xs min-w-[200px]">
                                    <span id="displayFilterComplaintStatus" class="truncate text-left font-semibold">Semua Status Pengaduan</span>
                                    <i id="arrowFilterComplaintStatus" class="fa-solid fa-chevron-down text-slate-500 text-[10px] shrink-0 ml-2 transition-transform duration-200"></i>
                                </button>
                                <div id="menuFilterComplaintStatus" class="hidden absolute left-0 top-full mt-1.5 z-50 bg-white rounded-xl shadow-xl border border-slate-200 p-1 space-y-0.5 min-w-full">
                                    <div onclick="selectOwnerFilterOption('ComplaintStatus', 'all', 'Semua Status Pengaduan')" data-val="all" class="complaint-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-semibold text-slate-900 bg-slate-100 truncate">
                                        Semua Status Pengaduan
                                    </div>
                                    <div onclick="selectOwnerFilterOption('ComplaintStatus', 'pending', 'Belum Diperbaiki (Perlu Tindakan)')" data-val="pending" class="complaint-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                        Belum Diperbaiki (Perlu Tindakan)
                                    </div>
                                    <div onclick="selectOwnerFilterOption('ComplaintStatus', 'in_progress', 'Sedang Dikerjakan')" data-val="in_progress" class="complaint-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                        Sedang Dikerjakan
                                    </div>
                                    <div onclick="selectOwnerFilterOption('ComplaintStatus', 'resolved', 'Selesai Diperbaiki')" data-val="resolved" class="complaint-status-opt px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs font-medium text-slate-900 truncate">
                                        Selesai Diperbaiki
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto border border-slate-200 rounded-xl">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="border-b border-slate-200 text-[11px] font-extrabold uppercase text-slate-500 tracking-wider bg-slate-50/80">
                                        <th class="py-3 px-4">Waktu Masuk</th>
                                        <th class="py-3 px-4">Penghuni & Kamar</th>
                                        <th class="py-3 px-4">Kategori</th>
                                        <th class="py-3 px-4" style="width: 36%;">Pesan Pengaduan Kendala</th>
                                        <th class="py-3 px-4 text-center">Status Perbaikan</th>
                                        <th class="py-3 px-4 text-center">Tindakan Owner</th>
                                    </tr>
                                </thead>
                                <tbody id="complaintsTableBody" class="divide-y divide-slate-100">
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-slate-400">Memuat data pengaduan...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- FOOTER (DISESUAIKAN PERSIS DENGAN HALAMAN PENGHUNI) -->
    <footer class="bg-navy-900 text-slate-300 py-12 border-t border-navy-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                
                <!-- Brand & Tagline -->
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
                        Kost Nyaman, Bersih & Strategis di Lingkungan Aman. Portal Manajemen Pengelola & Pemilik Kost.
                    </p>
                </div>

                <!-- MENU PORTAL OWNER -->
                <div class="md:col-span-2 lg:col-span-2 md:pl-4 lg:pl-8">
                    <h4 class="text-xs font-bold text-white uppercase mb-3 tracking-wider">MENU</h4>
                    <ul class="space-y-2 text-xs">
                        <li><button onclick="switchSection('rooms')" class="hover:text-orange-400 transition text-left">Kamar & Penghuni</button></li>
                        <li><button onclick="switchSection('dueDate')" class="hover:text-orange-400 transition text-left">Tenggat Waktu Bayar</button></li>
                        <li><button onclick="switchSection('finances')" class="hover:text-orange-400 transition text-left">Keuangan</button></li>
                        <li><button onclick="switchSection('complaints')" class="hover:text-orange-400 transition text-left">Daftar Pengaduan</button></li>
                    </ul>
                </div>

                <!-- LAYANAN -->
                <div class="md:col-span-2 lg:col-span-2 md:pl-4 lg:pl-8">
                    <h4 class="text-xs font-bold text-white uppercase mb-3 tracking-wider">Layanan</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}?view=preview" class="hover:text-orange-400 transition">Beranda Kost</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-orange-400 transition font-bold text-orange-400">Portal Owner</a></li>
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
    <!-- MODAL DETAIL PENGHUNI -->
    <!-- ========================================================================= -->
    <div id="tenantDetailModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative border border-slate-200 max-h-[90vh] overflow-y-auto">
            <!-- Modal Header: Logo Kost di paling atas & center, teks judul & subjudul center -->
            <div class="relative pb-4 border-b border-slate-200 mb-5 text-center">
                <button onclick="closeTenantModal()" class="absolute top-0 right-0 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition focus:outline-none" title="Tutup Modal">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
                <div class="w-14 h-14 rounded-2xl bg-white shadow-sm border border-slate-200 p-1 flex items-center justify-center overflow-hidden mx-auto mb-2.5">
                    <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-full h-full object-contain">
                </div>
                <h3 class="font-extrabold text-base text-navy-950" id="tenantModalTitle">Detail Penghuni</h3>
                <p class="text-xs text-slate-500 mt-0.5">Informasi identitas akun dan masa sewa kamar</p>
            </div>

            <!-- Profile Overview Header -->
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-4 border border-orange-200/70 mb-4 flex items-center justify-between">
                <div>
                    <h4 class="font-extrabold text-navy-950 text-base" id="tenantModalName">-</h4>
                    <p class="text-xs text-slate-600" id="tenantModalRoomInfo">-</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase tracking-wide">
                    Penghuni Aktif
                </span>
            </div>

            <!-- Detail Grid Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-5 text-xs">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Email Terdaftar</span>
                    <span class="font-bold text-navy-950 break-all" id="tenantModalEmail">-</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Nomor HP / WhatsApp</span>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-navy-950" id="tenantModalPhone">-</span>
                        <a id="tenantModalWaLink" href="#" target="_blank" class="hidden text-emerald-600 hover:text-emerald-700 font-extrabold text-xs inline-flex items-center">
                            <i class="fa-brands fa-whatsapp mr-1 text-sm"></i> Chat
                        </a>
                    </div>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Tanggal Mulai Masuk</span>
                    <span class="font-bold text-navy-950" id="tenantModalStartDate">-</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Periode Sewa</span>
                    <span class="font-bold text-orange-600" id="tenantModalRentalPeriod">-</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Tarif Sewa Kamar</span>
                    <span class="font-bold text-slate-800" id="tenantModalPrice">-</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Terdaftar Akun</span>
                    <span class="font-bold text-slate-800" id="tenantModalRegistered">-</span>
                </div>
            </div>

            <!-- Foto KTP Section -->
            <div class="border border-slate-200 rounded-xl p-4 mb-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-navy-950 uppercase tracking-wider flex items-center">
                        <i class="fa-regular fa-id-card mr-2 text-orange-600"></i> Dokumen Foto KTP
                    </span>
                    <span id="tenantModalKtpBadge" class="text-[11px] font-semibold text-slate-500"></span>
                </div>
                <div id="tenantModalKtpPreview" class="mt-2 text-center">
                    <!-- KTP image or placeholder -->
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeTenantModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL RINCIAN TAGIHAN & INFORMASI KAMAR PENGHUNI -->
    <!-- ========================================================================= -->
    <div id="paymentRoomDetailModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative border border-slate-200 max-h-[90vh] overflow-y-auto">
            <!-- Modal Header: Logo Kost di paling atas & center, teks judul & subjudul center -->
            <div class="relative pb-4 border-b border-slate-200 mb-5 text-center">
                <button onclick="closePaymentRoomDetailModal()" class="absolute top-0 right-0 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition focus:outline-none" title="Tutup Modal">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
                <div class="w-14 h-14 rounded-2xl bg-white shadow-sm border border-slate-200 p-1 flex items-center justify-center overflow-hidden mx-auto mb-2.5">
                    <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-full h-full object-contain">
                </div>
                <h3 class="font-extrabold text-base text-navy-950">Rincian Tagihan & Informasi Kamar</h3>
                <p class="text-xs text-slate-500 mt-0.5">Detail kamar penghuni dan status pelunasan pembayaran</p>
            </div>

            <!-- Status Pembayaran Card (Menampilkan Berhasil atau Tidak) -->
            <div id="prmStatusCard" class="rounded-xl p-4 mb-4 border flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div id="prmStatusIcon" class="w-10 h-10 rounded-full flex items-center justify-center text-lg shrink-0">
                        <!-- Icon -->
                    </div>
                    <div>
                        <span id="prmStatusTitle" class="font-extrabold text-sm block"></span>
                        <p id="prmStatusDesc" class="text-xs text-slate-500 mt-0.5"></p>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Nominal</span>
                    <span id="prmAmount" class="font-black text-sm text-navy-950"></span>
                </div>
            </div>

            <!-- Rincian Informasi Kamar & Penghuni Terintegrasi -->
            <div class="space-y-3 mb-5">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Informasi Kamar & Penghuni</div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Kamar</span>
                        <span class="font-bold text-navy-950" id="prmRoomNumber">-</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Tipe Kamar</span>
                        <span class="font-bold text-navy-950" id="prmRoomType">-</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Nama Penghuni</span>
                        <span class="font-bold text-navy-950" id="prmTenantName">-</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Periode Sewa</span>
                        <span class="font-bold text-orange-600" id="prmRentalPeriod">-</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Tarif Sewa Kamar</span>
                        <span class="font-bold text-slate-800" id="prmRoomPrice">-</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Tenggat Waktu Bayar</span>
                        <span class="font-bold text-orange-700" id="prmDueDate">-</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Nomor HP / WhatsApp</span>
                        <span class="font-bold text-slate-800" id="prmTenantPhone">-</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-0.5">Email Penghuni</span>
                        <span class="font-bold text-slate-800 break-all" id="prmTenantEmail">-</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Footer Modal -->
            <div id="prmActionContainer" class="pt-3 border-t border-slate-100 flex gap-2">
                <!-- Action button (e.g. Verifikasi Lunas atau Lihat Struk) -->
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL PREVIEW FOTO KTP PENGHUNI -->
    <!-- ========================================================================= -->
    <div id="ktpModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative border border-slate-200 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-3 border-b border-slate-200 mb-4">
                <div>
                    <h3 class="font-extrabold text-base text-navy-950" id="ktpModalTitle">Dokumen KTP Penghuni</h3>
                    <p class="text-xs text-slate-500" id="ktpModalSubtitle">Identitas terdaftar penghuni kost</p>
                </div>
                <button onclick="closeKtpModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="ktpModalContent" class="text-center">
                <!-- Image or PDF link -->
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL EDIT HARGA KAMAR -->
    <!-- ========================================================================= -->
    <div id="editPriceModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl relative border border-slate-200">
            <h3 class="font-extrabold text-base text-navy-950 mb-1" id="editPriceTitle">Perbarui Harga Sewa</h3>
            <p class="text-xs text-slate-500 mb-4">Masukkan harga sewa terbaru untuk kamar ini.</p>
            <input type="hidden" id="editPriceRoomId">
            <div class="mb-5">
                <label class="block text-xs font-bold text-navy-950 uppercase mb-1">Harga Sewa Baru (Rp)</label>
                <input type="number" id="editPriceInput" step="50000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none text-sm font-black text-navy-950">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditPriceModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">Batal</button>
                <button type="button" onclick="submitEditPrice()" class="px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl text-xs transition shadow-sm">Simpan Harga</button>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL CATAT PENGELUARAN BARU (KAS KELUAR) -->
    <!-- ========================================================================= -->
    <div id="addExpenseModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative border border-slate-200">
            <div class="flex justify-between items-center pb-3 border-b border-slate-200 mb-4">
                <div>
                    <h3 class="font-extrabold text-base text-navy-950">Catat Pengeluaran Operasional</h3>
                    <p class="text-xs text-slate-500">Pencatatan arus kas keluar gedung kost</p>
                </div>
                <button onclick="closeAddExpenseModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form onsubmit="submitAddExpense(event)" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Pengeluaran</label>
                    <input type="text" id="expTitle" required placeholder="Contoh: Tagihan Listrik PLN Gedung Kost" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none text-xs font-semibold">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                        <select id="expCategory" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none text-xs font-semibold bg-white">
                            <option value="Listrik & Air">Listrik & Air</option>
                            <option value="Internet & WiFi">Internet & WiFi</option>
                            <option value="Kebersihan & Keamanan">Kebersihan & Keamanan</option>
                            <option value="Pemeliharaan Fasilitas">Pemeliharaan Fasilitas</option>
                            <option value="Operasional Lainnya">Operasional Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal</label>
                        <input type="text" id="expDate" required placeholder="Contoh: 05 Okt 2026" value="{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none text-xs font-semibold">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nominal Biaya (Rp)</label>
                    <input type="number" id="expAmount" required min="1000" step="5000" placeholder="Contoh: 450000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none text-sm font-black text-rose-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea id="expNote" rows="2" placeholder="Keterangan transaksi atau nomor resi/referensi..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none text-xs"></textarea>
                </div>

                <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                    <button type="button" onclick="closeAddExpenseModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">Batal</button>
                    <button type="submit" id="btnSubmitExpense" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl text-xs transition shadow-sm flex items-center">
                        <i class="fa-solid fa-check mr-1.5"></i> Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL STRUK / KUITANSI DIGITAL PEMBAYARAN -->
    <!-- ========================================================================= -->
    <div id="receiptModal" class="hidden fixed inset-0 modal-overlay z-50 overflow-y-auto flex items-center justify-center p-4">
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
                    <span class="text-slate-500">Nomor Invoice:</span>
                    <span id="rcpInvoiceId" class="font-mono font-bold text-slate-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Waktu Bayar:</span>
                    <span id="rcpDate" class="font-bold text-slate-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Nama Penghuni:</span>
                    <span id="rcpUser" class="font-bold text-slate-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Kamar Hunian:</span>
                    <span id="rcpRoom" class="font-bold text-slate-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Keterangan:</span>
                    <span id="rcpTitle" class="font-bold text-navy-950 text-right"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Metode Bayar:</span>
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
                    <i class="fa-solid fa-print mr-1.5"></i> Cetak Invoice
                </button>
                <button onclick="closeReceiptModal()" class="w-1/2 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl transition flex items-center justify-center">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let globalData = {
            rooms: [],
            payments: [],
            expenses: [],
            complaints: []
        };

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        // Switch Sections (Kamar & Penghuni, Tenggat Waktu Bayar, Keuangan, Daftar Pengaduan)
        function switchSection(section) {
            const sections = ['rooms', 'dueDate', 'finances', 'complaints'];
            const hashes = {
                rooms: 'kamar-penghuni',
                dueDate: 'tenggat-bayar',
                finances: 'keuangan',
                complaints: 'pengaduan'
            };

            sections.forEach(s => {
                const el = document.getElementById('section' + s.charAt(0).toUpperCase() + s.slice(1));
                const navBtn = document.getElementById('navLink' + s.charAt(0).toUpperCase() + s.slice(1));

                if (s === section) {
                    if (el) el.classList.remove('hidden');
                    if (navBtn) {
                        navBtn.className = "text-orange-600 hover:text-orange-600 transition";
                    }
                } else {
                    if (el) el.classList.add('hidden');
                    if (navBtn) {
                        navBtn.className = "text-slate-700 hover:text-orange-600 transition";
                    }
                }
            });

            // Update URL hash without reload
            if (history.pushState && hashes[section]) {
                history.pushState(null, null, '#' + hashes[section]);
            }
        }

        // Handle URL Hash on load
        function handleHash() {
            const hash = window.location.hash.replace('#', '');
            if (hash === 'kamar-penghuni' || hash === 'rooms') {
                switchSection('rooms');
            } else if (hash === 'tenggat-bayar' || hash === 'dueDate') {
                switchSection('dueDate');
            } else if (hash === 'keuangan' || hash === 'finances') {
                switchSection('finances');
            } else if (hash === 'pengaduan' || hash === 'complaints') {
                switchSection('complaints');
            }
        }
        window.addEventListener('hashchange', handleHash);

        // Fetch Dashboard Data
        async function loadDashboardData() {
            try {
                const res = await fetch('/api/owner/dashboard');
                const data = await res.json();
                globalData = data;

                // Update Stats Cards
                document.getElementById('statTotalRooms').textContent = data.stats.totalRooms || 0;
                document.getElementById('statOccupied').textContent = data.stats.occupiedCount || 0;
                document.getElementById('statAvailableCount').textContent = data.stats.availableCount || 0;
                document.getElementById('statPendingAmount').textContent = 'Rp ' + Number(data.stats.pendingAmount || 0).toLocaleString('id-ID');
                
                const pendingList = (data.payments || []).filter(p => p.status === 'pending');
                document.getElementById('statPendingCount').textContent = pendingList.length;

                // Finances Stats
                const totalIncome = data.stats.totalRevenue || 0;
                const totalExpense = data.stats.totalExpenses || 0;
                const netBalance = data.stats.netBalance !== undefined ? data.stats.netBalance : (totalIncome - totalExpense);

                const statNetBalanceEl = document.getElementById('statNetBalance');
                if (statNetBalanceEl) statNetBalanceEl.textContent = 'Rp ' + Number(netBalance).toLocaleString('id-ID');
                document.getElementById('finTotalIncome').textContent = 'Rp ' + Number(totalIncome).toLocaleString('id-ID');
                document.getElementById('finTotalExpense').textContent = 'Rp ' + Number(totalExpense).toLocaleString('id-ID');
                document.getElementById('finNetBalance').textContent = 'Rp ' + Number(netBalance).toLocaleString('id-ID');

                // Complaints Badge
                const unresolvedCount = data.stats.unresolvedComplaintsCount || 0;
                const statUnresolvedEl = document.getElementById('statUnresolvedComplaints');
                if (statUnresolvedEl) statUnresolvedEl.textContent = unresolvedCount;

                // Render Tables
                renderRoomsTable(data.rooms);
                renderDueDateTable(data.payments);
                renderFinancesTable(data.payments, data.expenses || []);
                renderComplaintsTable(data.complaints);
            } catch (err) {
                console.error(err);
                alert('Gagal memuat data dashboard.');
            }
        }

        // =========================================================================
        // 1. RENDER ROOMS TABLE
        // =========================================================================
        function renderRoomsTable(rooms) {
            const tbody = document.getElementById('roomsTableBody');
            if (!tbody) return;

            if (!rooms || rooms.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="py-8 text-center text-slate-400">Belum ada data kamar terdaftar.</td></tr>`;
                return;
            }

            tbody.innerHTML = rooms.map(room => {
                const isAvailable = room.status === 'available';

                // Toggle Action Button (Kamar Tersedia <-> Kamar Terisi)
                const toggleBtn = isAvailable
                    ? `<button onclick="toggleRoomStatus(${room.id})" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition shadow-2xs" title="Kamar masih tersedia. Klik untuk ubah status menjadi Terisi">
                        <i class="fa-solid fa-circle-check mr-1.5 text-emerald-600"></i> Kamar Tersedia
                       </button>`
                    : `<button onclick="toggleRoomStatus(${room.id})" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-300 transition shadow-2xs" title="Kamar sudah terisi. Klik untuk ubah status menjadi Tersedia">
                        <i class="fa-solid fa-lock mr-1.5 text-slate-500"></i> Kamar Terisi
                       </button>`;

                // Rental Period Dropdown (Custom Dropdown Menu persis seperti pada halaman penghuni/home)
                const curPeriod = room.rental_period || 'Bulanan';
                const periods = ['Harian', 'Mingguan', 'Bulanan', '3 Bulan', '6 Bulan', 'Tahunan'];
                const periodOptionsHtml = periods.map(p => {
                    const isActive = (curPeriod.toLowerCase() === p.toLowerCase()) ? 'bg-slate-100 font-bold' : 'font-medium';
                    return `
                        <div onclick="selectRentalPeriod(${room.id}, '${p}', event)" data-period="${p}" class="period-opt-${room.id} px-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition text-xs text-slate-900 ${isActive} truncate">
                            ${p}
                        </div>
                    `;
                }).join('');

                const periodDropdown = `
                    <div id="wrapperPeriod-${room.id}" class="relative custom-dropdown-wrapper inline-block text-left">
                        <button type="button" onclick="toggleRentalPeriodDropdown(${room.id}, event)" id="btnPeriod-${room.id}" class="bg-slate-50 hover:bg-white border border-slate-300 hover:border-slate-400 text-slate-900 text-xs font-semibold rounded-lg pl-3 pr-2.5 py-1.5 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:outline-none flex items-center justify-between space-x-2 transition shadow-2xs min-w-[105px]">
                            <span id="displayPeriod-${room.id}" class="truncate font-bold">${curPeriod}</span>
                            <i id="arrowPeriod-${room.id}" class="fa-solid fa-chevron-down text-slate-500 text-[10px] shrink-0 transition-transform duration-200"></i>
                        </button>
                        <div id="menuPeriod-${room.id}" class="hidden absolute left-0 top-full mt-1.5 z-50 bg-white rounded-xl shadow-xl border border-slate-200 p-1 space-y-0.5 min-w-[125px]">
                            ${periodOptionsHtml}
                        </div>
                    </div>
                `;

                // Occupant Info
                let occupantHtml = `<span class="text-xs font-medium text-slate-400 italic">Belum Ada</span>`;
                const activeBooking = room.bookings && room.bookings.length > 0 ? room.bookings[0] : null;
                if (activeBooking && activeBooking.user) {
                    const u = activeBooking.user;
                    const tenantData = {
                        name: u.name,
                        email: u.email || '-',
                        phone: u.phone || '-',
                        ktp_file: u.ktp_file || '',
                        start_date: activeBooking.start_date || '-',
                        created_at: u.created_at || '-',
                        room_number: room.number,
                        room_type: room.type,
                        room_price: Number(room.price).toLocaleString('id-ID'),
                        rental_period: curPeriod
                    };
                    const tenantDataAttr = encodeURIComponent(JSON.stringify(tenantData));
                    occupantHtml = `
                        <button type="button" onclick="openTenantModal('${tenantDataAttr}')" class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 hover:bg-orange-50 text-slate-800 hover:text-orange-700 border border-slate-200 hover:border-orange-200 transition shadow-2xs focus:outline-none" title="Klik untuk melihat detail profil & KTP penghuni">
                            <div class="w-5 h-5 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-[10px] font-black shrink-0">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span>${u.name}</span>
                        </button>
                    `;
                }

                return `
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3 px-4 text-xs font-bold text-slate-800 whitespace-nowrap">
                            ${room.number}
                        </td>
                        <td class="py-3 px-4 text-xs font-medium text-slate-700">
                            ${room.type}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <div class="inline-flex items-center space-x-1.5">
                                <span class="font-bold text-orange-600 text-xs">Rp ${Number(room.price).toLocaleString('id-ID')}</span>
                                <button onclick="openEditPrice(${room.id}, '${room.number.replace(/'/g, "\\'")}', ${room.price})" class="p-1 text-slate-400 hover:text-orange-600 transition" title="Edit Harga Sewa">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            ${periodDropdown}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            ${occupantHtml}
                        </td>
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            ${toggleBtn}
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // =========================================================================
        // 2. RENDER DUE DATE / TENGGAT WAKTU BAYAR TABLE
        // =========================================================================
        function renderDueDateTable(payments) {
            const tbody = document.getElementById('dueDateTableBody');
            if (!tbody) return;

            if (!payments || payments.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="py-8 text-center text-slate-400">Belum ada catatan tagihan sewa.</td></tr>`;
                return;
            }

            tbody.innerHTML = payments.map(p => {
                const isPending = p.status === 'pending';
                const isApproved = p.status === 'approved';
                const hasPaid = isApproved || Boolean(p.payment_method && p.payment_method.trim() !== '') || Boolean(p.proof_image);

                // Ambil data kamar & penghuni terintegrasi dari globalData.rooms
                const matchingRoom = (globalData && globalData.rooms) 
                    ? globalData.rooms.find(r => r.id === (p.room_id || (p.room ? p.room.id : null)) || r.number === (p.room ? p.room.number : null))
                    : null;

                const activeBooking = (matchingRoom && matchingRoom.bookings && matchingRoom.bookings.length > 0)
                    ? matchingRoom.bookings[0]
                    : null;

                const tenantUser = (activeBooking && activeBooking.user) ? activeBooking.user : (p.user || null);
                const tenantName = tenantUser ? tenantUser.name : (p.user ? p.user.name : 'Penghuni');
                const rawRoomNum = matchingRoom ? matchingRoom.number : (p.room ? p.room.number : '-');
                const roomNumber = rawRoomNum.toLowerCase().startsWith('kamar') ? rawRoomNum : `Kamar ${rawRoomNum}`;
                const roomType = matchingRoom ? matchingRoom.type : (p.room ? p.room.type : '-');
                const roomPrice = matchingRoom ? Number(matchingRoom.price).toLocaleString('id-ID') : Number(p.amount).toLocaleString('id-ID');
                const rentalPeriod = matchingRoom ? (matchingRoom.rental_period || 'Bulanan') : 'Bulanan';
                const startDate = activeBooking ? (activeBooking.start_date || '-') : '-';
                const tenantEmail = tenantUser ? (tenantUser.email || '-') : '-';
                const tenantPhone = tenantUser ? (tenantUser.phone || '-') : '-';

                // Status Badge
                let statusBadge = '';
                if (isApproved) {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200"><i class="fa-solid fa-check text-[9px] mr-1 text-emerald-600"></i> LUNAS</span>`;
                } else if (isPending) {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-black bg-amber-100 text-amber-900 border border-amber-300"><i class="fa-solid fa-clock text-[9px] mr-1 text-amber-700"></i> MENUNGGU</span>`;
                } else {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-black bg-red-100 text-red-800 border border-red-200"><i class="fa-solid fa-xmark text-[9px] mr-1 text-red-600"></i> DITOLAK</span>`;
                }

                // Proof / Payment Method
                let methodClean = p.payment_method || '';
                if (methodClean) {
                    methodClean = methodClean.replace(/^Midtrans\s*\((.*?)\)$/i, '$1').replace(/^Midtrans\s+/i, '');
                    if (methodClean.toLowerCase() === 'payment gateway') methodClean = '';
                }

                let proofBtn = '';
                if (p.proof_image) {
                    proofBtn = `
                        <button onclick="viewProof('${p.proof_image}')" class="inline-flex items-center px-2 py-0.5 bg-orange-50 hover:bg-orange-100 text-orange-700 font-bold rounded text-[10px] border border-orange-200 transition">
                            <i class="fa-solid fa-image mr-1"></i> Bukti Transfer
                        </button>
                    `;
                }

                const payDate = p.created_at ? new Date(p.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : (p.due_date || '-');

                const isConfirmed = Boolean(p.is_confirmed);

                // Detail Data object for modal
                const detailData = {
                    payment_id: p.id,
                    invoice_no: '#INV-' + String(p.id).padStart(5, '0'),
                    status: p.status,
                    has_paid: hasPaid,
                    is_confirmed: isConfirmed,
                    amount: Number(p.amount).toLocaleString('id-ID'),
                    due_date: p.due_date || '-',
                    pay_date: payDate,
                    method: methodClean || (hasPaid ? 'Transfer Bank / Online' : 'Belum Memilih Metode'),
                    room_number: roomNumber,
                    room_type: roomType,
                    room_price: roomPrice,
                    rental_period: rentalPeriod,
                    tenant_name: tenantName,
                    tenant_email: tenantEmail,
                    tenant_phone: tenantPhone,
                    start_date: startDate
                };
                const detailDataAttr = encodeURIComponent(JSON.stringify(detailData));

                // Invoice Column: jika berhasil (approved/lunas) dan sudah dikonfirmasi tampilkan button Invoice, jika belum -
                let invoiceBtn = '';
                if (isApproved && isConfirmed) {
                    invoiceBtn = `
                        <button onclick="openReceiptModal(${p.id}, '${(p.title || '').replace(/'/g, "\\'")}', ${p.amount}, '${p.due_date || ''}', '${(methodClean || 'BCA Virtual Account').replace(/'/g, "\\'")}', '${payDate}', '${tenantName.replace(/'/g, "\\'")}', '${roomNumber}')" class="inline-flex items-center px-3 py-1.5 bg-white hover:bg-slate-50 text-navy-950 font-bold text-xs rounded-lg transition border border-slate-300 shadow-2xs group focus:outline-none cursor-pointer" title="Lihat Invoice Pembayaran">
                            <i class="fa-solid fa-file-invoice mr-1.5 text-orange-600"></i> Invoice
                        </button>
                    `;
                } else {
                    invoiceBtn = `<span class="text-slate-400 font-semibold text-xs">-</span>`;
                }

                return `
                    <tr class="hover:bg-slate-50/80 transition ${isPending ? 'bg-amber-50/20' : ''}">
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span class="font-mono font-bold text-navy-950 block text-xs">#INV-${String(p.id).padStart(5, '0')}</span>
                            <span class="text-[11px] font-semibold text-slate-500 block mt-0.5">${roomNumber}</span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-900 text-xs whitespace-nowrap">
                            ${tenantName}
                        </td>
                        <td class="py-3.5 px-4 font-black text-slate-900 text-xs whitespace-nowrap">
                            Rp ${Number(p.amount).toLocaleString('id-ID')}
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <button type="button" onclick="openPaymentRoomDetailModal('${detailDataAttr}')" class="inline-flex items-center space-x-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-orange-50 hover:bg-orange-100 text-orange-800 border border-orange-200/80 transition shadow-2xs group focus:outline-none cursor-pointer" title="Klik untuk melihat rincian informasi kamar & status pembayaran">
                                <i class="fa-solid fa-calendar-day text-orange-600"></i>
                                <span>${p.due_date || '-'}</span>
                                <i class="fa-solid fa-circle-info text-[11px] text-orange-500 group-hover:scale-110 transition-transform ml-0.5"></i>
                            </button>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="space-y-1 text-xs">
                                <span class="font-semibold text-slate-700 block">${methodClean || (isPending ? '<span class="text-slate-400 font-normal italic">-</span>' : 'Transfer Bank / Online')}</span>
                                ${proofBtn}
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">${statusBadge}</td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">${invoiceBtn}</td>
                    </tr>
                `;
            }).join('');
        }

        // =========================================================================
        // 3. RENDER KEUANGAN TABLE (ARUS KAS MASUK DAN KELUAR)
        // =========================================================================
        function renderFinancesTable(payments, expenses) {
            const tbody = document.getElementById('financesTableBody');
            if (!tbody) return;

            // Build unified transaction list
            let transactions = [];

            // 1. Kas Masuk (Pemasukan dari sewa kamar yang status approved)
            (payments || []).forEach(p => {
                if (p.status === 'approved') {
                    const d = p.created_at ? new Date(p.created_at) : new Date();
                    transactions.push({
                        type: 'in',
                        date: p.created_at ? new Date(p.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : p.due_date,
                        title: p.title + (p.user ? ` (${p.user.name})` : ''),
                        category: 'Sewa Kamar',
                        amount: Number(p.amount),
                        note: 'Pembayaran sewa lunas terverifikasi',
                        id: p.id,
                        rawDate: d
                    });
                }
            });

            // 2. Kas Keluar (Pengeluaran operasional kost)
            (expenses || []).forEach(e => {
                const d = e.created_at ? new Date(e.created_at) : new Date();
                transactions.push({
                    type: 'out',
                    date: e.date,
                    title: e.title,
                    category: e.category,
                    amount: Number(e.amount),
                    note: e.note || '-',
                    id: e.id,
                    isExpense: true,
                    rawDate: d
                });
            });

            // Sort latest first
            transactions.sort((a, b) => b.rawDate - a.rawDate);

            // Filter
            const filter = document.getElementById('filterFinanceType').value;
            if (filter === 'in') transactions = transactions.filter(t => t.type === 'in');
            if (filter === 'out') transactions = transactions.filter(t => t.type === 'out');

            if (transactions.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="py-8 text-center text-slate-400">Belum ada catatan transaksi keuangan.</td></tr>`;
                return;
            }

            tbody.innerHTML = transactions.map(t => {
                const isIncome = t.type === 'in';
                const typeBadge = isIncome
                    ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200"><i class="fa-solid fa-arrow-down mr-1 text-[9px] text-emerald-600"></i> KAS MASUK</span>`
                    : `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 border border-rose-200"><i class="fa-solid fa-arrow-up mr-1 text-[9px] text-rose-600"></i> KAS KELUAR</span>`;

                const amountFormatted = isIncome
                    ? `<span class="font-black text-emerald-600 text-sm">+ Rp ${t.amount.toLocaleString('id-ID')}</span>`
                    : `<span class="font-black text-rose-600 text-sm">- Rp ${t.amount.toLocaleString('id-ID')}</span>`;

                const action = t.isExpense
                    ? `<button onclick="deleteExpense(${t.id})" class="text-slate-400 hover:text-rose-600 font-bold text-xs transition p-1" title="Hapus catatan pengeluaran"><i class="fa-regular fa-trash-can"></i></button>`
                    : `<span class="text-slate-300">-</span>`;

                return `
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">${t.date}</td>
                        <td class="py-3.5 px-4 font-bold text-navy-950">${t.title}</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700">
                                ${t.category}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">${typeBadge}</td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">${amountFormatted}</td>
                        <td class="py-3.5 px-4 text-slate-500 text-[11px] max-w-xs truncate">${t.note}</td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">${action}</td>
                    </tr>
                `;
            }).join('');
        }

        // =========================================================================
        // 4. RENDER COMPLAINTS TABLE
        // =========================================================================
        function renderComplaintsTable(complaints) {
            const tbody = document.getElementById('complaintsTableBody');
            if (!tbody) return;

            if (!complaints || complaints.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="py-8 text-center text-slate-400">Tidak ada pengaduan kendala yang masuk.</td></tr>`;
                return;
            }

            tbody.innerHTML = complaints.map(c => {
                const isPending = c.status === 'pending';
                const isInProgress = c.status === 'in_progress';
                const isResolved = c.status === 'resolved';

                let badge = '';
                if (isPending) {
                    badge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700 border border-red-300"><i class="fa-solid fa-triangle-exclamation mr-1 text-[9px]"></i> BELUM DIPERBAIKI</span>`;
                } else if (isInProgress) {
                    badge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-700 border border-blue-300"><i class="fa-solid fa-spinner fa-spin mr-1 text-[9px]"></i> SEDANG DIKERJAKAN</span>`;
                } else {
                    badge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-700 border border-emerald-300"><i class="fa-solid fa-check-double mr-1 text-[9px]"></i> SELESAI DIPERBAIKI</span>`;
                }

                const userName = c.user ? c.user.name : 'Penghuni';
                const userPhone = c.user ? c.user.phone : '-';
                const roomInfo = c.room_number ? `Kamar ${c.room_number}` : 'Kamar Penghuni';
                const createdAt = new Date(c.created_at).toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
                });

                return `
                    <tr class="hover:bg-slate-50/80 transition ${isPending ? 'bg-orange-50/20' : ''}">
                        <td class="py-4 px-4 text-slate-500 text-[11px] whitespace-nowrap">
                            <i class="fa-regular fa-clock mr-1 text-slate-400"></i> ${createdAt}
                        </td>
                        <td class="py-4 px-4">
                            <p class="font-extrabold text-navy-950 text-sm">${userName}</p>
                            <p class="text-[11px] text-orange-600 font-semibold">${roomInfo}</p>
                            ${userPhone && userPhone !== '-' ? `
                                <a href="https://wa.me/${userPhone.replace(/[^0-9]/g, '')}?text=Halo%20${encodeURIComponent(userName)},%20terkait%20pengaduan%20fasilitas%20Anda:%20${encodeURIComponent(c.message)}" target="_blank" class="inline-flex items-center text-[10px] text-emerald-600 font-bold hover:underline mt-0.5">
                                    <i class="fa-brands fa-whatsapp mr-1"></i> Chat WhatsApp
                                </a>
                            ` : ''}
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                ${c.category}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-700 leading-relaxed font-medium">
                            "${c.message}"
                        </td>
                        <td class="py-4 px-4 text-center whitespace-nowrap">${badge}</td>
                        <td class="py-4 px-4 text-center whitespace-nowrap">
                            <div class="inline-flex items-center space-x-1">
                                ${!isResolved ? `
                                    <button onclick="updateComplaintStatus(${c.id}, 'resolved')" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-[10px] transition shadow-2xs" title="Tandai Selesai Diperbaiki">
                                        <i class="fa-solid fa-check mr-1"></i> Selesai
                                    </button>
                                ` : ''}
                                ${isPending ? `
                                    <button onclick="updateComplaintStatus(${c.id}, 'in_progress')" class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-lg text-[10px] border border-blue-200 transition" title="Tandai Sedang Dikerjakan">
                                        <i class="fa-solid fa-wrench mr-1"></i> Proses
                                    </button>
                                ` : ''}
                                ${isResolved ? `
                                    <button onclick="updateComplaintStatus(${c.id}, 'pending')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-[10px]" title="Buka Kembali">
                                        Buka Lagi
                                    </button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // =========================================================================
        // CUSTOM DROPDOWN HANDLERS (PERSIS MODEL DROPDOWN HALAMAN PENGHUNI)
        // =========================================================================
        function closeAllCustomDropdowns() {
            ['RoomStatus', 'PaymentStatus', 'FinanceType', 'ComplaintStatus'].forEach(name => {
                const menu = document.getElementById(`menuFilter${name}`);
                const arrow = document.getElementById(`arrowFilter${name}`);
                if (menu) menu.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            });

            document.querySelectorAll('[id^="menuPeriod-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
            document.querySelectorAll('[id^="arrowPeriod-"]').forEach(arrow => {
                arrow.style.transform = 'rotate(0deg)';
            });
            document.querySelectorAll('[id^="wrapperPeriod-"]').forEach(wrapper => {
                wrapper.style.zIndex = 'auto';
            });
        }

        function toggleOwnerDropdown(name, event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById(`menuFilter${name}`);
            const arrow = document.getElementById(`arrowFilter${name}`);
            if (!menu) return;

            const isHidden = menu.classList.contains('hidden');
            closeAllCustomDropdowns();

            if (isHidden) {
                menu.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }

        function selectOwnerFilterOption(name, val, labelText) {
            const input = document.getElementById(`filter${name}`);
            if (input) input.value = val;

            const display = document.getElementById(`displayFilter${name}`);
            if (display) display.textContent = labelText;

            const menu = document.getElementById(`menuFilter${name}`);
            if (menu) {
                const optClass = name === 'RoomStatus' ? '.room-status-opt'
                    : name === 'PaymentStatus' ? '.payment-status-opt'
                    : name === 'FinanceType' ? '.finance-type-opt'
                    : '.complaint-status-opt';
                menu.querySelectorAll(optClass).forEach(item => {
                    if (item.dataset.val === String(val)) {
                        item.classList.add('bg-slate-100', 'font-semibold');
                        item.classList.remove('font-medium');
                    } else {
                        item.classList.remove('bg-slate-100', 'font-semibold');
                        item.classList.add('font-medium');
                    }
                });
                menu.classList.add('hidden');
            }

            const arrow = document.getElementById(`arrowFilter${name}`);
            if (arrow) arrow.style.transform = 'rotate(0deg)';

            // Trigger corresponding table filter handler
            if (name === 'RoomStatus') filterRoomsTable();
            else if (name === 'PaymentStatus') filterDueDateTable();
            else if (name === 'FinanceType') filterFinancesTable();
            else if (name === 'ComplaintStatus') filterComplaintsTable();
        }

        // Custom Dropdown Periode Sewa per Baris Kamar
        function toggleRentalPeriodDropdown(roomId, event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById(`menuPeriod-${roomId}`);
            const arrow = document.getElementById(`arrowPeriod-${roomId}`);
            const wrapper = document.getElementById(`wrapperPeriod-${roomId}`);
            if (!menu) return;

            const isHidden = menu.classList.contains('hidden');
            closeAllCustomDropdowns();

            if (isHidden) {
                if (wrapper) wrapper.style.zIndex = '40';
                const btn = document.getElementById(`btnPeriod-${roomId}`);
                if (btn) {
                    const rect = btn.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - rect.bottom;
                    if (spaceBelow < 220) {
                        menu.classList.remove('top-full', 'mt-1.5');
                        menu.classList.add('bottom-full', 'mb-1.5');
                    } else {
                        menu.classList.remove('bottom-full', 'mb-1.5');
                        menu.classList.add('top-full', 'mt-1.5');
                    }
                }
                menu.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                if (wrapper) wrapper.style.zIndex = 'auto';
                menu.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }

        function selectRentalPeriod(roomId, period, event) {
            if (event) event.stopPropagation();
            const display = document.getElementById(`displayPeriod-${roomId}`);
            if (display) display.textContent = period;

            const menu = document.getElementById(`menuPeriod-${roomId}`);
            if (menu) {
                menu.querySelectorAll(`.period-opt-${roomId}`).forEach(el => {
                    if (el.getAttribute('data-period') === period) {
                        el.classList.add('bg-slate-100', 'font-bold');
                        el.classList.remove('font-medium');
                    } else {
                        el.classList.remove('bg-slate-100', 'font-bold');
                        el.classList.add('font-medium');
                    }
                });
                menu.classList.add('hidden');
            }

            const arrow = document.getElementById(`arrowPeriod-${roomId}`);
            if (arrow) arrow.style.transform = 'rotate(0deg)';

            const wrapper = document.getElementById(`wrapperPeriod-${roomId}`);
            if (wrapper) wrapper.style.zIndex = 'auto';

            updateRentalPeriod(roomId, period);
        }

        // Close dropdown when clicked outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-dropdown-wrapper')) {
                closeAllCustomDropdowns();
            }
        });

        // =========================================================================
        // FILTER HANDLERS
        // =========================================================================
        function filterRoomsTable() {
            const filter = document.getElementById('filterRoomStatus').value;
            let filtered = globalData.rooms;
            if (filter === 'available') filtered = filtered.filter(r => r.status === 'available');
            if (filter === 'occupied') filtered = filtered.filter(r => r.status === 'occupied');
            renderRoomsTable(filtered);
        }

        function filterDueDateTable() {
            const filter = document.getElementById('filterPaymentStatus').value;
            let filtered = globalData.payments;
            if (filter === 'pending') filtered = filtered.filter(p => p.status === 'pending');
            if (filter === 'approved') filtered = filtered.filter(p => p.status === 'approved');
            renderDueDateTable(filtered);
        }

        function filterFinancesTable() {
            renderFinancesTable(globalData.payments, globalData.expenses || []);
        }

        function filterComplaintsTable() {
            const filter = document.getElementById('filterComplaintStatus').value;
            let filtered = globalData.complaints;
            if (filter === 'pending') filtered = filtered.filter(c => c.status === 'pending');
            if (filter === 'in_progress') filtered = filtered.filter(c => c.status === 'in_progress');
            if (filter === 'resolved') filtered = filtered.filter(c => c.status === 'resolved');
            renderComplaintsTable(filtered);
        }

        // =========================================================================
        // ROOM ACTIONS (TOGGLE STATUS & EDIT PRICE)
        // =========================================================================
        async function toggleRoomStatus(roomId) {
            try {
                const res = await fetch(`/api/owner/rooms/${roomId}/toggle`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success) {
                    loadDashboardData();
                } else {
                    alert(data.message || 'Gagal mengubah status kamar.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan.');
            }
        }

        function openEditPrice(roomId, roomNumber, currentPrice) {
            document.getElementById('editPriceRoomId').value = roomId;
            document.getElementById('editPriceTitle').textContent = `Perbarui Harga Sewa ${roomNumber}`;
            document.getElementById('editPriceInput').value = currentPrice;
            document.getElementById('editPriceModal').classList.remove('hidden');
        }

        function closeEditPriceModal() {
            document.getElementById('editPriceModal').classList.add('hidden');
        }

        async function submitEditPrice() {
            const roomId = document.getElementById('editPriceRoomId').value;
            const price = document.getElementById('editPriceInput').value;
            try {
                const res = await fetch(`/api/owner/rooms/${roomId}/price`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ price: price })
                });
                const data = await res.json();
                if (data.success) {
                    closeEditPriceModal();
                    loadDashboardData();
                } else {
                    alert(data.message || 'Gagal memperbarui harga.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan.');
            }
        }

        async function updateRentalPeriod(roomId, period) {
            try {
                const res = await fetch(`/api/owner/rooms/${roomId}/rental-period`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ rental_period: period })
                });
                const data = await res.json();
                if (data.success) {
                    if (globalData && globalData.rooms) {
                        const r = globalData.rooms.find(x => x.id === roomId);
                        if (r) r.rental_period = period;
                    }
                } else {
                    alert(data.message || 'Gagal memperbarui periode sewa.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan.');
            }
        }

        // =========================================================================
        // TENANT DETAIL MODAL
        // =========================================================================
        function openTenantModal(dataAttr) {
            try {
                const d = JSON.parse(decodeURIComponent(dataAttr));
                document.getElementById('tenantModalName').textContent = d.name || '-';
                document.getElementById('tenantModalRoomInfo').textContent = `${d.room_number} • ${d.room_type}`;
                document.getElementById('tenantModalEmail').textContent = d.email || '-';
                document.getElementById('tenantModalPhone').textContent = d.phone || '-';
                
                const waLink = document.getElementById('tenantModalWaLink');
                if (d.phone && d.phone !== '-') {
                    waLink.href = `https://wa.me/${d.phone.replace(/[^0-9]/g, '')}?text=Halo%20${encodeURIComponent(d.name)},%20saya%20pengelola%20Kost%20Wisma%20S.`;
                    waLink.classList.remove('hidden');
                } else {
                    waLink.classList.add('hidden');
                }

                let formattedStartDate = '-';
                if (d.start_date && d.start_date !== '-') {
                    const dt = new Date(d.start_date);
                    formattedStartDate = isNaN(dt) ? d.start_date : dt.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                }
                document.getElementById('tenantModalStartDate').textContent = formattedStartDate;
                document.getElementById('tenantModalRentalPeriod').textContent = d.rental_period || 'Bulanan';
                document.getElementById('tenantModalPrice').textContent = `Rp ${d.room_price}`;

                let formattedReg = '-';
                if (d.created_at && d.created_at !== '-') {
                    const dt = new Date(d.created_at);
                    formattedReg = isNaN(dt) ? d.created_at : dt.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                }
                document.getElementById('tenantModalRegistered').textContent = formattedReg;

                // KTP handling
                const ktpPreview = document.getElementById('tenantModalKtpPreview');
                const ktpBadge = document.getElementById('tenantModalKtpBadge');
                if (d.ktp_file) {
                    const filePath = d.ktp_file.startsWith('http') || d.ktp_file.startsWith('/') ? d.ktp_file : `/storage/${d.ktp_file}`;
                    ktpBadge.textContent = 'Sudah Diunggah';
                    ktpBadge.className = 'text-[11px] font-bold text-emerald-700';
                    
                    if (filePath.toLowerCase().endsWith('.pdf')) {
                        ktpPreview.innerHTML = `
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                                <span class="text-xs text-slate-700 font-semibold"><i class="fa-solid fa-file-pdf text-red-600 mr-2 text-base"></i> Dokumen KTP (PDF)</span>
                                <a href="${filePath}" target="_blank" class="px-3 py-1.5 bg-orange-600 text-white font-bold rounded-lg text-xs hover:bg-orange-700 transition">Buka File</a>
                            </div>
                        `;
                    } else {
                        ktpPreview.innerHTML = `
                            <div class="relative group rounded-xl overflow-hidden border border-slate-200 max-h-56 bg-slate-100 flex items-center justify-center p-1">
                                <img src="${filePath}" alt="KTP ${d.name}" class="w-full h-auto max-h-52 object-contain rounded-lg">
                            </div>
                            <div class="mt-2.5 flex justify-center">
                                <a href="${filePath}" target="_blank" class="inline-flex items-center text-xs font-bold text-orange-600 hover:underline">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-1.5"></i> Buka Foto Ukuran Penuh
                                </a>
                            </div>
                        `;
                    }
                } else {
                    ktpBadge.textContent = 'Belum Ada';
                    ktpBadge.className = 'text-[11px] font-semibold text-slate-400';
                    ktpPreview.innerHTML = `<p class="py-4 text-slate-400 text-xs italic">Penghuni belum mengunggah dokumen KTP saat pendaftaran.</p>`;
                }

                document.getElementById('tenantDetailModal').classList.remove('hidden');
            } catch (e) {
                console.error('Error opening tenant modal', e);
            }
        }

        function closeTenantModal() {
            document.getElementById('tenantDetailModal').classList.add('hidden');
        }

        // =========================================================================
        // PAYMENT APPROVAL & RECEIPT MODAL
        // =========================================================================
        async function approvePayment(paymentId) {
            if (!confirm('Verifikasi pembayaran ini sebagai LUNAS?')) return;
            try {
                const res = await fetch(`/api/owner/payments/${paymentId}/approve`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success) {
                    loadDashboardData();
                } else {
                    alert(data.message || 'Gagal memverifikasi.');
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function rejectPayment(paymentId) {
            if (!confirm('Tolak pembayaran ini?')) return;
            try {
                const res = await fetch(`/api/owner/payments/${paymentId}/reject`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success) {
                    loadDashboardData();
                } else {
                    alert(data.message || 'Gagal memproses.');
                }
            } catch (err) {
                console.error(err);
            }
        }

        function openReceiptModal(id, title, amount, dueDate, method, datePaid, userName, roomInfo) {
            document.getElementById('rcpInvoiceId').textContent = '#INV-' + String(id).padStart(5, '0');
            document.getElementById('rcpTitle').textContent = title;
            document.getElementById('rcpAmount').textContent = 'Rp ' + Number(amount).toLocaleString('id-ID');
            document.getElementById('rcpMethod').textContent = method || 'Transfer Bank / Online';
            document.getElementById('rcpDate').textContent = datePaid || dueDate;
            document.getElementById('rcpUser').textContent = userName || '-';
            document.getElementById('rcpRoom').textContent = roomInfo || '-';
            document.getElementById('receiptModal').classList.remove('hidden');
        }

        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.add('hidden');
        }

        // =========================================================================
        // RINCIAN TAGIHAN & INFORMASI KAMAR MODAL
        // =========================================================================
        function openPaymentRoomDetailModal(dataAttr) {
            try {
                const d = JSON.parse(decodeURIComponent(dataAttr));

                document.getElementById('prmRoomNumber').textContent = d.room_number;
                document.getElementById('prmRoomType').textContent = d.room_type || '-';
                document.getElementById('prmTenantName').textContent = d.tenant_name || '-';
                document.getElementById('prmRentalPeriod').textContent = d.rental_period || 'Bulanan';
                document.getElementById('prmRoomPrice').textContent = `Rp ${d.room_price}`;
                document.getElementById('prmDueDate').textContent = d.due_date || '-';
                document.getElementById('prmTenantPhone').textContent = d.tenant_phone || '-';
                document.getElementById('prmTenantEmail').textContent = d.tenant_email || '-';
                document.getElementById('prmAmount').textContent = `Rp ${d.amount}`;

                // Status card styling & content
                const card = document.getElementById('prmStatusCard');
                const icon = document.getElementById('prmStatusIcon');
                const title = document.getElementById('prmStatusTitle');
                const desc = document.getElementById('prmStatusDesc');
                const actionContainer = document.getElementById('prmActionContainer');

                if (d.status === 'rejected') {
                    card.className = 'rounded-xl p-4 mb-4 border bg-rose-50 border-rose-200 text-rose-950 flex items-center justify-between';
                    icon.className = 'w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-lg shrink-0';
                    icon.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>';
                    title.textContent = 'Pembayaran Gagal / Ditolak';
                    title.className = 'font-extrabold text-sm block text-rose-950';
                    desc.textContent = 'Status pembayaran ditolak oleh pengelola';
                    actionContainer.innerHTML = `
                        <button type="button" onclick="closePaymentRoomDetailModal()" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                            Tutup
                        </button>
                    `;
                } else if (d.has_paid) {
                    // Pembayaran Berhasil (Penghuni sudah bayar via VA/Transfer/Sistem)
                    card.className = 'rounded-xl p-4 mb-4 border bg-emerald-50 border-emerald-200 text-emerald-950 flex items-center justify-between';
                    icon.className = 'w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg shrink-0';
                    icon.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
                    title.textContent = 'Pembayaran Berhasil';
                    title.className = 'font-extrabold text-sm block text-emerald-950';

                    if (d.is_confirmed) {
                        desc.textContent = `Status: LUNAS • Pembayaran telah terkonfirmasi via ${d.method}`;
                        actionContainer.innerHTML = `
                            <button type="button" onclick="closePaymentRoomDetailModal(); openReceiptModal(${d.payment_id}, 'Pembayaran Sewa ${d.room_number.replace(/'/g, "\\'")}', '${d.amount.replace(/[^0-9]/g, '')}', '${d.due_date}', '${d.method.replace(/'/g, "\\'")}', '${d.pay_date}', '${d.tenant_name.replace(/'/g, "\\'")}', '${d.room_number.replace(/'/g, "\\'")}')" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow-sm flex items-center justify-center cursor-pointer" title="Status Lunas (Klik untuk melihat invoice)">
                                <i class="fa-solid fa-circle-check mr-1.5"></i> Status Lunas (Terkonfirmasi)
                            </button>
                        `;
                    } else {
                        desc.textContent = `Penghuni telah berhasil membayar via ${d.method}. Klik tombol di bawah untuk konfirmasi status Lunas & menerbitkan invoice.`;
                        actionContainer.innerHTML = `
                            <button type="button" onclick="confirmPaymentAsLunas(${d.payment_id})" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow-sm flex items-center justify-center cursor-pointer">
                                <i class="fa-solid fa-check mr-1.5"></i> Status Lunas
                            </button>
                        `;
                    }
                } else {
                    // Belum Dibayar (Penghuni belum melakukan pembayaran)
                    card.className = 'rounded-xl p-4 mb-4 border bg-amber-50 border-amber-200 text-amber-950 flex items-center justify-between';
                    icon.className = 'w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-lg shrink-0';
                    icon.innerHTML = '<i class="fa-solid fa-clock"></i>';
                    title.textContent = 'Belum Dibayar';
                    title.className = 'font-extrabold text-sm block text-amber-950';
                    desc.textContent = `Penghuni belum melakukan pembayaran. Tenggat waktu: ${d.due_date}`;

                    actionContainer.innerHTML = `
                        <button type="button" disabled class="w-full py-2.5 bg-slate-200 text-slate-400 font-bold rounded-xl text-xs flex items-center justify-center cursor-not-allowed border border-slate-300 shadow-none">
                            <i class="fa-solid fa-ban mr-1.5"></i> Status Lunas
                        </button>
                    `;
                }

                document.getElementById('paymentRoomDetailModal').classList.remove('hidden');
            } catch (err) {
                console.error(err);
            }
        }

        function closePaymentRoomDetailModal() {
            document.getElementById('paymentRoomDetailModal').classList.add('hidden');
        }

        async function confirmPaymentAsLunas(paymentId) {
            try {
                const res = await fetch(`/api/owner/payments/${paymentId}/approve`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success) {
                    closePaymentRoomDetailModal();
                    await loadDashboardData();
                } else {
                    alert(data.message || 'Gagal mengubah status menjadi Lunas.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan.');
            }
        }

        // =========================================================================
        // EXPENSE / KEUANGAN KAS KELUAR
        // =========================================================================
        function openAddExpenseModal() {
            document.getElementById('expTitle').value = '';
            document.getElementById('expAmount').value = '';
            document.getElementById('expNote').value = '';
            document.getElementById('addExpenseModal').classList.remove('hidden');
        }

        function closeAddExpenseModal() {
            document.getElementById('addExpenseModal').classList.add('hidden');
        }

        async function submitAddExpense(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitExpense');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i> Menyimpan...';

            const payload = {
                title: document.getElementById('expTitle').value,
                category: document.getElementById('expCategory').value,
                date: document.getElementById('expDate').value,
                amount: document.getElementById('expAmount').value,
                note: document.getElementById('expNote').value,
            };

            try {
                const res = await fetch('/api/owner/expenses', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.success) {
                    closeAddExpenseModal();
                    loadDashboardData();
                } else {
                    alert(data.message || 'Gagal menyimpan pengeluaran.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-check mr-1.5"></i> Simpan Pengeluaran';
            }
        }

        async function deleteExpense(expenseId) {
            if (!confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?')) return;
            try {
                const res = await fetch(`/api/owner/expenses/${expenseId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success) {
                    loadDashboardData();
                } else {
                    alert(data.message || 'Gagal menghapus pengeluaran.');
                }
            } catch (err) {
                console.error(err);
            }
        }

        // =========================================================================
        // COMPLAINT ACTIONS
        // =========================================================================
        async function updateComplaintStatus(complaintId, newStatus) {
            try {
                const res = await fetch(`/api/owner/complaints/${complaintId}/status`, {
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
                    loadDashboardData();
                } else {
                    alert(data.message || 'Gagal mengubah status pengaduan.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan.');
            }
        }

        // =========================================================================
        // KTP & PROOF VIEWER
        // =========================================================================
        function viewKtp(filePath, userName) {
            document.getElementById('ktpModalTitle').textContent = `Foto KTP - ${userName}`;
            document.getElementById('ktpModalSubtitle').textContent = 'Identitas terdaftar penghuni kost';
            const content = document.getElementById('ktpModalContent');
            if (filePath.toLowerCase().endsWith('.pdf')) {
                content.innerHTML = `
                    <div class="p-6 bg-slate-50 rounded-xl border border-slate-200">
                        <i class="fa-solid fa-file-pdf text-5xl text-red-500 mb-3"></i>
                        <p class="text-xs font-bold text-navy-950 mb-3">Dokumen KTP dalam format PDF</p>
                        <a href="/${filePath}" target="_blank" class="inline-flex items-center px-4 py-2 bg-navy-950 hover:bg-navy-900 text-white font-bold rounded-lg text-xs transition">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i> Buka File PDF KTP
                        </a>
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <img src="/${filePath}" alt="KTP ${userName}" class="max-h-96 mx-auto rounded-xl border border-slate-200 shadow-sm object-contain">
                    <div class="mt-3">
                        <a href="/${filePath}" target="_blank" class="text-xs text-orange-600 hover:underline font-bold">
                            <i class="fa-solid fa-expand mr-1"></i> Buka Gambar Ukuran Penuh
                        </a>
                    </div>
                `;
            }
            document.getElementById('ktpModal').classList.remove('hidden');
        }

        function closeKtpModal() {
            document.getElementById('ktpModal').classList.add('hidden');
        }

        function viewProof(filePath) {
            viewKtp(filePath, 'Bukti Transfer Pembayaran');
            document.getElementById('ktpModalSubtitle').textContent = 'Bukti pembayaran sewa yang diunggah oleh penghuni';
        }

        // =========================================================================
        // LOGOUT
        // =========================================================================
        async function logout() {
            try {
                const res = await fetch('/api/logout', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                const data = await res.json();
                if (data.success) {
                    window.location.href = '/';
                }
            } catch (err) {
                console.error(err);
                window.location.href = '/';
            }
        }

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            handleHash();
            loadDashboardData();
        });
    </script>
</body>
</html>
