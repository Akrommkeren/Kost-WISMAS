<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Complaint;
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
            'start_date' => 'nullable|date',
            'duration' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_method' => 'nullable|string',
            'phone' => 'nullable|string|max:25',
            'proof_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'notes' => 'nullable|string|max:500',
        ]);

        $room = Room::findOrFail($request->room_id);
        if ($room->status === 'occupied') {
            return response()->json(['success' => false, 'message' => 'Kamar ini sudah terisi.'], 400);
        }

        // Update nomor telepon user jika diisi dan belum ada
        if ($request->filled('phone')) {
            $user->phone = $request->phone;
            $user->save();
        }

        $startDate = $request->start_date ? $request->start_date : now()->toDateString();
        $booking = Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => $startDate,
            'status' => 'pending',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $proofPath = $request->file('proof_image')->store('payment_proofs', 'public');
        }

        $durationLabel = $request->duration ?: '1 Bulan';
        $amount = $request->filled('amount') && (int)$request->amount > 0 ? (int)$request->amount : (int)$room->price;
        $paymentMethod = $request->payment_method ?: 'Transfer Bank BCA';

        // Buat record pembayaran awal transaksi booking
        $payment = Payment::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'title' => 'Tagihan Booking ' . $room->number . ' (' . $durationLabel . ')',
            'amount' => $amount,
            'due_date' => now()->addDays(3)->format('d M Y'),
            'payment_method' => $paymentMethod,
            'proof_image' => $proofPath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi booking ' . $room->number . ' berhasil diajukan!',
            'booking_id' => $booking->id,
            'payment_id' => $payment->id,
            'room_number' => $room->number,
            'room_type' => $room->type,
            'amount' => $amount,
            'amount_formatted' => 'Rp ' . number_format($amount, 0, ',', '.'),
            'duration' => $durationLabel,
            'start_date' => $startDate,
            'payment_method' => $paymentMethod,
            'user_name' => $user->name,
            'user_phone' => $user->phone ?? $request->phone,
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

    public function storeComplaint(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Silakan masuk terlebih dahulu.'], 401);
        }

        $request->validate([
            'category' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
        ]);

        $booking = Booking::with('room')->where('user_id', $user->id)->first();
        $roomNumber = $booking && $booking->room ? $booking->room->number : null;

        $complaint = Complaint::create([
            'user_id' => $user->id,
            'room_number' => $roomNumber,
            'category' => $request->category,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dikirim dan dicatat ke daftar kendala pengelola kost!',
            'complaint' => $complaint,
        ]);
    }
}
