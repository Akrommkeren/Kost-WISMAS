<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Allow logging in by email or phone
        $user = User::where('email', $credentials['email'])
            ->orWhere('phone', $credentials['email'])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Determine role by email domain
            if (str_ends_with(strtolower($user->email), '@wismas.com') && $user->role !== 'owner') {
                $user->update(['role' => 'owner']);
            } elseif (str_ends_with(strtolower($user->email), '@gmail.com') && $user->role !== 'tenant') {
                $user->update(['role' => 'tenant']);
            }

            Auth::login($user);
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil masuk!',
                'user' => [
                    'name' => $user->name,
                    'role' => $user->role,
                    'email' => $user->email,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email/No HP atau kata sandi tidak cocok.',
        ], 422);
    }

    public function register(Request $request)
    {
        $email = strtolower(trim($request->email ?? ''));
        $isOwner = str_ends_with($email, '@wismas.com');
        $role = $isOwner ? 'owner' : 'tenant';

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:4'],
            'ktp_file' => [$isOwner ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 4 karakter.',
            'ktp_file.required' => 'File foto KTP / fotokopi KTP wajib diunggah untuk pendaftaran akun penghuni.',
            'ktp_file.file' => 'File KTP tidak valid.',
            'ktp_file.mimes' => 'File KTP harus berformat JPG, JPEG, PNG, atau PDF.',
            'ktp_file.max' => 'Ukuran file KTP maksimal 2MB.',
        ]);

        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $file = $request->file('ktp_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/ktp');
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }
            $file->move($destination, $filename);
            $ktpPath = 'uploads/ktp/' . $filename;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'ktp_file' => $ktpPath,
            'role' => $role,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        return response()->json([
            'success' => true,
            'message' => $isOwner ? 'Pendaftaran berhasil! Selamat datang di Portal Owner Kost Wisma S.' : 'Pendaftaran berhasil! Akun penghuni kost Anda telah aktif.',
            'user' => [
                'name' => $user->name,
                'role' => $user->role,
                'email' => $user->email,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Anda telah keluar dari akun.',
        ]);
    }
}
