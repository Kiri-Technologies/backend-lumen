<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\History;
use App\Models\User;
use App\Models\Trip;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ========================================================
        // ==================== Seeder Route ======================
        // ========================================================

        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('routes')->insert([
                'kode_trayek' => $faker->areaCode,
                'titik_awal' => $faker->name,
                'titik_akhir' => $faker->name,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        }

        foreach (range(1, 10) as $index) {
            DB::table('setpoints')->insert([
                'route_id' => $faker->numberBetween($min = 1, $max = 10),
                'nama_lokasi' => $faker->secondaryAddress . ' ' . $faker->city,
                'lat' => $faker->latitude($min = -6.8, $max = 6.95),
                'long' => $faker->longitude($min = 107.5, $max = 107.65),
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        }

        // Riwayat Seeder
        // foreach (range(1, 10) as $index) {
        //     DB::table('routes')->insert([
        //         'kode_trayek' => $faker->areaCode,
        //         'titik_awal' => $faker->name,
        //         'titik_akhir' => $faker->name,
        //     ]);
        // }
        // ========================================================
        // ===================== Seeder User ======================
        // ========================================================

        $user = [
            [
                'id' => 'user-123456',
                'name' => 'user',
                'email' => 'user@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
            ],
            [
                'id' => 'supir-123456',
                'name' => 'supir',
                'email' => 'supir@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
            ],
            [
                'id' => 'owner-123456',
                'name' => 'owner',
                'email' => 'owner@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
            ],
            [
                'id' => 'admin-123456',
                'name' => 'admin',
                'email' => 'admin@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'admin',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }

        // ========================================================
        // ==================== Seeder Angkot =====================
        // ========================================================
        $vehicle = [
            [
                'id' => 1,
                'user_id' => 'owner-123456',
                'route_id' => 1,
                'plat_nomor' => 'B 12345',
                'qr_code' => QrCode::format('svg')->generate(urlencode('angkot_id: 1')),
                'pajak_tahunan' => '2017-06-15',
                'pajak_stnk' => '2017-06-15',
                'kir_bulanan' => '2017-06-15',
                'is_beroperasi' => null,
                'supir_id' => null,
                'status' => 'aktif',
            ],

        ];

        foreach ($vehicle as $key => $value) {
            Vehicle::create($value);
        }

        // ========================================================
        // ==================== Seeder History =======================
        // ========================================================

        foreach (range(1, 10) as $index) {
            DB::table('histories')->insert([
                'user_id' => 'supir-123456',
                'angkot_id' => '1',
                'jumlah_pendapatan' => $faker->numberBetween($min = 1000, $max = 90000),
                'mulai_narik' => $faker->dateTime,
                'selesai_narik' => $faker->dateTime,
                'status' => 'done',
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        }

        // ========================================================
        // ==================== Seeder Trip =======================
        // ========================================================

        foreach (range(1, 10) as $index) {
            DB::table('trips')->insert([
                'penumpang_id' => 'user-123456',
                'angkot_id' => '1',
                'supir_id' => 'supir-123456',
                'history_id' => $faker->numberBetween($min = 1, $max = 10),
                'tempat_naik_id' => $faker->numberBetween($min = 1, $max = 10),
                'tempat_turun_id' => $faker->numberBetween($min = 1, $max = 10),
                'nama_tempat_naik' => $faker->secondaryAddress . ' ' . $faker->city,
                'nama_tempat_turun' => $faker->secondaryAddress . ' ' . $faker->city,
                'jarak' => '1',
                'rekomendasi_harga' => $faker->numberBetween($min = 10000, $max = 100000),
                'is_done' => 0,
                'is_connected_with_driver' => 0,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        }
    }
}
