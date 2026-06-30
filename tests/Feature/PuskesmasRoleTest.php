<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Toddler;
use App\Models\PregnantWoman;
use App\Models\Elderly;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PuskesmasRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that Puskesmas user can access dashboard and gets directed to managerial view.
     */
    public function test_puskesmas_can_access_dashboard(): void
    {
        $puskesmas = User::create([
            'name' => 'Puskesmas Kebon Jeruk',
            'email' => 'puskesmas@posyandu.com',
            'password' => bcrypt('password'),
            'role' => 'puskesmas',
        ]);

        $response = $this->actingAs($puskesmas)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.managerial');
    }

    /**
     * Test that Puskesmas user can access report pages and prints reports.
     */
    public function test_puskesmas_can_access_reports_and_print(): void
    {
        $puskesmas = User::create([
            'name' => 'Puskesmas Kebon Jeruk',
            'email' => 'puskesmas@posyandu.com',
            'password' => bcrypt('password'),
            'role' => 'puskesmas',
        ]);

        $response1 = $this->actingAs($puskesmas)->get(route('reports.index'));
        $response1->assertStatus(200);

        $response2 = $this->actingAs($puskesmas)->get(route('reports.print', [
            'report_type' => 'toddler',
            'month' => 6,
            'year' => 2026,
        ]));
        $response2->assertStatus(200);
    }

    /**
     * Test that Puskesmas can view participants records list and details.
     */
    public function test_puskesmas_can_view_participants_and_schedules(): void
    {
        $puskesmas = User::create([
            'name' => 'Puskesmas Kebon Jeruk',
            'email' => 'puskesmas@posyandu.com',
            'password' => bcrypt('password'),
            'role' => 'puskesmas',
        ]);

        $parent = User::factory()->create(['role' => 'parent']);
        
        $toddler = Toddler::create([
            'user_id' => $parent->id,
            'name' => 'Anak Test',
            'gender' => 'M',
            'birth_date' => '2025-01-01',
            'address' => 'Jl. Test',
        ]);

        $responseList = $this->actingAs($puskesmas)->get(route('toddlers.index'));
        $responseList->assertStatus(200);

        $responseShow = $this->actingAs($puskesmas)->get(route('toddlers.show', $toddler->id));
        $responseShow->assertStatus(200);
    }

    /**
     * Test that Puskesmas user is forbidden from performing write/mutate actions (CRUD).
     */
    public function test_puskesmas_is_forbidden_from_crud_actions(): void
    {
        $puskesmas = User::create([
            'name' => 'Puskesmas Kebon Jeruk',
            'email' => 'puskesmas@posyandu.com',
            'password' => bcrypt('password'),
            'role' => 'puskesmas',
        ]);

        $parent = User::factory()->create(['role' => 'parent']);
        
        $toddler = Toddler::create([
            'user_id' => $parent->id,
            'name' => 'Anak Test',
            'gender' => 'M',
            'birth_date' => '2025-01-01',
            'address' => 'Jl. Test',
        ]);

        // Attempting to visit create page
        $responseCreate = $this->actingAs($puskesmas)->get(route('toddlers.create'));
        $responseCreate->assertStatus(403);

        // Attempting to store a new toddler
        $responseStore = $this->actingAs($puskesmas)->post(route('toddlers.store'), [
            'name' => 'Fahri Baru',
            'birth_date' => '2025-02-14',
            'gender' => 'M',
            'address' => 'Jl. Mawar',
        ]);
        $responseStore->assertStatus(403);

        // Attempting to edit
        $responseEdit = $this->actingAs($puskesmas)->get(route('toddlers.edit', $toddler->id));
        $responseEdit->assertStatus(403);

        // Attempting to delete
        $responseDelete = $this->actingAs($puskesmas)->delete(route('toddlers.destroy', $toddler->id));
        $responseDelete->assertStatus(403);
    }

    /**
     * Test Admin can manage Puskesmas accounts (CRUD).
     */
    public function test_admin_can_manage_puskesmas_accounts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // 1. Create / Store
        $responseStore = $this->actingAs($admin)->post(route('puskesmas.store'), [
            'name' => 'Puskesmas Palmerah',
            'email' => 'palmerah@posyandu.com',
            'password' => 'password123',
        ]);
        $responseStore->assertStatus(302); // redirects to index
        $this->assertDatabaseHas('users', [
            'name' => 'Puskesmas Palmerah',
            'email' => 'palmerah@posyandu.com',
            'role' => 'puskesmas',
        ]);

        $puskesmas = User::where('email', 'palmerah@posyandu.com')->first();

        // 2. View Index
        $responseIndex = $this->actingAs($admin)->get(route('puskesmas.index'));
        $responseIndex->assertStatus(200);

        // 3. View Edit
        $responseEdit = $this->actingAs($admin)->get(route('puskesmas.edit', $puskesmas->id));
        $responseEdit->assertStatus(200);

        // 4. Update
        $responseUpdate = $this->actingAs($admin)->patch(route('puskesmas.update', $puskesmas->id), [
            'name' => 'Puskesmas Palmerah Utara',
            'email' => 'palmerah@posyandu.com',
        ]);
        $responseUpdate->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => 'Puskesmas Palmerah Utara',
            'email' => 'palmerah@posyandu.com',
        ]);

        // 5. Delete
        $responseDelete = $this->actingAs($admin)->delete(route('puskesmas.destroy', $puskesmas->id));
        $responseDelete->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'id' => $puskesmas->id,
        ]);
    }
}
