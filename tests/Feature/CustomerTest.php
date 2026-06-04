<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_kasir_can_view_customers()
    {
        $kasir = User::factory()->create(['role' => 'kasir']);
        $response = $this->actingAs($kasir)->get('/admin/guest-registry');
        $response->assertStatus(200);
    }
}
