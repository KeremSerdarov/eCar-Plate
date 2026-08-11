<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerification;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // OTP ibermek
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:15',
        ]);

        // 6 sanly kod döret
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Bazada ýazgy döret
        PhoneVerification::create([
            'phone_number' => $request->phone_number,
            'code' => $code,
            'is_verified' => false,
            'expires_at' => now()->addSeconds(90),
        ]);

        // Hakyky SMS ýok — kody session-da sakla we gaýtaryp ber
        session(['otp_code' => $code, 'otp_phone' => $request->phone_number]);

        return response()->json([
            'success' => true,
            'code' => $code, // frontende görkeziler
        ]);
    }

    // OTP tassyklamak
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'code' => 'required|string|size:6',
        ]);

        $otp = PhoneVerification::where('phone_number', $request->phone_number)
            ->where('code', $request->code)
            ->where('is_verified', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json([
                'success' => false,
                'message' => 'Kod nädogry ýa-da möhleti geçdi!',
            ]);
        }

        $otp->update(['is_verified' => true]);

        session(['phone_verified' => true, 'verified_phone' => $request->phone_number]);

        return response()->json(['success' => true]);
    }
}