<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_admin_route()
    {
        $user = User::factory()->create(['role' => 'pelanggan']);
        $response = $this->actingAs($user)->get('/admin/produk');
        $response->assertStatus(403);
    }

    public function test_kasir_cannot_manage_products()
    {
        $kasir = User::factory()->create(['role' => 'kasir']);
        $response = $this->actingAs($kasir)->get('/admin/produk');
        $response->assertStatus(403);
    }

    public function test_admin_can_manage_products()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/admin/produk');
        $response->assertStatus(200);
    }
}
