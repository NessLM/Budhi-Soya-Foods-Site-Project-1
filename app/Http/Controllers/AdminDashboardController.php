<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
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
        $riwayat = DB::table('login_logs')
            ->where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->limit(5)
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
