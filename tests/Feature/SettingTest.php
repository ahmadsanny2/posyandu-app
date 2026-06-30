<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Admin can view the settings edit page.
     */
    public function test_admin_can_access_settings_edit_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('settings.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('settings.edit');
    }

    /**
     * Test Admin can update settings.
     */
    public function test_admin_can_update_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->patch(route('settings.update'), [
            'posyandu_name' => 'Posyandu Melati Indah',
            'address' => 'Kecamatan Melati, Kota Indah',
            'phone' => '081122334455',
            'email' => 'melati@posyandu.com',
            'leader_name' => 'Ibu Sri Wahyuni',
        ]);

        $response->assertStatus(302); // Redirect back
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'posyandu_name' => 'Posyandu Melati Indah',
            'address' => 'Kecamatan Melati, Kota Indah',
            'phone' => '081122334455',
            'email' => 'melati@posyandu.com',
            'leader_name' => 'Ibu Sri Wahyuni',
        ]);
    }

    /**
     * Test non-Admin (e.g. Kader) is forbidden from accessing/updating settings.
     */
    public function test_non_admin_cannot_access_settings_page(): void
    {
        $kader = User::factory()->create(['role' => 'kader']);

        $response1 = $this->actingAs($kader)->get(route('settings.edit'));
        $response1->assertStatus(403);

        $response2 = $this->actingAs($kader)->patch(route('settings.update'), [
            'posyandu_name' => 'Hack Name',
        ]);
        $response2->assertStatus(403);
    }
}
