<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Facility;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function getDashboardData()
    {
        $rooms = Room::all();
        $facilities = Facility::all();
        $pendingPayments = Payment::with(['user', 'room'])->where('status', 'pending')->get();

        $occupiedCount = Room::where('status', 'occupied')->count();
        $totalRooms = Room::count();
        $totalRevenue = Payment::where('status', 'approved')->sum('amount');
        $pendingAmount = Payment::where('status', 'pending')->sum('amount');

        return response()->json([
            'rooms' => $rooms,
            'facilities' => $facilities,
            'pendingPayments' => $pendingPayments,
            'stats' => [
                'occupiedCount' => $occupiedCount,
                'totalRooms' => $totalRooms,
                'totalRevenue' => $totalRevenue,
                'pendingAmount' => $pendingAmount,
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
}
