<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Plate;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Admin login sahypasy
    public function loginPage()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // Admin giriş
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password_hash)) {
            return back()->withErrors(['message' => 'Ulanyjy ady ýa-da parol nädogry!']);
        }

        session(['admin_logged_in' => true, 'admin_username' => $admin->username]);

        return redirect()->route('admin.dashboard');
    }

    // Admin dashboard
    public function dashboard(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $filter = $request->get('filter', 'all');

        $query = Plate::with(['region', 'plateType', 'user']);

        if ($filter !== 'all') {
            $query->whereHas('plateType', fn($q) => $q->where('name', $filter));
        }

        $plates = $query->latest('registered_at')->get();

        $totalRevenue = Plate::sum('price_paid');
        $vipCount = Plate::whereHas('plateType', fn($q) => $q->where('name', 'VIP Nomer'))->count();
        $seqCount = Plate::whereHas('plateType', fn($q) => $q->where('name', 'Yzygiderli Nomer'))->count();

        $regions = Region::all();

        return view('admin.dashboard', compact('plates', 'totalRevenue', 'vipCount', 'seqCount', 'regions', 'filter'));
    }

    // Belgi poz
    public function deletePlate($id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['success' => false], 401);
        }

        $plate = Plate::findOrFail($id);
        $plate->user()->delete();
        $plate->delete();

        return response()->json(['success' => true]);
    }

    // Admin çykyş
    public function logout(Request $request)
    {
        session()->forget(['admin_logged_in', 'admin_username']);
        return redirect()->route('admin.login');
    }
}