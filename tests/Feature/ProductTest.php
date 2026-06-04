<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_products()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/admin/culinary-menu');
        $response->assertStatus(200);
    }
}
