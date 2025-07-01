<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\LoginLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $adminCount = Admin::count();
        $userCount = User::count();
        $productCount = DB::table('produk')->count();
        // Ambil riwayat login admin maksimal 4 record terbaru
        $riwayat = LoginLog::where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
    
        return view('admin.dashboard', compact(
            'admin',
            'adminCount',
            'userCount',
            'productCount',
            'riwayat'          // <— pastikan ini ada
        ));
    }    
}
