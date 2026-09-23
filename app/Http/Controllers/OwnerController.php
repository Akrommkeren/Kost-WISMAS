<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Facility;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Complaint;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function getDashboardData()
    {
        $rooms = Room::with(['bookings' => function($q) {
            $q->with('user')->latest();
        }])->get();

        $facilities = Facility::all();
        $payments = Payment::with(['user', 'room'])->latest()->get();
        $pendingPayments = $payments->where('status', 'pending')->values();
        $approvedPayments = $payments->where('status', 'approved')->values();

        $complaints = Complaint::with('user')->latest()->get();
        $unresolvedComplaintsCount = $complaints->where('status', '!=', 'resolved')->count();

        $totalRooms = $rooms->count();
        $occupiedCount = $rooms->where('status', 'occupied')->count();
        $availableCount = $rooms->where('status', 'available')->count();
        $totalRevenue = $approvedPayments->sum('amount');
        $pendingAmount = $pendingPayments->sum('amount');

        return response()->json([
            'rooms' => $rooms,
            'facilities' => $facilities,
            'payments' => $payments,
            'pendingPayments' => $pendingPayments,
            'complaints' => $complaints,
            'stats' => [
                'totalRooms' => $totalRooms,
                'occupiedCount' => $occupiedCount,
                'availableCount' => $availableCount,
                'totalRevenue' => $totalRevenue,
                'pendingAmount' => $pendingAmount,
                'unresolvedComplaintsCount' => $unresolvedComplaintsCount,
            ]
        ]);
    }

    public function toggleRoomStatus(Room $room)
    {
        $room->status = $room->status === 'available' ? 'occupied' : 'available';
        $room->save();

        return response()->json([
            'success' => true,
            'message' => 'Status ' . $room->number . ' diubah menjadi ' . $room->status,
            'room' => $room,
        ]);
    }

    public function updateRoomPrice(Request $request, Room $room)
    {
        $request->validate(['price' => 'required|numeric|min:0']);
        $room->price = $request->price;
        $room->save();

        return response()->json([
            'success' => true,
            'message' => 'Harga ' . $room->number . ' berhasil diperbarui.',
            'room' => $room,
        ]);
    }

    public function approvePayment(Payment $payment)
    {
        $payment->status = 'approved';
        $payment->save();

        // If payment is approved, set room status to occupied
        if ($payment->room) {
            $payment->room->update(['status' => 'occupied']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran #' . $payment->id . ' disetujui & diverifikasi LUNAS.',
        ]);
    }

    public function rejectPayment(Payment $payment)
    {
        $payment->status = 'rejected';
        $payment->save();

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran #' . $payment->id . ' ditolak.',
        ]);
    }

    public function storeFacility(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $facility = Facility::create([
            'name' => $request->name,
            'icon' => $request->input('icon', 'fa-solid fa-check'),
            'subtitle' => $request->input('subtitle', 'Fasilitas Wisma S'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas ' . $facility->name . ' berhasil ditambahkan.',
            'facility' => $facility,
        ]);
    }

    public function deleteFacility(Facility $facility)
    {
        $name = $facility->name;
        $facility->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas ' . $name . ' dihapus.',
        ]);
    }

    public function updateComplaintStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        $complaint->status = $request->status;
        $complaint->save();

        $statusLabels = [
            'pending' => 'Belum Diperbaiki',
            'in_progress' => 'Sedang Dikerjakan',
            'resolved' => 'Selesai Diperbaiki'
        ];

        return response()->json([
            'success' => true,
            'message' => 'Status pengaduan #' . $complaint->id . ' diubah menjadi ' . ($statusLabels[$complaint->status] ?? $complaint->status),
            'complaint' => $complaint->load('user'),
        ]);
    }
}
