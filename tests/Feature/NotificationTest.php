<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_notifications()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/admin/notifications');
        $response->assertStatus(200);
    }
}
