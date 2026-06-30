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
     * Test that Admin can access user management pages.
     */
    public function test_admin_can_access_user_management(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response1 = $this->actingAs($admin)->get(route('kaders.index'));
        $response2 = $this->actingAs($admin)->get(route('parents.index'));

        $response1->assertStatus(200);
        $response2->assertStatus(200);
    }

    /**
     * Test that non-Admin (e.g. Parent) cannot access user management pages.
     */
    public function test_non_admin_cannot_access_user_management(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response1 = $this->actingAs($parent)->get(route('kaders.index'));
        $response2 = $this->actingAs($parent)->get(route('parents.index'));

        $response1->assertStatus(403);
        $response2->assertStatus(403);
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

    public function test_kader_can_create_toddler_with_address_and_medical_history(): void
    {
        $kader = User::factory()->create(['role' => 'kader']);
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($kader)->post(route('toddlers.store'), [
            'user_id' => $parent->id,
            'name' => 'Fahri Alamsyah',
            'birth_date' => '2025-02-14',
            'gender' => 'M',
            'address' => 'Jl. Kenanga No. 5, RW 01',
            'medical_history' => 'Lahir caesar, tidak ada alergi.',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('toddlers', [
            'name' => 'Fahri Alamsyah',
            'address' => 'Jl. Kenanga No. 5, RW 01',
            'medical_history' => 'Lahir caesar, tidak ada alergi.',
        ]);
    }

    public function test_only_rsvp_present_participants_are_listed_on_schedule_show(): void
    {
        $kader = User::factory()->create(['role' => 'kader']);
        
        $parent1 = User::factory()->create(['role' => 'parent']);
        $parent2 = User::factory()->create(['role' => 'parent']);
        
        $toddler1 = Toddler::create([
            'user_id' => $parent1->id,
            'name' => 'Budi RSVP',
            'gender' => 'M',
            'birth_date' => '2025-01-01',
            'address' => 'Jl. Test 1',
        ]);
        
        $toddler2 = Toddler::create([
            'user_id' => $parent2->id,
            'name' => 'Citra No RSVP',
            'gender' => 'F',
            'birth_date' => '2025-01-01',
            'address' => 'Jl. Test 2',
        ]);
        
        $schedule = Schedule::create([
            'title' => 'Jadwal Balita Juni',
            'target_type' => 'toddler',
            'scheduled_at' => now()->addDays(2),
            'location' => 'Pos RW 03',
        ]);
        
        // Parent 1 RSVPs present
        $schedule->attendances()->create([
            'user_id' => $parent1->id,
            'is_present' => true,
        ]);
        
        // Parent 2 RSVPs absent (not present)
        $schedule->attendances()->create([
            'user_id' => $parent2->id,
            'is_present' => false,
        ]);

        $response = $this->actingAs($kader)->get(route('schedules.show', $schedule->id));
        
        $response->assertStatus(200);
        $response->assertSee('Budi RSVP');
        $response->assertDontSee('Citra No RSVP');
    }
}
