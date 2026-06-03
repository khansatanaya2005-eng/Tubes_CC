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
        return [
            'nama_produk' => fake()->words(2, true), // contoh: "Sleek Hat"
            'harga_produk' => fake()->numberBetween(15000, 50000), // Harga antara 15rb - 50rb
            'kategori_produk' => fake()->randomElement(['Kopi', 'Non-Kopi', 'Makanan Ringan']),
            'deskripsi_produk' => fake()->sentence(),
            // Kita kosongkan foto untuk data dummy
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}