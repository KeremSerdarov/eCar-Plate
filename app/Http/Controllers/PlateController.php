<?php

namespace App\Http\Controllers;

use App\Models\ForbiddenPlate;
use App\Models\Plate;
use App\Models\PlateType;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;

class PlateController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('home', compact('regions'));
    }

    // Belginiň elýeterliligini barla
    public function check(Request $request)
    {
        $number = $request->number;

        // 4 san barlag
        if (!preg_match('/^\d{4}$/', $number)) {
            return response()->json(['valid' => false, 'message' => 'Diňe 4 san bolmaly!']);
        }

        // Gadagan belgiler
        $forbidden = ForbiddenPlate::pluck('number')->toArray();
        if (in_array($number, $forbidden)) {
            return response()->json(['valid' => false, 'message' => 'Bu belgi gadagan!']);
        }

        // 4 birmeňzeş
        if (preg_match('/^(\d)\1{3}$/', $number)) {
            return response()->json(['valid' => false, 'message' => '4 birmeňzeş san bolup bilmez!']);
        }

        // Eýýäm alynmy
        $regionId = $request->region_id ?? 1;
        $exists = Plate::where('number', $number)->where('region_id', $regionId)->exists();
        if ($exists) {
            return response()->json(['valid' => false, 'message' => 'Bu belgi eýýäm alyndy!']);
        }

        // Görnüşini we bahasyny kesgitle
        $info = $this->getPlateInfo($number);

        return response()->json([
            'valid' => true,
            'type' => $info['type'],
            'price' => $info['price'],
        ]);
    }

    // Hasaba alyş
    public function register(Request $request)
    {
        // Telefon tassyklandymy
        if (!session('phone_verified')) {
            return response()->json(['success' => false, 'message' => 'Telefon tassyklanmady!']);
        }

        $request->validate([
            'number' => 'required|string|size:4',
            'region_id' => 'required|exists:regions,id',
            'full_name' => 'required|string|max:150',
            'dob' => 'required|date_format:d.m.Y',
            'passport' => 'required|string|max:20',
            'car_model' => 'required|string|max:100',
        ]);

        // Ulanyjy öň alynmy
        $userExists = User::where('passport_number', $request->passport)->exists();
        if ($userExists) {
            return response()->json(['success' => false, 'message' => 'Bu pasport bilen eýýäm nomer alyndy!']);
        }

        // Belgi elýeterliligini barla
        $forbidden = ForbiddenPlate::pluck('number')->toArray();
        if (in_array($request->number, $forbidden)) {
            return response()->json(['success' => false, 'message' => 'Bu belgi gadagan!']);
        }

        $exists = Plate::where('number', $request->number)
            ->where('region_id', $request->region_id)
            ->exists();
        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Bu belgi eýýäm alyndy!']);
        }

        // Belgi görnüşi
        $info = $this->getPlateInfo($request->number);
        $plateType = PlateType::where('name', $info['type'])->first();

        // Ulanyjy döret
        $dob = \Carbon\Carbon::createFromFormat('d.m.Y', $request->dob)->format('Y-m-d');
        $user = User::create([
            'full_name' => $request->full_name,
            'date_of_birth' => $dob,
            'passport_number' => $request->passport,
            'phone_number' => session('verified_phone'),
        ]);

        // Belgi döret
        Plate::create([
            'number' => $request->number,
            'prefix' => 'AB',
            'region_id' => $request->region_id,
            'plate_type_id' => $plateType->id,
            'user_id' => $user->id,
            'car_model' => $request->car_model,
            'price_paid' => $info['price'],
            'registered_at' => now(),
        ]);

        // Session-y arassala
        session()->forget(['phone_verified', 'verified_phone', 'otp_code', 'otp_phone']);

        return response()->json([
            'success' => true,
            'message' => $request->number . ' nomeri üstünlikli alyndy!',
            'price' => $info['price'],
        ]);
    }

    // Belgi görnüşini kesgitleýän funksiya
    private function getPlateInfo(string $number): array
    {
        $digits = str_split($number);
        $counts = array_count_values($digits);

        // Yzygiderli
        $sequences = ['1234', '2345', '3456', '4567', '5678', '6789', '9876', '8765', '7654', '6543', '5432', '4321'];
        if (in_array($number, $sequences)) {
            return ['type' => 'Yzygiderli Nomer', 'price' => 800];
        }

        // VIP — iki jübüt
        $pairs = array_filter($counts, fn($c) => $c === 2);
        if (count($pairs) === 2) {
            return ['type' => 'VIP Nomer', 'price' => 1000];
        }

        // VIP — ABBA
        if ($digits[0] === $digits[3] && $digits[1] === $digits[2]) {
            return ['type' => 'VIP Nomer', 'price' => 1000];
        }

        return ['type' => 'Premium Nomer', 'price' => 300];
    }
}