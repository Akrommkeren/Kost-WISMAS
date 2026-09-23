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
                            900: '#0f172a',
                            950: '#0b1120',
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col font-sans">

    <!-- TOP NAVIGATION BAR (OWNER) -->
    <header class="bg-navy-900 text-white shadow-md sticky top-0 z-40 border-b border-navy-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-kost.jpg') }}" alt="Logo Kost Wisma S" class="w-9 h-9 rounded-lg object-cover ring-2 ring-orange-500">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="font-extrabold text-base tracking-tight text-white">Kost Wisma S</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-orange-600 text-white uppercase tracking-wider">Owner Portal</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Sistem Manajemen Kamar, Keuangan & Pengaduan</p>
                    </div>
                </div>

                <!-- Owner Account & Action Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}?view=preview" class="hidden sm:inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs font-semibold text-slate-300 hover:text-white bg-navy-800 hover:bg-navy-700 border border-slate-700 transition">
                        <i class="fa-solid fa-desktop mr-1.5 text-orange-400"></i> Pratinjau Web Kost
                    </a>

                    <div class="hidden md:flex items-center space-x-2 px-3 py-1 bg-navy-800/80 rounded-lg border border-slate-700/60">
                        <div class="w-6 h-6 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs">
                            <i class="fa-solid fa-user-shield text-[10px]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-bold leading-tight text-white">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-400 leading-tight">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <button onclick="logout()" class="inline-flex items-center px-3.5 py-1.5 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg transition shadow-sm">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-1.5"></i> Keluar
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- MAIN DASHBOARD CONTENT -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Welcome Banner & Quick Info -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-navy-900">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola seluruh kamar kost, pantau tenggat waktu bayar penghuni, dan tindak lanjuti pengaduan fasilitas.</p>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="loadDashboardData()" class="px-3.5 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition flex items-center">
                    <i class="fa-solid fa-rotate mr-1.5 text-slate-500"></i> Muat Ulang Data
                </button>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            
            <!-- Card 1: Okupansi Kamar -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between text-slate-500 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider">Okupansi Kamar</span>
                    <div class="w-8 h-8 rounded-lg bg-navy-50 text-navy-800 flex items-center justify-center">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                </div>
                <div class="flex items-baseline space-x-2">
                    <span id="statOccupied" class="text-2xl font-black text-navy-900">-</span>
                    <span class="text-xs text-slate-400">terisi dari</span>
                    <span id="statTotalRooms" class="text-base font-bold text-slate-600">-</span>
                    <span class="text-xs text-slate-400">kamar</span>
                </div>
                <div class="mt-3 flex items-center text-xs">
                    <span id="statAvailableBadge" class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i class="fa-solid fa-circle-check mr-1 text-[9px]"></i> <span id="statAvailableCount">-</span> Tersedia
                    </span>
                </div>
            </div>

            <!-- Card 2: Pemasukan Lunas -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between text-slate-500 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider">Pemasukan Lunas</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>
                <div class="text-2xl font-black text-emerald-600" id="statRevenue">Rp 0</div>
                <p class="mt-3 text-[11px] text-slate-500 flex items-center">
                    <i class="fa-solid fa-check mr-1 text-emerald-500"></i> Pembayaran sewa yang terverifikasi
                </p>
            </div>

            <!-- Card 3: Tagihan Menunggu / Jatuh Tempo -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between text-slate-500 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider">Menunggu Verifikasi</span>
                    <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
                <div class="text-2xl font-black text-orange-600" id="statPendingAmount">Rp 0</div>
                <p class="mt-3 text-[11px] text-slate-500 flex items-center">
                    <i class="fa-solid fa-bell mr-1 text-orange-500"></i> Perlu verifikasi bukti transfer
                </p>
            </div>

            <!-- Card 4: Pengaduan Belum Diperbaiki -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between text-slate-500 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider">Pengaduan Aktif</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <div class="flex items-baseline space-x-2">
                    <span id="statUnresolvedComplaints" class="text-2xl font-black text-amber-600">-</span>
                    <span class="text-xs text-slate-400">laporan kendala</span>
                </div>
                <div class="mt-3">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                        <i class="fa-solid fa-wrench mr-1 text-[9px]"></i> Belum selesai diperbaiki
                    </span>
                </div>
            </div>

        </div>

        <!-- MAIN TABS CONTAINER -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            
            <!-- Tabs Navigation -->
            <div class="border-b border-slate-200 px-6 pt-4 flex space-x-6 overflow-x-auto text-xs font-bold">
                <button id="tabBtnRooms" onclick="switchSection('rooms')" class="pb-3 border-b-2 border-orange-600 text-orange-600 flex items-center whitespace-nowrap">
                    <i class="fa-solid fa-bed mr-2 text-sm"></i> Manajemen Kamar & Penghuni
                </button>
                <button id="tabBtnFinances" onclick="switchSection('finances')" class="pb-3 text-slate-500 hover:text-navy-900 flex items-center whitespace-nowrap">
                    <i class="fa-solid fa-receipt mr-2 text-sm"></i> Keuangan & Tenggat Waktu Bayar
                </button>
                <button id="tabBtnComplaints" onclick="switchSection('complaints')" class="pb-3 text-slate-500 hover:text-navy-900 flex items-center whitespace-nowrap">
                    <i class="fa-solid fa-clipboard-list mr-2 text-sm"></i> Daftar Pengaduan Penghuni
                    <span id="badgeComplaintCount" class="ml-2 px-1.5 py-0.5 rounded-full text-[10px] bg-amber-500 text-white font-extrabold hidden">0</span>
                </button>
            </div>

            <!-- SECTION 1: MANAJEMEN KAMAR & PENGHUNI -->
            <div id="sectionRooms" class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                    <div>
                        <h2 class="text-base font-extrabold text-navy-900">Daftar Kamar Kost & Penghuni</h2>
                        <p class="text-xs text-slate-500">Kelola status ketersediaan kamar (tersedia / terisi), tarif sewa, serta rincian data penghuni dan KTP.</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select id="filterRoomStatus" onchange="filterRoomsTable()" class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-navy-600 focus:outline-none bg-white">
                            <option value="all">Semua Status Kamar</option>
                            <option value="available">Hanya Kamar Tersedia</option>
                            <option value="occupied">Hanya Kamar Terisi (Tidak Tersedia)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-navy-900 text-white uppercase text-[10px] tracking-wider">
                                <th class="p-3.5">Kamar</th>
                                <th class="p-3.5">Tipe & Fasilitas</th>
                                <th class="p-3.5">Tarif Sewa / Bulan</th>
                                <th class="p-3.5">Status Ketersediaan</th>
                                <th class="p-3.5">Penghuni Saat Ini</th>
                                <th class="p-3.5">Foto KTP Penghuni</th>
                                <th class="p-3.5 text-center">Aksi Pengelola</th>
                            </tr>
                        </thead>
                        <tbody id="roomsTableBody" class="divide-y divide-slate-200">
                            <!-- Populated by JavaScript -->
                            <tr>
                                <td colspan="7" class="p-6 text-center text-slate-400">Memuat data kamar...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 2: KEUANGAN & WAKTU TENGGAT BAYAR -->
            <div id="sectionFinances" class="p-6 hidden">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                    <div>
                        <h2 class="text-base font-extrabold text-navy-900">Keuangan & Waktu Tenggat Bayar Penghuni</h2>
                        <p class="text-xs text-slate-500">Pantau jatuh tempo sewa, riwayat tagihan, dan verifikasi bukti transfer pembayaran dari penghuni.</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select id="filterPaymentStatus" onchange="filterPaymentsTable()" class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-navy-600 focus:outline-none bg-white">
                            <option value="all">Semua Status Pembayaran</option>
                            <option value="pending">Menunggu Verifikasi (Pending)</option>
                            <option value="approved">Lunas (Disetujui)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-navy-900 text-white uppercase text-[10px] tracking-wider">
                                <th class="p-3.5">Tagihan & Kamar</th>
                                <th class="p-3.5">Nama Penghuni</th>
                                <th class="p-3.5">Nominal</th>
                                <th class="p-3.5">Waktu Tenggat Bayar</th>
                                <th class="p-3.5">Bukti Transfer</th>
                                <th class="p-3.5">Status Pembayaran</th>
                                <th class="p-3.5 text-center">Tindakan Owner</th>
                            </tr>
                        </thead>
                        <tbody id="paymentsTableBody" class="divide-y divide-slate-200">
                            <!-- Populated by JavaScript -->
                            <tr>
                                <td colspan="7" class="p-6 text-center text-slate-400">Memuat data keuangan...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 3: DAFTAR PENGADUAN PENGHUNI -->
            <div id="sectionComplaints" class="p-6 hidden">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                    <div>
                        <h2 class="text-base font-extrabold text-navy-900">Daftar Pengaduan Kendala dari Penghuni</h2>
                        <p class="text-xs text-slate-500">Tinjau keluhan fasilitas penghuni yang belum diperbaiki atau belum dilaksanakan agar segera ditindaklanjuti.</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select id="filterComplaintStatus" onchange="filterComplaintsTable()" class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-navy-600 focus:outline-none bg-white">
                            <option value="all">Semua Status Pengaduan</option>
                            <option value="pending">Belum Diperbaiki (Perlu Tindakan)</option>
                            <option value="in_progress">Sedang Dikerjakan</option>
                            <option value="resolved">Selesai Diperbaiki</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-navy-900 text-white uppercase text-[10px] tracking-wider">
                                <th class="p-3.5">Waktu Masuk</th>
                                <th class="p-3.5">Penghuni & Kamar</th>
                                <th class="p-3.5">Kategori</th>
                                <th class="p-3.5" style="width: 38%;">Pesan Pengaduan Kendala</th>
                                <th class="p-3.5">Status Perbaikan</th>
                                <th class="p-3.5 text-center">Tindakan Owner</th>
                            </tr>
                        </thead>
                        <tbody id="complaintsTableBody" class="divide-y divide-slate-200">
                            <!-- Populated by JavaScript -->
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-400">Memuat data pengaduan...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

    <!-- ========================================================================= -->
    <!-- MODAL PREVIEW FOTO KTP PENGHUNI -->
    <!-- ========================================================================= -->
    <div id="ktpModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative border border-slate-200 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-3 border-b border-slate-200 mb-4">
                <div>
                    <h3 class="font-bold text-base text-navy-900" id="ktpModalTitle">Dokumen KTP Penghuni</h3>
                    <p class="text-xs text-slate-500" id="ktpModalSubtitle">Identitas terdaftar penghuni kost</p>
                </div>
                <button onclick="closeKtpModal()" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
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
    <div id="editPriceModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl relative border border-slate-200">
            <h3 class="font-bold text-base text-navy-900 mb-1" id="editPriceTitle">Perbarui Tarif Kamar</h3>
            <p class="text-xs text-slate-500 mb-4">Masukkan harga sewa per bulan terbaru.</p>
            <input type="hidden" id="editPriceRoomId">
            <div class="mb-4">
                <label class="block text-xs font-bold text-navy-900 uppercase mb-1">Harga Baru (Rp)</label>
                <input type="number" id="editPriceInput" step="50000" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-navy-600 focus:outline-none text-sm font-semibold">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditPriceModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition">Batal</button>
                <button type="button" onclick="submitEditPrice()" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg text-xs transition">Simpan Tarif</button>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let globalData = {
            rooms: [],
            payments: [],
            complaints: []
        };

        // Switch Sections (Tabs)
        function switchSection(section) {
            ['rooms', 'finances', 'complaints'].forEach(s => {
                const el = document.getElementById('section' + s.charAt(0).toUpperCase() + s.slice(1));
                const btn = document.getElementById('tabBtn' + s.charAt(0).toUpperCase() + s.slice(1));
                if (el && btn) {
                    if (s === section) {
                        el.classList.remove('hidden');
                        btn.className = "pb-3 border-b-2 border-orange-600 text-orange-600 font-bold flex items-center whitespace-nowrap";
                    } else {
                        el.classList.add('hidden');
                        btn.className = "pb-3 text-slate-500 hover:text-navy-900 font-bold flex items-center whitespace-nowrap";
                    }
                }
            });
        }

        // Fetch Dashboard Data
        async function loadDashboardData() {
            try {
                const res = await fetch('/api/owner/dashboard');
                const data = await res.json();
                globalData = data;

                // Update Stats
                document.getElementById('statTotalRooms').textContent = data.stats.totalRooms || 0;
                document.getElementById('statOccupied').textContent = data.stats.occupiedCount || 0;
                document.getElementById('statAvailableCount').textContent = data.stats.availableCount || 0;
                document.getElementById('statRevenue').textContent = 'Rp ' + Number(data.stats.totalRevenue || 0).toLocaleString('id-ID');
                document.getElementById('statPendingAmount').textContent = 'Rp ' + Number(data.stats.pendingAmount || 0).toLocaleString('id-ID');
                
                const unresolvedCount = data.stats.unresolvedComplaintsCount || 0;
                document.getElementById('statUnresolvedComplaints').textContent = unresolvedCount;
                
                const badge = document.getElementById('badgeComplaintCount');
                if (badge) {
                    if (unresolvedCount > 0) {
                        badge.textContent = unresolvedCount;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }

                // Render Tables
                renderRoomsTable(data.rooms);
                renderPaymentsTable(data.payments);
                renderComplaintsTable(data.complaints);
            } catch (err) {
                console.error(err);
                alert('Gagal memuat data dashboard.');
            }
        }

        // Render Rooms Table
        function renderRoomsTable(rooms) {
            const tbody = document.getElementById('roomsTableBody');
            if (!tbody) return;

            if (!rooms || rooms.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="p-6 text-center text-slate-400">Belum ada data kamar terdaftar.</td></tr>`;
                return;
            }

            tbody.innerHTML = rooms.map(room => {
                const isAvailable = room.status === 'available';
                const statusBadge = isAvailable
                    ? `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"><i class="fa-solid fa-circle-check mr-1 text-[9px]"></i> Tersedia</span>`
                    : `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-300"><i class="fa-solid fa-lock mr-1 text-[9px]"></i> Terisi</span>`;
                
                const toggleBtn = isAvailable
                    ? `<button onclick="toggleRoomStatus(${room.id})" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-md font-bold text-[11px] transition" title="Ubah status ke Terisi"><i class="fa-solid fa-toggle-on text-emerald-600 mr-1"></i> Set Terisi</button>`
                    : `<button onclick="toggleRoomStatus(${room.id})" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-md font-bold text-[11px] transition" title="Ubah status ke Tersedia"><i class="fa-solid fa-toggle-off text-slate-400 mr-1"></i> Buka Kamar</button>`;

                // Get Occupant Info (latest booking with user)
                let occupantHtml = `<span class="text-slate-400 italic">Belum ada penghuni</span>`;
                let ktpHtml = `<span class="text-slate-400">-</span>`;

                const activeBooking = room.bookings && room.bookings.length > 0 ? room.bookings[0] : null;
                if (activeBooking && activeBooking.user) {
                    const u = activeBooking.user;
                    occupantHtml = `
                        <div>
                            <p class="font-bold text-navy-900">${u.name}</p>
                            <p class="text-[11px] text-slate-500">${u.email}</p>
                            <a href="https://wa.me/${(u.phone || '').replace(/[^0-9]/g, '')}" target="_blank" class="inline-flex items-center text-[10px] text-emerald-600 hover:text-emerald-700 font-semibold mt-0.5">
                                <i class="fa-brands fa-whatsapp mr-1"></i> ${u.phone || '-'}
                            </a>
                        </div>
                    `;

                    if (u.ktp_file) {
                        ktpHtml = `
                            <button onclick="viewKtp('${u.ktp_file}', '${u.name}')" class="px-2.5 py-1 rounded bg-orange-50 hover:bg-orange-100 text-orange-700 font-bold text-[10px] border border-orange-200 flex items-center transition">
                                <i class="fa-solid fa-id-card mr-1 text-xs"></i> Lihat KTP
                            </button>
                        `;
                    } else {
                        ktpHtml = `<span class="text-[10px] text-slate-400 italic">Belum upload</span>`;
                    }
                }

                return `
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-3.5 font-extrabold text-navy-900">${room.number}</td>
                        <td class="p-3.5">
                            <span class="font-bold text-slate-700">${room.type}</span>
                            <div class="text-[10px] text-slate-400 truncate max-w-xs mt-0.5">
                                ${(Array.isArray(room.features) ? room.features.join(' • ') : '')}
                            </div>
                        </td>
                        <td class="p-3.5">
                            <div class="flex items-center space-x-1.5 font-bold text-navy-900">
                                <span>Rp ${Number(room.price).toLocaleString('id-ID')}</span>
                                <button onclick="openEditPrice(${room.id}, '${room.number}', ${room.price})" class="text-slate-400 hover:text-orange-600 transition p-1" title="Edit Harga">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="p-3.5">${statusBadge}</td>
                        <td class="p-3.5">${occupantHtml}</td>
                        <td class="p-3.5">${ktpHtml}</td>
                        <td class="p-3.5 text-center">
                            ${toggleBtn}
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Render Payments Table
        function renderPaymentsTable(payments) {
            const tbody = document.getElementById('paymentsTableBody');
            if (!tbody) return;

            if (!payments || payments.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="p-6 text-center text-slate-400">Belum ada catatan tagihan/pembayaran.</td></tr>`;
                return;
            }

            tbody.innerHTML = payments.map(p => {
                const isApproved = p.status === 'approved';
                const isPending = p.status === 'pending';

                let statusBadge = '';
                if (isApproved) {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"><i class="fa-solid fa-circle-check mr-1 text-[9px]"></i> Lunas</span>`;
                } else if (isPending) {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-orange-50 text-orange-700 border border-orange-200"><i class="fa-solid fa-clock mr-1 text-[9px]"></i> Menunggu Verifikasi</span>`;
                } else {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-200"><i class="fa-solid fa-xmark mr-1 text-[9px]"></i> Ditolak</span>`;
                }

                const userName = p.user ? p.user.name : 'Penghuni';
                const userPhone = p.user ? p.user.phone : '-';
                const roomInfo = p.room ? `Kamar ${p.room.number}` : '-';

                const proofBtn = p.proof_image
                    ? `<button onclick="viewProof('${p.proof_image}')" class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px]"><i class="fa-solid fa-image mr-1"></i> Bukti Bayar</button>`
                    : `<span class="text-[10px] text-slate-400">Transfer Bank</span>`;

                const actionBtns = isPending ? `
                    <div class="flex items-center justify-center space-x-1.5">
                        <button onclick="approvePayment(${p.id})" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded font-bold text-[10px] transition"><i class="fa-solid fa-check mr-1"></i> Lunas</button>
                        <button onclick="rejectPayment(${p.id})" class="px-2.5 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded font-bold text-[10px] transition"><i class="fa-solid fa-xmark mr-1"></i> Tolak</button>
                    </div>
                ` : `<span class="text-[10px] text-slate-400 italic">Selesai</span>`;

                return `
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-3.5">
                            <p class="font-extrabold text-navy-900">${p.title || 'Sewa Kamar'}</p>
                            <p class="text-[11px] font-semibold text-orange-600">${roomInfo}</p>
                        </td>
                        <td class="p-3.5">
                            <p class="font-bold text-slate-800">${userName}</p>
                            <p class="text-[10px] text-slate-500">${userPhone}</p>
                        </td>
                        <td class="p-3.5 font-extrabold text-navy-900">
                            Rp ${Number(p.amount).toLocaleString('id-ID')}
                        </td>
                        <td class="p-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                <i class="fa-regular fa-calendar mr-1 text-[10px]"></i> ${p.due_date || '-'}
                            </span>
                        </td>
                        <td class="p-3.5">${proofBtn}</td>
                        <td class="p-3.5">${statusBadge}</td>
                        <td class="p-3.5 text-center">${actionBtns}</td>
                    </tr>
                `;
            }).join('');
        }

        // Render Complaints Table
        function renderComplaintsTable(complaints) {
            const tbody = document.getElementById('complaintsTableBody');
            if (!tbody) return;

            if (!complaints || complaints.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="p-6 text-center text-slate-400">Tidak ada pengaduan kendala yang masuk.</td></tr>`;
                return;
            }

            tbody.innerHTML = complaints.map(c => {
                const isPending = c.status === 'pending';
                const isInProgress = c.status === 'in_progress';
                const isResolved = c.status === 'resolved';

                let badge = '';
                if (isPending) {
                    badge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700 border border-red-300"><i class="fa-solid fa-triangle-exclamation mr-1 text-[9px]"></i> Belum Diperbaiki</span>`;
                } else if (isInProgress) {
                    badge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-700 border border-blue-300"><i class="fa-solid fa-spinner fa-spin mr-1 text-[9px]"></i> Sedang Dikerjakan</span>`;
                } else {
                    badge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-700 border border-emerald-300"><i class="fa-solid fa-check-double mr-1 text-[9px]"></i> Selesai Diperbaiki</span>`;
                }

                const userName = c.user ? c.user.name : 'Penghuni';
                const userPhone = c.user ? c.user.phone : '-';
                const roomInfo = c.room_number ? `Kamar ${c.room_number}` : 'Kamar Penghuni';
                const createdAt = new Date(c.created_at).toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
                });

                return `
                    <tr class="hover:bg-slate-50/80 transition ${isPending ? 'bg-orange-50/20' : ''}">
                        <td class="p-3.5 text-slate-500 text-[11px] whitespace-nowrap">
                            <i class="fa-regular fa-clock mr-1 text-slate-400"></i> ${createdAt}
                        </td>
                        <td class="p-3.5">
                            <p class="font-bold text-navy-900">${userName}</p>
                            <p class="text-[11px] text-orange-600 font-semibold">${roomInfo}</p>
                            <a href="https://wa.me/${(userPhone || '').replace(/[^0-9]/g, '')}?text=Halo%20${encodeURIComponent(userName)},%20terkait%20pengaduan%20fasilitas%20Anda:%20${encodeURIComponent(c.message)}" target="_blank" class="inline-flex items-center text-[10px] text-emerald-600 font-semibold hover:underline mt-0.5">
                                <i class="fa-brands fa-whatsapp mr-1"></i> Chat Penghuni
                            </a>
                        </td>
                        <td class="p-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                ${c.category}
                            </span>
                        </td>
                        <td class="p-3.5 text-slate-700 leading-relaxed font-medium">
                            "${c.message}"
                        </td>
                        <td class="p-3.5 whitespace-nowrap">${badge}</td>
                        <td class="p-3.5 text-center whitespace-nowrap">
                            <div class="inline-flex items-center space-x-1">
                                ${!isResolved ? `
                                    <button onclick="updateComplaintStatus(${c.id}, 'resolved')" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded text-[10px] transition shadow-sm" title="Tandai Selesai Diperbaiki">
                                        <i class="fa-solid fa-check mr-1"></i> Selesai
                                    </button>
                                ` : ''}
                                ${isPending ? `
                                    <button onclick="updateComplaintStatus(${c.id}, 'in_progress')" class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded text-[10px] border border-blue-200 transition" title="Tandai Sedang Dikerjakan">
                                        <i class="fa-solid fa-wrench mr-1"></i> Proses
                                    </button>
                                ` : ''}
                                ${isResolved ? `
                                    <button onclick="updateComplaintStatus(${c.id}, 'pending')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded text-[10px]" title="Buka Kembali">
                                        Buka Lagi
                                    </button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Filter Rooms Table
        function filterRoomsTable() {
            const filter = document.getElementById('filterRoomStatus').value;
            let filtered = globalData.rooms;
            if (filter === 'available') filtered = filtered.filter(r => r.status === 'available');
            if (filter === 'occupied') filtered = filtered.filter(r => r.status === 'occupied');
            renderRoomsTable(filtered);
        }

        // Filter Payments Table
        function filterPaymentsTable() {
            const filter = document.getElementById('filterPaymentStatus').value;
            let filtered = globalData.payments;
            if (filter === 'pending') filtered = filtered.filter(p => p.status === 'pending');
            if (filter === 'approved') filtered = filtered.filter(p => p.status === 'approved');
            renderPaymentsTable(filtered);
        }

        // Filter Complaints Table
        function filterComplaintsTable() {
            const filter = document.getElementById('filterComplaintStatus').value;
            let filtered = globalData.complaints;
            if (filter === 'pending') filtered = filtered.filter(c => c.status === 'pending');
            if (filter === 'in_progress') filtered = filtered.filter(c => c.status === 'in_progress');
            if (filter === 'resolved') filtered = filtered.filter(c => c.status === 'resolved');
            renderComplaintsTable(filtered);
        }

        // Toggle Room Status
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

        // Edit Room Price
        function openEditPrice(roomId, roomNumber, currentPrice) {
            document.getElementById('editPriceRoomId').value = roomId;
            document.getElementById('editPriceTitle').textContent = `Perbarui Tarif Kamar ${roomNumber}`;
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

        // Approve / Reject Payment
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

        // Update Complaint Status
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

        // View KTP Modal
        function viewKtp(filePath, userName) {
            document.getElementById('ktpModalTitle').textContent = `Foto KTP - ${userName}`;
            const content = document.getElementById('ktpModalContent');
            if (filePath.toLowerCase().endsWith('.pdf')) {
                content.innerHTML = `
                    <div class="p-6 bg-slate-50 rounded-xl border border-slate-200">
                        <i class="fa-solid fa-file-pdf text-5xl text-red-500 mb-3"></i>
                        <p class="text-xs font-bold text-navy-900 mb-3">Dokumen KTP dalam format PDF</p>
                        <a href="/${filePath}" target="_blank" class="inline-flex items-center px-4 py-2 bg-navy-900 hover:bg-navy-800 text-white font-bold rounded-lg text-xs transition">
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
            viewKtp(filePath, 'Bukti Pembayaran');
        }

        // Logout
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
            }
        }

        // Init
        document.addEventListener('DOMContentLoaded', loadDashboardData);
    </script>
</body>
</html>
