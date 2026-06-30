<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Toddler;
use App\Models\PregnantWoman;
use App\Models\Elderly;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\ToddlerMeasurement;
use App\Models\PregnancyRecord;
use App\Models\ElderlyRecord;
use App\Models\Article;
use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'name' => 'Admin Posyandu',
            'email' => 'admin@posyandu.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $kaderSiti = User::create([
            'name' => 'Kader Siti',
            'email' => 'siti@posyandu.com',
            'password' => Hash::make('password'),
            'role' => 'kader',
        ]);

        $kaderBudi = User::create([
            'name' => 'Kader Budi',
            'email' => 'budi@posyandu.com',
            'password' => Hash::make('password'),
            'role' => 'kader',
        ]);

        $parentAni = User::create([
            'name' => 'Ibu Ani',
            'email' => 'ani@parent.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
        ]);

        $parentEko = User::create([
            'name' => 'Bapak Eko',
            'email' => 'eko@parent.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
        ]);

        $puskesmas = User::create([
            'name' => 'Puskesmas Kebon Jeruk',
            'email' => 'puskesmas@posyandu.com',
            'password' => Hash::make('password'),
            'role' => 'puskesmas',
        ]);

        // 2. Seed Participant Profiles
        // Under Ibu Ani
        $toddlerBudi = Toddler::create([
            'user_id' => $parentAni->id,
            'name' => 'Budi Santoso',
            'birth_date' => '2024-05-15',
            'gender' => 'M',
            'address' => 'Jl. Mawar No. 12, RW 01',
            'medical_history' => 'Lahir prematur 8 bulan, imunisasi dasar lengkap.',
        ]);

        $toddlerCitra = Toddler::create([
            'user_id' => $parentAni->id,
            'name' => 'Citra Lestari',
            'birth_date' => '2025-08-20',
            'gender' => 'F',
            'address' => 'Jl. Mawar No. 12, RW 01',
            'medical_history' => 'Alergi dingin, tumbuh kembang sangat aktif.',
        ]);

        $pregnantWomanAni = PregnantWoman::create([
            'user_id' => $parentAni->id,
            'name' => 'Ibu Ani (Bumil)',
            'pregnancy_age_weeks' => 24,
            'estimated_delivery_date' => '2026-10-10',
            'address' => 'Jl. Mawar No. 12, RW 01',
            'medical_history' => 'Kehamilan kedua, riwayat anemia ringan.',
        ]);

        // Under Bapak Eko
        $toddlerDedi = Toddler::create([
            'user_id' => $parentEko->id,
            'name' => 'Dedi Wijaya',
            'birth_date' => '2023-11-10',
            'gender' => 'M',
            'address' => 'Jl. Melati No. 45, RW 01',
            'medical_history' => 'Tidak ada riwayat penyakit kronis.',
        ]);

        $elderlySastro = Elderly::create([
            'user_id' => $parentEko->id,
            'name' => 'Mbah Sastro',
            'birth_date' => '1960-03-12',
            'address' => 'Jl. Melati No. 45, RW 01',
            'medical_history' => 'Hipertensi dan Asam Urat',
        ]);

        // 3. Seed Schedules
        $scheduleMayToddler = Schedule::create([
            'title' => 'Posyandu Balita Ceria - RW 01',
            'target_type' => 'toddler',
            'scheduled_at' => '2026-05-10 08:00:00',
            'location' => 'Balai RW 01',
            'description' => 'Pengukuran rutin tinggi badan, berat badan, lingkar kepala, pemberian vitamin A, dan konsultasi gizi balita.',
        ]);

        $scheduleMayBumil = Schedule::create([
            'title' => 'Pemeriksaan Ibu Hamil Sehat - RW 01',
            'target_type' => 'pregnant_woman',
            'scheduled_at' => '2026-05-12 09:00:00',
            'location' => 'Poskesdes RW 01',
            'description' => 'Pemeriksaan tensi darah, berat badan, lingkar lengan, detak jantung janin (DJJ), serta pembagian tablet tambah darah.',
        ]);

        $scheduleMayElderly = Schedule::create([
            'title' => 'Posyandu Lansia Bugar - RW 01',
            'target_type' => 'elderly',
            'scheduled_at' => '2026-05-14 08:30:00',
            'location' => 'Balai RW 01',
            'description' => 'Pengecekan tensi darah, penimbangan berat badan, konsultasi asam urat & gula darah, serta senam lansia bersama.',
        ]);

        $scheduleJuneToddler = Schedule::create([
            'title' => 'Posyandu Balita Ceria - RW 01',
            'target_type' => 'toddler',
            'scheduled_at' => '2026-06-10 08:00:00',
            'location' => 'Balai RW 01',
            'description' => 'Pengukuran rutin tinggi badan, berat badan, lingkar kepala, dan imunisasi berkala.',
        ]);

        $scheduleJuneBumil = Schedule::create([
            'title' => 'Pemeriksaan Ibu Hamil Sehat - RW 01',
            'target_type' => 'pregnant_woman',
            'scheduled_at' => '2026-06-12 09:00:00',
            'location' => 'Poskesdes RW 01',
            'description' => 'Pemantauan kehamilan bulanan, konsultasi keluhan kehamilan, dan penyuluhan gizi ibu hamil.',
        ]);

        $scheduleJuneElderly = Schedule::create([
            'title' => 'Posyandu Lansia Bugar - RW 01',
            'target_type' => 'elderly',
            'scheduled_at' => '2026-06-14 08:30:00',
            'location' => 'Balai RW 01',
            'description' => 'Pengecekan tensi darah, asam urat, gula darah, penyuluhan kesehatan lansia, dan senam pagi bersama.',
        ]);

        // 4. Seed Attendances (Pivot RSVPs)
        Attendance::create([
            'schedule_id' => $scheduleMayToddler->id,
            'user_id' => $parentAni->id,
            'is_present' => true,
            'notes' => 'Hadir membawa 2 balita',
        ]);

        Attendance::create([
            'schedule_id' => $scheduleMayBumil->id,
            'user_id' => $parentAni->id,
            'is_present' => true,
            'notes' => 'Pemeriksaan rutin',
        ]);

        Attendance::create([
            'schedule_id' => $scheduleJuneToddler->id,
            'user_id' => $parentAni->id,
            'is_present' => true,
            'notes' => 'Hadir rutin bulanan',
        ]);

        Attendance::create([
            'schedule_id' => $scheduleJuneBumil->id,
            'user_id' => $parentAni->id,
            'is_present' => true,
            'notes' => 'Pemeriksaan kandungan',
        ]);

        Attendance::create([
            'schedule_id' => $scheduleMayToddler->id,
            'user_id' => $parentEko->id,
            'is_present' => true,
            'notes' => 'Hadir membawa Dedi',
        ]);

        Attendance::create([
            'schedule_id' => $scheduleMayElderly->id,
            'user_id' => $parentEko->id,
            'is_present' => true,
            'notes' => 'Mbah Sastro datang diantar',
        ]);

        Attendance::create([
            'schedule_id' => $scheduleJuneToddler->id,
            'user_id' => $parentEko->id,
            'is_present' => true,
            'notes' => 'Hadir bulanan',
        ]);

        Attendance::create([
            'schedule_id' => $scheduleJuneElderly->id,
            'user_id' => $parentEko->id,
            'is_present' => true,
            'notes' => 'Mbah Sastro rutin periksa',
        ]);

        // 5. Seed Medical Measurements / Records
        // Toddler 1: Budi Santoso
        ToddlerMeasurement::create([
            'toddler_id' => $toddlerBudi->id,
            'schedule_id' => $scheduleMayToddler->id,
            'weight_kg' => 10.50,
            'height_cm' => 82.00,
            'head_circumference_cm' => 46.00,
            'immunization_type' => 'DPT-HB-HIB 3',
        ]);

        ToddlerMeasurement::create([
            'toddler_id' => $toddlerBudi->id,
            'schedule_id' => $scheduleJuneToddler->id,
            'weight_kg' => 11.20,
            'height_cm' => 83.50,
            'head_circumference_cm' => 46.50,
            'immunization_type' => 'Polio 4',
        ]);

        // Toddler 2: Citra Lestari
        ToddlerMeasurement::create([
            'toddler_id' => $toddlerCitra->id,
            'schedule_id' => $scheduleMayToddler->id,
            'weight_kg' => 7.50,
            'height_cm' => 68.00,
            'head_circumference_cm' => 43.00,
            'immunization_type' => 'BCG',
        ]);

        ToddlerMeasurement::create([
            'toddler_id' => $toddlerCitra->id,
            'schedule_id' => $scheduleJuneToddler->id,
            'weight_kg' => 8.10,
            'height_cm' => 70.00,
            'head_circumference_cm' => 43.50,
            'immunization_type' => 'DPT-HB-HIB 1',
        ]);

        // Toddler 3: Dedi Wijaya
        ToddlerMeasurement::create([
            'toddler_id' => $toddlerDedi->id,
            'schedule_id' => $scheduleMayToddler->id,
            'weight_kg' => 12.80,
            'height_cm' => 91.00,
            'head_circumference_cm' => 48.00,
            'immunization_type' => 'Campak Rubella',
        ]);

        ToddlerMeasurement::create([
            'toddler_id' => $toddlerDedi->id,
            'schedule_id' => $scheduleJuneToddler->id,
            'weight_kg' => 13.10,
            'height_cm' => 92.20,
            'head_circumference_cm' => 48.20,
            'immunization_type' => 'DPT-HB-HIB Booster',
        ]);

        // Pregnancy Records: Ibu Ani
        PregnancyRecord::create([
            'pregnant_woman_id' => $pregnantWomanAni->id,
            'schedule_id' => $scheduleMayBumil->id,
            'weight_kg' => 58.00,
            'blood_pressure' => '110/70',
            'upper_arm_circumference_cm' => 24.50,
            'gestational_age_weeks' => 20,
            'fetal_heart_rate' => 140,
            'action_notes' => 'Kondisi ibu baik, diberikan tablet tambah darah.',
        ]);

        PregnancyRecord::create([
            'pregnant_woman_id' => $pregnantWomanAni->id,
            'schedule_id' => $scheduleJuneBumil->id,
            'weight_kg' => 60.50,
            'blood_pressure' => '115/75',
            'upper_arm_circumference_cm' => 24.80,
            'gestational_age_weeks' => 24,
            'fetal_heart_rate' => 142,
            'action_notes' => 'Perkembangan janin normal, disarankan konsumsi kalsium.',
        ]);

        // Elderly Records: Mbah Sastro
        ElderlyRecord::create([
            'elderly_id' => $elderlySastro->id,
            'schedule_id' => $scheduleMayElderly->id,
            'weight_kg' => 62.00,
            'blood_pressure' => '140/90',
            'blood_sugar' => 130,
            'cholesterol' => 210,
            'uric_acid' => 6.80,
        ]);

        ElderlyRecord::create([
            'elderly_id' => $elderlySastro->id,
            'schedule_id' => $scheduleJuneElderly->id,
            'weight_kg' => 61.50,
            'blood_pressure' => '135/85',
            'blood_sugar' => 125,
            'cholesterol' => 198,
            'uric_acid' => 6.40,
        ]);

        // 6. Seed Articles
        Article::create([
            'user_id' => $admin->id,
            'title' => 'Pentingnya Imunisasi Dasar Lengkap pada Anak',
            'slug' => 'pentingnya-imunisasi-dasar-lengkap-pada-anak',
            'content' => 'Imunisasi dasar lengkap sangat penting untuk melindungi anak dari penyakit berbahaya seperti polio, campak, difteri, pertusis, tetanus, dan hepatitis B. Berdasarkan jadwal IDAI dan Kementerian Kesehatan, anak wajib menerima vaksin BCG, Polio, DPT-HB-HIB, dan Campak Rubella sebelum menginjak usia 1 tahun. Melalui imunisasi, tubuh anak diajarkan memproduksi antibodi pelindung secara alami tanpa perlu menderita sakitnya terlebih dahulu. Pastikan anak Anda rutin datang ke posyandu setiap bulan untuk memperoleh imunisasi gratis sesuai jadwal usia mereka.',
            'thumbnail_path' => null,
        ]);

        Article::create([
            'user_id' => $admin->id,
            'title' => 'Tips Memenuhi Kebutuhan Gizi Ibu Hamil',
            'slug' => 'tips-memenuhi-kebutuhan-gizi-ibu-hamil',
            'content' => 'Selama masa kehamilan, asupan makanan dengan gizi seimbang mutlak diperlukan oleh ibu hamil untuk mendukung tumbuh kembang janin secara optimal dan menjaga kesehatan sang ibu sendiri. Ibu hamil membutuhkan makronutrien seperti protein (dari daging, ikan, telur, tempe) dan mikronutrien penting seperti asam folat (untuk mencegah cacat tabung saraf janin), zat besi (mencegah anemia), kalsium (pembentukan tulang), serta vitamin D. Batasi konsumsi kafein berlebihan dan hindari makanan mentah demi kesehatan bersama.',
            'thumbnail_path' => null,
        ]);

        // 7. Seed Galleries
        Gallery::create([
            'title' => 'Kegiatan Penimbangan Balita Mei 2026',
            'image_path' => 'img/gallery-balita-mei.jpg',
            'description' => 'Kader posyandu sedang melakukan penimbangan berat badan balita menggunakan dacin standar untuk pencatatan KMS.',
        ]);

        Gallery::create([
            'title' => 'Senam Pagi Lansia RW 01',
            'image_path' => 'img/gallery-senam-lansia.jpg',
            'description' => 'Para lansia antusias mengikuti gerakan instruktur senam kesehatan lansia untuk menjaga stamina tubuh tetap bugar.',
        ]);
    }
}
