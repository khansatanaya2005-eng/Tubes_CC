<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Nonaktifkan pengecekan foreign key untuk sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel sebelum seeding
        User::truncate();
        Produk::truncate();
        Pelanggan::truncate();
        Penjualan::truncate();
        DetailPenjualan::truncate();
        DB::table('notifications')->truncate();

        $this->command->info('Membuat data dummy...');

        // 1. Buat Role dan Akun Admin/Kasir/User melalui RoleSeeder
        $this->call([
            RoleSeeder::class,
        ]);
        
        $admin = User::where('role', 'admin')->first();
        $this->command->info('Roles dan Akun telah dibuat!');

        // 2. Buat 30 Produk menggunakan factory
        $produks = Produk::factory(30)->create();
        $this->command->info('30 Produk telah dibuat!');

        // 3. Buat 50 Pelanggan menggunakan factory
        $pelanggans = Pelanggan::factory(50)->create();
        $this->command->info('50 Pelanggan telah dibuat!');

        // 4. Buat 200 Transaksi Penjualan Acak
        for ($i = 0; $i < 200; $i++) {
            // Pilih pelanggan secara acak, 20% kemungkinan tanpa pelanggan (umum)
            $pelanggan = rand(0, 100) > 20 ? $pelanggans->random() : null;

            // Buat data penjualan utama
            $penjualan = Penjualan::create([
                'id_admin' => $admin->id,
                'id_pelanggan' => $pelanggan?->id_pelanggan,
                'waktu_transaksi' => fake()->dateTimeBetween('-6 months', 'now'),
                'metode_pembayaran' => 'CASH',
                'catatan_penjualan' => fake()->optional()->sentence(),
                'total_harga_penjualan' => 0, // Akan di-update setelah detail dibuat
            ]);

            $totalHarga = 0;
            // Buat antara 1 sampai 4 detail item untuk setiap penjualan
            $jumlahItem = rand(1, 4);

            // Ambil produk secara acak untuk transaksi ini, pastikan tidak ada duplikat
            $produkUntukTransaksi = $produks->random($jumlahItem)->unique('id_produk');

            foreach ($produkUntukTransaksi as $produk) {
                $jumlahProduk = rand(1, 3);
                $subtotal = $produk->harga_produk * $jumlahProduk;
                $totalHarga += $subtotal;

                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_produk' => $produk->id_produk,
                    'jumlah_produk' => $jumlahProduk,
                    'harga_satuan_saat_transaksi' => $produk->harga_produk,
                    'subtotal_produk' => $subtotal,
                ]);
            }

            // Update total harga di penjualan utama
            $penjualan->total_harga_penjualan = $totalHarga;
            $penjualan->save();
        }
        $this->command->info('200 Transaksi Penjualan acak telah dibuat!');


        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}