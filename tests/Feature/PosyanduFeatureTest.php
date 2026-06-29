<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Toddler;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\ToddlerMeasurement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosyanduFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that Admin can access user management page.
     */
    public function test_admin_can_access_user_management(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertStatus(200);
    }

    /**
     * Test that non-Admin (e.g. Parent) cannot access user management.
     */
    public function test_non_admin_cannot_access_user_management(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->get(route('users.index'));

        $response->assertStatus(403);
    }

    /**
     * Test parent isolation policy: Parent cannot view details of other families' balita.
     */
    public function test_parent_isolation_policy(): void
    {
        $parent1 = User::factory()->create(['role' => 'parent']);
        $parent2 = User::factory()->create(['role' => 'parent']);

        $toddlerOfParent2 = Toddler::create([
            'user_id' => $parent2->id,
            'name' => 'Anak Parent 2',
            'gender' => 'M',
            'birth_date' => '2025-01-01',
            'birth_weight_kg' => 3.2,
            'birth_height_cm' => 50,
            'birth_head_circumference_cm' => 33,
            'father_name' => 'Bapak 2',
            'mother_name' => 'Ibu 2',
            'address' => 'Alamat 2',
        ]);

        // Parent 1 tries to access Parent 2's toddler show view
        $response = $this->actingAs($parent1)->get(route('toddlers.show', $toddlerOfParent2->id));

        $response->assertStatus(403);

        // Parent 2 tries to access their own toddler show view
        $response = $this->actingAs($parent2)->get(route('toddlers.show', $toddlerOfParent2->id));

        $response->assertStatus(200);
    }

    /**
     * Test that Parents can RSVP to a schedule.
     */
    public function test_parent_can_rsvp_to_schedule(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);
        $schedule = Schedule::create([
            'title' => 'Posyandu Balita Juni',
            'target_type' => 'toddler',
            'scheduled_at' => now()->addDays(2),
            'location' => 'Pos RW 03',
        ]);

        $response = $this->actingAs($parent)->post(route('schedules.rsvp', $schedule->id), [
            'is_present' => 1,
            'notes' => 'Akan hadir tepat waktu',
        ]);

        $response->assertStatus(302); // Redirect back
        $this->assertDatabaseHas('attendances', [
            'schedule_id' => $schedule->id,
            'user_id' => $parent->id,
            'is_present' => true,
            'notes' => 'Akan hadir tepat waktu',
        ]);
    }

    /**
     * Test that Kader can record toddler measurement.
     */
    public function test_kader_can_record_toddler_measurement(): void
    {
        $kader = User::factory()->create(['role' => 'kader']);
        $parent = User::factory()->create(['role' => 'parent']);
        $toddler = Toddler::create([
            'user_id' => $parent->id,
            'name' => 'Budi',
            'gender' => 'M',
            'birth_date' => '2025-01-01',
            'birth_weight_kg' => 3.2,
            'birth_height_cm' => 50,
            'birth_head_circumference_cm' => 33,
            'father_name' => 'Bapak Budi',
            'mother_name' => 'Ibu Budi',
            'address' => 'Alamat Budi',
        ]);
        $schedule = Schedule::create([
            'title' => 'Posyandu Balita Juni',
            'target_type' => 'toddler',
            'scheduled_at' => now()->addDays(2),
            'location' => 'Pos RW 03',
        ]);

        $response = $this->actingAs($kader)->post(route('toddlers.measure.store'), [
            'toddler_id' => $toddler->id,
            'schedule_id' => $schedule->id,
            'weight_kg' => 8.5,
            'height_cm' => 72,
            'head_circumference_cm' => 45,
            'immunization_type' => 'DPT 1',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('toddler_measurements', [
            'toddler_id' => $toddler->id,
            'schedule_id' => $schedule->id,
            'weight_kg' => 8.5,
            'height_cm' => 72,
            'head_circumference_cm' => 45,
            'immunization_type' => 'DPT 1',
        ]);
    }
}
