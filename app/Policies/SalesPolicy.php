<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class SalesPolicy
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
        return $user->role === 'kasir';
    }

    public function view(User $user, Penjualan $penjualan): bool
    {
        return $user->role === 'kasir';
    }

    public function create(User $user): bool
    {
        return $user->role === 'kasir';
    }

    public function update(User $user, Penjualan $penjualan): bool
    {
        return false;
    }

    public function delete(User $user, Penjualan $penjualan): bool
    {
        return false;
    }

    public function restore(User $user, Penjualan $penjualan): bool
    {
        return false;
    }

    public function forceDelete(User $user, Penjualan $penjualan): bool
    {
        return false;
    }
}
