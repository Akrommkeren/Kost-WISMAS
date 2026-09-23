<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Facility;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Owner Users
        $owner = User::create([
            'name' => 'Iskandar',
            'email' => 'iskandar@wismas.com',
            'phone' => '081299991111',
            'role' => 'owner',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Owner Wisma S',
            'email' => 'owner@wismas.com',
            'phone' => '081299990000',
            'role' => 'owner',
            'password' => Hash::make('password'),
        ]);

        // Penghuni Users
        $tenant = User::create([
            'name' => 'Akrom',
            'email' => 'akrom@gmail.com',
            'phone' => '081234567777',
            'role' => 'penghuni',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'phone' => '081234567890',
            'role' => 'penghuni',
            'password' => Hash::make('password'),
        ]);

        // Rooms
        $roomsData = [
            [
                'number' => 'Kamar 101',
                'type' => 'Standard Single',
                'price' => 1200000,
                'status' => 'available',
                'image' => 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=600&q=80',
                'features' => ['Kasur Single', 'Wi-Fi', 'Kamar Mandi Luar'],
            ],
            [
                'number' => 'Kamar 102',
                'type' => 'Executive Deluxe',
                'price' => 1500000,
                'status' => 'occupied',
                'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=600&q=80',
                'features' => ['AC Dingin', 'Kamar Mandi Dalam', 'Wi-Fi Cepat'],
            ],
            [
                'number' => 'Kamar 103',
                'type' => 'Executive Deluxe',
                'price' => 1500000,
                'status' => 'available',
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80',
                'features' => ['AC Dingin', 'Kamar Mandi Dalam', 'Jendela Luar'],
            ],
            [
                'number' => 'Kamar 201',
                'type' => 'VIP King Suite',
                'price' => 2000000,
                'status' => 'occupied',
                'image' => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=600&q=80',
                'features' => ['Springbed King', 'Smart TV', 'Water Heater', 'Balkon'],
            ],
            [
                'number' => 'Kamar 202',
                'type' => 'Standard Single',
                'price' => 1250000,
                'status' => 'available',
                'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=600&q=80',
                'features' => ['Kasur Busa Premium', 'Wi-Fi', 'Meja Belajar'],
            ],
            [
                'number' => 'Kamar 203',
                'type' => 'Executive Deluxe',
                'price' => 1500000,
                'status' => 'occupied',
                'image' => 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=600&q=80',
                'features' => ['AC Inverter', 'Kamar Mandi Dalam', 'Lemari 3 Pintu'],
            ],
        ];

        foreach ($roomsData as $roomInfo) {
            Room::create($roomInfo);
        }

        // Facilities
        $facilitiesData = [
            ['name' => 'Wi-Fi Cepat', 'icon' => 'fa-solid fa-wifi', 'subtitle' => 'Up to 100 Mbps'],
            ['name' => 'AC Dingin', 'icon' => 'fa-solid fa-snowflake', 'subtitle' => 'Inverter Hemat Listrik'],
            ['name' => 'Kamar Mandi Dalam', 'icon' => 'fa-solid fa-shower', 'subtitle' => 'Shower & Water Heater'],
            ['name' => 'Dapur Bersama', 'icon' => 'fa-solid fa-utensils', 'subtitle' => 'Kompor & Kulkas'],
            ['name' => 'Parkir Luas', 'icon' => 'fa-solid fa-square-parking', 'subtitle' => 'Mobil & Motor Aman'],
            ['name' => 'CCTV 24 Jam', 'icon' => 'fa-solid fa-video', 'subtitle' => 'Keamanan Terjamin'],
        ];

        foreach ($facilitiesData as $fac) {
            Facility::create($fac);
        }

        // Booking & Payment for Tenant (Budi Santoso - Kamar 102)
        $kamar102 = Room::where('number', 'Kamar 102')->first();

        Booking::create([
            'user_id' => $tenant->id,
            'room_id' => $kamar102->id,
            'start_date' => now()->startOfMonth(),
            'status' => 'confirmed',
        ]);

        Payment::create([
            'user_id' => $tenant->id,
            'room_id' => $kamar102->id,
            'title' => 'Sewa Bulan Oktober 2026',
            'amount' => 1500000,
            'due_date' => '15 Okt 2026',
            'status' => 'pending',
        ]);

        Payment::create([
            'user_id' => $tenant->id,
            'room_id' => $kamar102->id,
            'title' => 'Sewa Bulan September 2026',
            'amount' => 1500000,
            'due_date' => '15 Sep 2026',
            'payment_method' => 'BCA Flash',
            'status' => 'approved',
        ]);
    }
}
