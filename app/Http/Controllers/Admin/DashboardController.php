<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
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

        // Data untuk Kartu Ringkasan (Hari Ini)
        $penghasilanHariIni = Penjualan::whereDate('waktu_transaksi', Carbon::today())->sum('total_harga_penjualan');
        $pesananHariIni = Penjualan::whereDate('waktu_transaksi', Carbon::today())->count();

        // Data untuk Grafik (berdasarkan periode yang dipilih)
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
                return Carbon::parse($item->tanggal)->format('Y-m-d'); // Pastikan key adalah format Y-m-d
            });

        $labelsGrafik = [];
        $dataPenghasilan = [];
        $dataJumlahPesanan = [];
        $currentDate = Carbon::now();

        for ($i = 0; $i < $currentPeriodDays; $i++) {
            // Mulai dari tanggal paling lama ke tanggal hari ini
            $tanggalLoop = $startDate->copy()->addDays($i);
            $formattedDateKey = $tanggalLoop->format('Y-m-d'); // Format kunci Y-m-d
            $labelsGrafik[] = $formattedDateKey; // Kirim format YYYY-MM-DD untuk Chart.js adapter

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

        // Data untuk Tabel Transaksi Terbaru
        $transaksiTerbaru = Penjualan::with('pelanggan')
                                    ->orderBy('waktu_transaksi', 'desc')
                                    ->take(5)
                                    ->get();

        return view('admin.dashboard', [
            'adminName' => Auth::user()->name,
            'penghasilanHariIni' => $penghasilanHariIni,
            'pesananHariIni' => $pesananHariIni,
            'chartData' => json_encode($chartData),
            'transaksiTerbaru' => $transaksiTerbaru,
            'currentPeriodDays' => $currentPeriodDays,
        ]);
    }
}