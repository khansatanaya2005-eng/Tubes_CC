<?php

namespace App\Policies;

use App\Models\Pelanggan;
use App\Models\User;

class CustomerPolicy
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

    public function view(User $user, Pelanggan $pelanggan): bool
    {
        return $user->role === 'kasir';
    }

    public function create(User $user): bool
    {
        return $user->role === 'kasir';
    }

    public function update(User $user, Pelanggan $pelanggan): bool
    {
        return $user->role === 'kasir';
    }

    public function delete(User $user, Pelanggan $pelanggan): bool
    {
        return $user->role === 'kasir';
    }

    public function restore(User $user, Pelanggan $pelanggan): bool
    {
        return false;
    }

    public function forceDelete(User $user, Pelanggan $pelanggan): bool
    {
        return false;
    }
}
