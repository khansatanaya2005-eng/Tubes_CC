<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori = fake()->randomElement(['Kopi', 'Non-Kopi', 'Makanan Ringan']);
        
        $kopi = ['Espresso', 'Americano', 'Cappuccino', 'Cafe Latte', 'Mocha', 'Macchiato', 'Flat White', 'Affogato', 'Kopi Susu Gula Aren', 'Cold Brew', 'V60 Pour Over', 'Caramel Macchiato'];
        $nonKopi = ['Matcha Latte', 'Taro Latte', 'Red Velvet Latte', 'Chocolate Ice', 'Lemon Tea', 'Lychee Tea', 'Thai Tea', 'Milkshake Vanilla', 'Smoothie Berry'];
        $makananRingan = ['French Fries', 'Dimsum', 'Onion Rings', 'Churros', 'Pisang Goreng', 'Roti Bakar', 'Croissant', 'Waffle', 'Nachos', 'Chicken Wings'];

        if ($kategori === 'Kopi') {
            $namaProduk = fake()->randomElement($kopi);
        } elseif ($kategori === 'Non-Kopi') {
            $namaProduk = fake()->randomElement($nonKopi);
        } else {
            $namaProduk = fake()->randomElement($makananRingan);
        }

        // Tambahkan varian acak agar nama lebih unik jika di-generate banyak (misal: "Espresso Signature")
        $tambahan = fake()->randomElement(['', 'Special', 'Premium', 'Signature', 'Delight', 'Original']);
        $namaFinal = trim("$namaProduk $tambahan");

        return [
            'nama_produk' => $namaFinal,
            'harga_produk' => fake()->numberBetween(15, 50) * 1000, // Harga kelipatan ribuan (15.000 - 50.000)
            'kategori_produk' => $kategori,
            'deskripsi_produk' => fake()->sentence(),
            // Kita kosongkan foto untuk data dummy
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}