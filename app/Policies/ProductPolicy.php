<?php

namespace App\Policies;

use App\Models\Produk;
use App\Models\User;

class ProductPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->role === 'kasir' || $user->role === 'pelanggan'; // Pelanggan and Kasir can view
    }

    public function view(User $user, Produk $produk): bool
    {
        return $user->role === 'kasir' || $user->role === 'pelanggan';
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Produk $produk): bool
    {
        return false;
    }

    public function delete(User $user, Produk $produk): bool
    {
        return false;
    }

    public function restore(User $user, Produk $produk): bool
    {
        return false;
    }

    public function forceDelete(User $user, Produk $produk): bool
    {
        return false;
    }
}
