<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentPeriodDays = (int) $request->input('period_days', 7);
        if (!in_array($currentPeriodDays, [7, 30, 90])) {
            $currentPeriodDays = 7;
        }

        $role = Auth::user()->role;
        $adminName = Auth::user()->name;

        // Base metrics for Admin/Kasir
        $pesananHariIni = 0;
        $penghasilanHariIni = 0;
        $transaksiTerbaru = collect();

        // 1. PELANGGAN DASHBOARD (Very Lightweight)
        if ($role === 'pelanggan') {
            // Get user's own customer record if exists
            $pelanggan = Pelanggan::where('nama_pelanggan', $adminName)->first();
            $myOrders = collect();
            $totalPurchases = 0;
            
            if ($pelanggan) {
                $myOrders = Penjualan::where('id_pelanggan', $pelanggan->id_pelanggan)
                                    ->orderBy('waktu_transaksi', 'desc')
                                    ->take(5)
                                    ->get();
                $totalPurchases = Penjualan::where('id_pelanggan', $pelanggan->id_pelanggan)->sum('total_harga_penjualan');
            }

            return view('admin.dashboard', [
                'role' => $role,
                'adminName' => $adminName,
                'myOrders' => $myOrders,
                'totalPurchases' => $totalPurchases,
            ]);
        }

        // 2. KASIR DASHBOARD (Medium weight)
        if ($role === 'kasir') {
            $filterCategoryVal = null;
            $filterDateVal = null;
            $startDate = Carbon::today();
            $endDate = Carbon::today()->endOfDay();
            $filterLabel = 'Hari Ini';

            if ($request->has('filter_date') && !empty($request->input('filter_date'))) {
                // Specific Date Logic
                $filterDateVal = $request->input('filter_date');
                try {
                    $selectedDate = Carbon::parse($filterDateVal);
                } catch (\Exception $e) {
                    $selectedDate = Carbon::today();
                    $filterDateVal = $selectedDate->format('Y-m-d');
                }
                $startDate = $selectedDate->copy()->startOfDay();
                $endDate = $selectedDate->copy()->endOfDay();
                
                if ($selectedDate->isToday()) {
                    $filterLabel = 'Hari Ini (' . $selectedDate->translatedFormat('d M Y') . ')';
                } elseif ($selectedDate->isYesterday()) {
                    $filterLabel = 'Kemarin (' . $selectedDate->translatedFormat('d M Y') . ')';
                } else {
                    $filterLabel = $selectedDate->translatedFormat('d M Y');
                }
            } else {
                // Category Logic
                $filterCategoryVal = $request->input('filter', 'today');
                
                if ($filterCategoryVal === 'today') {
                    $startDate = Carbon::today();
                    $endDate = Carbon::today()->endOfDay();
                    $filterLabel = 'Hari Ini';
                } elseif ($filterCategoryVal === 'yesterday') {
                    $startDate = Carbon::yesterday();
                    $endDate = Carbon::yesterday()->endOfDay();
                    $filterLabel = 'Kemarin';
                } elseif ($filterCategoryVal === 'this_week') {
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    $filterLabel = 'Minggu Ini';
                } elseif ($filterCategoryVal === 'this_month') {
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    $filterLabel = 'Bulan Ini';
                } elseif ($filterCategoryVal === 'this_year') {
                    $startDate = Carbon::now()->startOfYear();
                    $endDate = Carbon::now()->endOfYear();
                    $filterLabel = 'Tahun Ini';
                } elseif ($filterCategoryVal === 'all_time') {
                    $startDate = Carbon::create(2000, 1, 1);
                    $endDate = Carbon::now()->endOfDay();
                    $filterLabel = 'Semua Waktu';
                }
            }

            $pesananHariIni = Penjualan::whereBetween('waktu_transaksi', [$startDate, $endDate])->count();
            $pesananDiproses = Penjualan::whereBetween('waktu_transaksi', [$startDate, $endDate])->where('id_admin', Auth::id())->count();
            $totalCustomers = Pelanggan::count(); // Global
            $transaksiTerbaru = Penjualan::with('pelanggan')
                                    ->whereBetween('waktu_transaksi', [$startDate, $endDate])
                                    ->orderBy('waktu_transaksi', 'desc')
                                    ->take(10)
                                    ->get();
            
            return view('admin.dashboard', [
                'role' => $role,
                'adminName' => $adminName,
                'pesananHariIni' => $pesananHariIni,
                'pesananDiproses' => $pesananDiproses,
                'totalCustomers' => $totalCustomers,
                'transaksiTerbaru' => $transaksiTerbaru,
                'filterCategoryVal' => $filterCategoryVal,
                'filterDateVal' => $filterDateVal,
                'filterLabel' => $filterLabel,
            ]);
        }

        // 3. ADMIN DASHBOARD (Heavy BI)
        $totalProducts = Produk::count();
        $totalCustomers = Pelanggan::count();
        $totalSalesCount = Penjualan::count();
        $totalRevenue = Penjualan::sum('total_harga_penjualan');
        $monthlyRevenue = Penjualan::whereMonth('waktu_transaksi', Carbon::now()->month)->sum('total_harga_penjualan');
        $monthlyOrders = Penjualan::whereMonth('waktu_transaksi', Carbon::now()->month)->count();
        
        $penghasilanHariIni = Penjualan::whereDate('waktu_transaksi', Carbon::today())->sum('total_harga_penjualan');
        $pesananHariIni = Penjualan::whereDate('waktu_transaksi', Carbon::today())->count();

        // Grafik Logic...
        $startDate = Carbon::now()->subDays($currentPeriodDays - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $penjualanPerHari = Penjualan::select(
                DB::raw('DATE(waktu_transaksi) as tanggal'),
                DB::raw('SUM(total_harga_penjualan) as total_penghasilan'),
                DB::raw('COUNT(*) as jumlah_pesanan')
            )
            ->whereBetween('waktu_transaksi', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        $labelsGrafik = [];
        $dataPenghasilan = [];
        $dataJumlahPesanan = [];

        for ($i = 0; $i < $currentPeriodDays; $i++) {
            $tanggalLoop = $startDate->copy()->addDays($i);
            $formattedDateKey = $tanggalLoop->format('Y-m-d');
            $labelsGrafik[] = $formattedDateKey;

            if (isset($penjualanPerHari[$formattedDateKey])) {
                $dataPenghasilan[] = $penjualanPerHari[$formattedDateKey]->total_penghasilan;
                $dataJumlahPesanan[] = $penjualanPerHari[$formattedDateKey]->jumlah_pesanan;
            } else {
                $dataPenghasilan[] = 0;
                $dataJumlahPesanan[] = 0;
            }
        }
        
        $chartData = [
            'labels' => $labelsGrafik,
            'penghasilan' => $dataPenghasilan,
            'jumlah_pesanan' => $dataJumlahPesanan,
        ];

        $transaksiTerbaru = Penjualan::with('pelanggan')
                                    ->orderBy('waktu_transaksi', 'desc')
                                    ->take(5)
                                    ->get();

        $recentCustomers = Pelanggan::orderBy('created_at', 'desc')->take(5)->get();

        $topProducts = DB::table('detail_penjualans')
                        ->join('produks', 'detail_penjualans.id_produk', '=', 'produks.id_produk')
                        ->select('produks.nama_produk', DB::raw('SUM(detail_penjualans.jumlah_produk) as total_terjual'))
                        ->groupBy('produks.id_produk', 'produks.nama_produk')
                        ->orderBy('total_terjual', 'desc')
                        ->take(5)
                        ->get();

        return view('admin.dashboard', [
            'role' => $role,
            'adminName' => $adminName,
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'totalSalesCount' => $totalSalesCount,
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'monthlyOrders' => $monthlyOrders,
            'penghasilanHariIni' => $penghasilanHariIni,
            'pesananHariIni' => $pesananHariIni,
            'chartData' => json_encode($chartData),
            'transaksiTerbaru' => $transaksiTerbaru,
            'recentCustomers' => $recentCustomers,
            'topProducts' => $topProducts,
            'currentPeriodDays' => $currentPeriodDays,
        ]);
    }
}