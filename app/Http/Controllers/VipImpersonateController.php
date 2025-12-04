<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VipImpersonate;

class VipImpersonateController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel vip_impersonates
        $data = VipImpersonate::all();

        // Hitung jumlah alerts
        $countAlerts = $data->count();

        // Hitung jumlah mention tiap platform
        $platformCounts = $data->groupBy('platform')->map->count();
        $topLeakedData = VipImpersonate::latest()->take(5)->get();

        return view('vip.index', compact('countAlerts', 'platformCounts', 'topLeakedData'));
    }

    public function detail()
    {
        $data = VipImpersonate::latest()->get();
        $groupedData = $data->groupBy('platform');

        return view('vip.detail', compact('groupedData'));
    }
}

