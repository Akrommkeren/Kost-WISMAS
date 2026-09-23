<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function getDashboardData()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $booking = Booking::with('room')->where('user_id', $user->id)->first();
        $pendingPayments = Payment::where('user_id', $user->id)->where('status', 'pending')->get();
        $paidPayments = Payment::where('user_id', $user->id)->where('status', 'approved')->get();

        return response()->json([
            'user' => $user,
            'booking' => $booking,
            'pendingPayments' => $pendingPayments,
            'paidPayments' => $paidPayments,
        ]);
    }

    public function bookRoom(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Silakan masuk terlebih dahulu.'], 401);
        }

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($request->room_id);
        if ($room->status === 'occupied') {
            return response()->json(['success' => false, 'message' => 'Kamar ini sudah terisi.'], 400);
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now(),
            'status' => 'pending',
        ]);

        // Create initial pending payment
        Payment::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'title' => 'Tagihan Awal ' . $room->number,
            'amount' => $room->price,
            'due_date' => now()->addDays(3)->format('d M Y'),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan booking ' . $room->number . ' berhasil diajukan!',
        ]);
    }

    public function uploadPaymentProof(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'payment_id' => 'required|exists:payments,id',
        ]);

        $payment = Payment::where('user_id', $user->id)->findOrFail($request->payment_id);
        $payment->update([
            'payment_method' => $request->input('payment_method', 'Transfer Bank'),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diunggah! Menunggu konfirmasi owner.',
        ]);
    }
}
