<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\History;
use App\Models\User;
use App\Models\Trip;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        DB::table('routes')->insert([
            'kode_trayek' => 'S-101',
            'titik_awal' => 'Buah Batu',
            'titik_akhir' => 'Bojongsoang',
            'lat_titik_awal' => '-6.951456042611119',
            'long_titik_awal' => '107.63700535971714',
            'lat_titik_akhir' => '-6.98173662404552',
            'long_titik_akhir' => '107.63401668451586',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '1',
            'nama_lokasi' => 'Pasar Kordon',
            'arah' => 'Bojongsoang',
            'lat' => '-6.9540719715419685',
            'long' => '107.63900446755639',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '1',
            'nama_lokasi' => 'Transmart Buah Batu',
            'arah' => 'Bojongsoang',
            'lat' => '-6.96670545019899',
            'long' => '107.6377486264246',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '1',
            'nama_lokasi' => 'Depan PBB',
            'arah' => 'Bojongsoang',
            'lat' => '-6.972641789494429',
            'long' => '107.63626339256105',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '1',
            'nama_lokasi' => 'Gerbang Telkom',
            'arah' => 'Buah Batu',
            'lat' => '-6.972843840405349',
            'long' => '107.63615082182956',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '1',
            'nama_lokasi' => 'Yogya',
            'arah' => 'Buah Batu',
            'lat' => '-6.9681786969320045',
            'long' => '107.63731582584998',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '1',
            'nama_lokasi' => 'Sebrang Pasar Kordon',
            'arah' => 'Buah Batu',
            'lat' => '-6.95439945219693',
            'long' => '107.63894266494613',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('routes')->insert([
            'kode_trayek' => 'S-102',
            'titik_awal' => 'Cibiru',
            'titik_akhir' => 'Kiaracondong',
            'lat_titik_awal' => '-6.935326352497624',
            'long_titik_awal' => '107.71723319140494',
            'lat_titik_akhir' => '-6.945786406086979',
            'long_titik_akhir' => '107.64110449717717',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '2',
            'nama_lokasi' => 'Dinas Kehutanan Provinsi Jawa Barat',
            'arah' => 'Cibiru',
            'lat' => '-6.938332980849803',
            'long' => '107.6718896066064',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '2',
            'nama_lokasi' => 'Pasar Gedebage',
            'arah' => 'Cibiru',
            'lat' => '-6.936497537272609',
            'long' => '107.69722202914215',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '2',
            'nama_lokasi' => 'Tanaman Hias Cibiru',
            'arah' => 'Cibiru',
            'lat' => '-6.9356281869066985',
            'long' => '107.70964009265232',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '2',
            'nama_lokasi' => 'Universitas Bhakti Kencana Bandung',
            'arah' => 'Kiaracondong',
            'lat' => '-6.935947591151588',
            'long' => '107.71002182771478',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '2',
            'nama_lokasi' => 'Sebrang Pasar Gedebage',
            'arah' => 'Kiaracondong',
            'lat' => '-6.936822991357309',
            'long' => '107.69716280914523',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('setpoints')->insert([
            'route_id' => '2',
            'nama_lokasi' => 'Metro Indah Mall',
            'arah' => 'Kiaracondong',
            'lat' => '-6.940383025095341',
            'long' => '107.65817458072696',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        // foreach (range(1, 10) as $index) {
        //     DB::table('routes')->insert([
        //         'kode_trayek' => $faker->areaCode,
        //         'titik_awal' => $faker->name,
        //         'titik_akhir' => $faker->name,
        //         'lat_titik_awal' => $faker->latitude($min = -6.8, $max = 6.95),
        //         'long_titik_awal' => $faker->latitude($min = -6.8, $max = 6.95),
        //         'lat_titik_akhir' => $faker->latitude($min = -6.8, $max = 6.95),
        //         'long_titik_akhir' => $faker->latitude($min = -6.8, $max = 6.95),
        //         'created_at' => $faker->dateTime,
        //         'updated_at' => $faker->dateTime,
        //     ]);
        // }

        // foreach (range(1, 10) as $index) {
        //     DB::table('setpoints')->insert([
        //         'route_id' => $faker->numberBetween($min = 1, $max = 10),
        //         'nama_lokasi' => $faker->secondaryAddress . ' ' . $faker->city,
        //         'arah' => $faker->name,
        //         'lat' => $faker->latitude($min = -6.8, $max = 6.95),
        //         'long' => $faker->longitude($min = 107.5, $max = 107.65),
        //         'created_at' => $faker->dateTime,
        //         'updated_at' => $faker->dateTime,
        //     ]);
        // }

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

        // bulan ini
        $user = [
            // === penumpang ===
            // bulan ini
            [
                'id' => 'user-123456',
                'name' => 'user',
                'email' => 'user@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // 1 bulan kemarin
            [
                'id' => 'komeng-123456',
                'name' => 'komeng',
                'email' => 'komeng@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'wahyu-123456',
                'name' => 'wahyu',
                'email' => 'wahyu@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'taulany-123456',
                'name' => 'taulany',
                'email' => 'taulany@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'dodit-123456',
                'name' => 'dodit',
                'email' => 'dodit@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            // 2 bulan kemarin
            [
                'id' => 'nia-123456',
                'name' => 'nia',
                'email' => 'nia@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(2),
                'updated_at' => Carbon::now()->subMonth(2),
            ],
            [
                'id' => 'rahma-123456',
                'name' => 'rahma',
                'email' => 'rahma@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(2),
                'updated_at' => Carbon::now()->subMonth(2),
            ],
            // 3 bulan kemarin
            [
                'id' => 'radit-123456',
                'name' => 'radit',
                'email' => 'radit@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(3),
                'updated_at' => Carbon::now()->subMonth(3),
            ],
            // 4 bulan kemarin
            [
                'id' => 'simon-123456',
                'name' => 'simon',
                'email' => 'simon@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(4),
                'updated_at' => Carbon::now()->subMonth(4),
            ],
            [
                'id' => 'josh-123456',
                'name' => 'josh',
                'email' => 'josh@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(4),
                'updated_at' => Carbon::now()->subMonth(4),
            ],
            // 5 bulan kemarin
            [
                'id' => 'farel-123456',
                'name' => 'farel',
                'email' => 'farel@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(5),
                'updated_at' => Carbon::now()->subMonth(5),
            ],
            [
                'id' => 'ilham-123456',
                'name' => 'ilham',
                'email' => 'ilham@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(5),
                'updated_at' => Carbon::now()->subMonth(5),
            ],
            [
                'id' => 'ridwan-123456',
                'name' => 'ridwan',
                'email' => 'ridwan@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(5),
                'updated_at' => Carbon::now()->subMonth(5),
            ],
            // === supir ===
            // bulan ini
            [
                'id' => 'supir-123456',
                'name' => 'supir',
                'email' => 'supir@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'dayat-123456',
                'name' => 'dayat',
                'email' => 'dayat@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'kusnandar-123456',
                'name' => 'kusnandar',
                'email' => 'kusnandar@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'dwi-123456',
                'name' => 'dwi',
                'email' => 'dwi@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'rizad-123456',
                'name' => 'rizad',
                'email' => 'rizad@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'ramli-123456',
                'name' => 'ramli',
                'email' => 'ramli@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'luhut-123456',
                'name' => 'luhut',
                'email' => 'luhut@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // 1 bulan kemarin
            [
                'id' => 'lanang-123456',
                'name' => 'lanang',
                'email' => 'lanang@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'roy-123456',
                'name' => 'roy',
                'email' => 'roy@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'william-123456',
                'name' => 'william',
                'email' => 'william@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'agung-123456',
                'name' => 'agung',
                'email' => 'agung@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'hercules-123456',
                'name' => 'hercules',
                'email' => 'hercules@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'martial-123456',
                'name' => 'martial',
                'email' => 'martial@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            // 2 bulan kemarin
            [
                'id' => 'tigor-123456',
                'name' => 'tigor',
                'email' => 'tigor@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(2),
                'updated_at' => Carbon::now()->subMonth(2),
            ],
            [
                'id' => 'rizky-123456',
                'name' => 'rizky',
                'email' => 'rizky@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(2),
                'updated_at' => Carbon::now()->subMonth(2),
            ],
            [
                'id' => 'azzam-123456',
                'name' => 'azzam',
                'email' => 'azzam@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(2),
                'updated_at' => Carbon::now()->subMonth(2),
            ],
            // 3 bulan kemarin
            [
                'id' => 'rohmat-123456',
                'name' => 'rohmat',
                'email' => 'rohmat@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(3),
                'updated_at' => Carbon::now()->subMonth(3),
            ],
            // 4 bulan kemarin
            [
                'id' => 'amil-123456',
                'name' => 'amil',
                'email' => 'amil@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(4),
                'updated_at' => Carbon::now()->subMonth(4),
            ],
            [
                'id' => 'surya-123456',
                'name' => 'surya',
                'email' => 'surya@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(4),
                'updated_at' => Carbon::now()->subMonth(4),
            ],
            // 5 bulan kemarin
            [
                'id' => 'nendy-123456',
                'name' => 'nendy',
                'email' => 'nendy@gmail.com',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'phone_number' => '081234567890',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(5),
                'updated_at' => Carbon::now()->subMonth(5),
            ],
            // === owner ===
            // bulan ini
            [
                'id' => 'owner-123456',
                'name' => 'owner',
                'email' => 'owner@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'ummah-123456',
                'name' => 'ummah',
                'email' => 'ummah@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // 1 bulan kemarin
            [
                'id' => 'ryan-123456',
                'name' => 'ryan',
                'email' => 'ryan@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'windah-123456',
                'name' => 'windah',
                'email' => 'windah@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'id' => 'basudara-123456',
                'name' => 'basudara',
                'email' => 'basudara@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            // 2 bulan kemarin
            // 3 bulan kemarin
            // 4 bulan kemarin
            [
                'id' => 'pangestu-123456',
                'name' => 'pangestu',
                'email' => 'pangestu@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(4),
                'updated_at' => Carbon::now()->subMonth(4),
            ],
            // 5 bulan kemarin
            [
                'id' => 'abdul-123456',
                'name' => 'abdul',
                'email' => 'abdul@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subMonth(5),
                'updated_at' => Carbon::now()->subMonth(5),
            ],
            // === admin ===
            [
                'id' => 'admin-123456',
                'name' => 'admin',
                'email' => 'admin@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'admin',
                'phone_number' => '081234567891',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
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
                'user_id' => 'owner-123456',
                'route_id' => 1,
                'plat_nomor' => 'B 8123 AB',
                'qr_code' => 'http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($_ENV['APP_URL'] . '/vehicle/1'),
                'pajak_tahunan' => '2017-06-15',
                'pajak_stnk' => '2017-06-15',
                'kir_bulanan' => '2017-06-15',
                'is_beroperasi' => true,
                'supir_id' => 'supir-123456',
                'status' => 'approved',
            ],
            [
                'user_id' => 'owner-123456',
                'route_id' => 2,
                'plat_nomor' => 'B 0239 DE',
                'qr_code' => 'http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($_ENV['APP_URL'] . '/vehicle/2'),
                'pajak_tahunan' => '2017-06-15',
                'pajak_stnk' => '2017-06-15',
                'kir_bulanan' => '2017-06-15',
                'is_beroperasi' => null,
                'supir_id' => null,
                'status' => 'approved',
            ],
            [
                'user_id' => 'owner-123456',
                'route_id' => 1,
                'plat_nomor' => 'B 5131 RR',
                'qr_code' => 'http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($_ENV['APP_URL'] . '/vehicle/3'),
                'pajak_tahunan' => '2017-06-15',
                'pajak_stnk' => '2017-06-15',
                'kir_bulanan' => '2017-06-15',
                'is_beroperasi' => null,
                'supir_id' => null,
                'status' => 'approved',
            ],
            [
                'user_id' => 'owner-123456',
                'route_id' => 1,
                'plat_nomor' => 'B 9151 PK',
                'qr_code' => 'http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($_ENV['APP_URL'] . '/vehicle/3'),
                'pajak_tahunan' => '2017-06-15',
                'pajak_stnk' => '2017-06-15',
                'kir_bulanan' => '2017-06-15',
                'is_beroperasi' => null,
                'supir_id' => null,
                'status' => 'pending',
            ],
            [
                'user_id' => 'owner-123456',
                'route_id' => 1,
                'plat_nomor' => 'B 0123 ER',
                'qr_code' => 'http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($_ENV['APP_URL'] . '/vehicle/3'),
                'pajak_tahunan' => '2017-06-15',
                'pajak_stnk' => '2017-06-15',
                'kir_bulanan' => '2017-06-15',
                'is_beroperasi' => null,
                'supir_id' => null,
                'status' => 'declined',
            ],

        ];

        foreach ($vehicle as $key => $value) {
            Vehicle::create($value);
        }

        // ========================================================
        // ==================== List Supir ========================
        // ========================================================

        DB::table('list_drivers')->insert([
            'supir_id' => 'supir-123456',
            'angkot_id' => 1,
            'is_confirmed' => 1,
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('list_drivers')->insert([
            'supir_id' => 'dayat-123456',
            'angkot_id' => 1,
            'is_confirmed' => 1,
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('list_drivers')->insert([
            'supir_id' => 'supir-123456',
            'angkot_id' => 2,
            'is_confirmed' => 1,
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('list_drivers')->insert([
            'supir_id' => 'lanang-123456',
            'angkot_id' => 2,
            'is_confirmed' => 1,
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);


        // ========================================================
        // ==================== Seeder History =======================
        // ========================================================

        // Last month
        DB::table('histories')->insert([
            'user_id' => 'supir-123456',
            'angkot_id' => 1,
            'jumlah_pendapatan' => 121000,
            'mulai_narik' => Carbon::now()->subMonth(),
            'selesai_narik' => Carbon::now()->subMonth(),
            'status' => 'done',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('histories')->insert([
            'user_id' => 'dayat-123456',
            'angkot_id' => 1,
            'jumlah_pendapatan' => 80000,
            'mulai_narik' => Carbon::now()->subMonth(),
            'selesai_narik' => Carbon::now()->subMonth(),
            'status' => 'done',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('histories')->insert([
            'user_id' => 'supir-123456',
            'angkot_id' => 2,
            'jumlah_pendapatan' => 82000,
            'mulai_narik' => Carbon::now()->subMonth(),
            'selesai_narik' => Carbon::now()->subMonth(),
            'status' => 'done',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('histories')->insert([
            'user_id' => 'lanang-123456',
            'angkot_id' => 2,
            'jumlah_pendapatan' => 90000,
            'mulai_narik' => Carbon::now()->subMonth(),
            'selesai_narik' => Carbon::now()->subMonth(),
            'status' => 'done',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        // This month
        DB::table('histories')->insert([
            'user_id' => 'supir-123456',
            'angkot_id' => 1,
            'jumlah_pendapatan' => 105000,
            'mulai_narik' => Carbon::now(),
            'selesai_narik' => Carbon::now(),
            'status' => 'done',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('histories')->insert([
            'user_id' => 'dayat-123456',
            'angkot_id' => 1,
            'jumlah_pendapatan' => 111000,
            'mulai_narik' => Carbon::now(),
            'selesai_narik' => Carbon::now(),
            'status' => 'done',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('histories')->insert([
            'user_id' => 'supir-123456',
            'angkot_id' => 2,
            'jumlah_pendapatan' => 99000,
            'mulai_narik' => Carbon::now(),
            'selesai_narik' => Carbon::now(),
            'status' => 'done',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('histories')->insert([
            'user_id' => 'lanang-123456',
            'angkot_id' => 2,
            'jumlah_pendapatan' => 105000,
            'mulai_narik' => Carbon::now(),
            'selesai_narik' => Carbon::now(),
            'status' => 'done',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // foreach (range(1, 10) as $index) {
        //     DB::table('histories')->insert([
        //         'user_id' => 'supir-123456',
        //         'angkot_id' => $faker->numberBetween($min = 1, $max = 3),
        //         'jumlah_pendapatan' => 10000,
        //         'mulai_narik' => $faker->dateTime,
        //         'selesai_narik' => $faker->dateTime,
        //         'status' => 'done',
        //         'created_at' => $faker->dateTime,
        //         'updated_at' => $faker->dateTime,
        //     ]);
        // }

        // ========================================================
        // ==================== Seeder Trip =======================
        // ========================================================

        // last month
        DB::table('trips')->insert([
            'penumpang_id' => 'user-123456',
            'angkot_id' => 1,
            'supir_id' => 'supir-123456',
            'history_id' => 1,
            'tempat_naik_id' => 1,
            'tempat_turun_id' => 3,
            'nama_tempat_naik' => 'Pasar Kordon',
            'nama_tempat_turun' => 'Depan PBB',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('trips')->insert([
            'penumpang_id' => 'komeng-123456',
            'angkot_id' => 1,
            'supir_id' => 'lanang-123456',
            'history_id' => 1,
            'tempat_naik_id' => 1,
            'tempat_turun_id' => 3,
            'nama_tempat_naik' => 'Pasar Kordon',
            'nama_tempat_turun' => 'Depan PBB',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('trips')->insert([
            'penumpang_id' => 'wahyu-123456',
            'angkot_id' => 1,
            'supir_id' => 'dayat-123456',
            'history_id' => 1,
            'tempat_naik_id' => 1,
            'tempat_turun_id' => 3,
            'nama_tempat_naik' => 'Pasar Kordon',
            'nama_tempat_turun' => 'Depan PBB',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('trips')->insert([
            'penumpang_id' => 'user-123456',
            'angkot_id' => 2,
            'supir_id' => 'supir-123456',
            'history_id' => 2,
            'tempat_naik_id' => 10,
            'tempat_turun_id' => 12,
            'nama_tempat_naik' => 'Universitas Bhakti Kencana Bandung',
            'nama_tempat_turun' => 'Metro Indah Mall',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('trips')->insert([
            'penumpang_id' => 'user-123456',
            'angkot_id' => 1,
            'supir_id' => 'supir-123456',
            'history_id' => 1,
            'tempat_naik_id' => 1,
            'tempat_turun_id' => 3,
            'nama_tempat_naik' => 'Pasar Kordon',
            'nama_tempat_turun' => 'Depan PBB',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        // This month
        DB::table('trips')->insert([
            'penumpang_id' => 'user-123456',
            'angkot_id' => 1,
            'supir_id' => 'supir-123456',
            'history_id' => 1,
            'tempat_naik_id' => 1,
            'tempat_turun_id' => 3,
            'nama_tempat_naik' => 'Pasar Kordon',
            'nama_tempat_turun' => 'Depan PBB',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('trips')->insert([
            'penumpang_id' => 'komeng-123456',
            'angkot_id' => 1,
            'supir_id' => 'lanang-123456',
            'history_id' => 1,
            'tempat_naik_id' => 1,
            'tempat_turun_id' => 3,
            'nama_tempat_naik' => 'Pasar Kordon',
            'nama_tempat_turun' => 'Depan PBB',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('trips')->insert([
            'penumpang_id' => 'wahyu-123456',
            'angkot_id' => 1,
            'supir_id' => 'dayat-123456',
            'history_id' => 1,
            'tempat_naik_id' => 1,
            'tempat_turun_id' => 3,
            'nama_tempat_naik' => 'Pasar Kordon',
            'nama_tempat_turun' => 'Depan PBB',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('trips')->insert([
            'penumpang_id' => 'user-123456',
            'angkot_id' => 2,
            'supir_id' => 'supir-123456',
            'history_id' => 2,
            'tempat_naik_id' => 10,
            'tempat_turun_id' => 12,
            'nama_tempat_naik' => 'Universitas Bhakti Kencana Bandung',
            'nama_tempat_turun' => 'Metro Indah Mall',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('trips')->insert([
            'penumpang_id' => 'user-123456',
            'angkot_id' => 1,
            'supir_id' => 'supir-123456',
            'history_id' => 1,
            'tempat_naik_id' => 1,
            'tempat_turun_id' => 3,
            'nama_tempat_naik' => 'Pasar Kordon',
            'nama_tempat_turun' => 'Depan PBB',
            'jarak' => '20',
            'rekomendasi_harga' => $faker->numberBetween($min = 3000, $max = 7000),
            'is_done' => 1,
            'is_connected_with_driver' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // foreach (range(1, 10) as $index) {
        //     DB::table('trips')->insert([
        //         'penumpang_id' => 'user-123456',
        //         'angkot_id' => '1',
        //         'supir_id' => 'supir-123456',
        //         'history_id' => $faker->numberBetween($min = 1, $max = 10),
        //         'tempat_naik_id' => $faker->numberBetween($min = 1, $max = 10),
        //         'tempat_turun_id' => $faker->numberBetween($min = 1, $max = 10),
        //         'nama_tempat_naik' => $faker->secondaryAddress . ' ' . $faker->city,
        //         'nama_tempat_turun' => $faker->secondaryAddress . ' ' . $faker->city,
        //         'jarak' => '1',
        //         'rekomendasi_harga' => $faker->numberBetween($min = 10000, $max = 100000),
        //         'is_done' => 0,
        //         'is_connected_with_driver' => 0,
        //         'created_at' => $faker->dateTime,
        //         'updated_at' => $faker->dateTime,
        //     ]);
        // }

        // ==========================================================
        // ==================== Feedback Trip =======================
        // ==========================================================

        // Last month
        DB::table('feedbacks')->insert([
            'perjalanan_id' => 1,
            'rating' => 4,
            'review' => 'sangat nyaman',
            'komentar' => 'angkotnya nyaman sekali',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('feedbacks')->insert([
            'perjalanan_id' => 2,
            'rating' => 5,
            'review' => 'sangat nyaman',
            'komentar' => 'sudah bagus sih dan bersih',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('feedbacks')->insert([
            'perjalanan_id' => 3,
            'rating' => 3,
            'review' => 'kurang nyaman',
            'komentar' => 'angkotnya bau rokok',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('feedbacks')->insert([
            'perjalanan_id' => 4,
            'rating' => 5,
            'review' => 'nyaman',
            'komentar' => 'angkotnya lumayan ngebut',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        DB::table('feedbacks')->insert([
            'perjalanan_id' => 5,
            'rating' => 1,
            'review' => 'tidak nyaman',
            'komentar' => 'ngetemnya lama banget saya jadi telat ngantor',
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);

        // This month
        DB::table('feedbacks')->insert([
            'perjalanan_id' => 6,
            'rating' => 2,
            'review' => 'kurang nyaman',
            'komentar' => 'angkotnya tidak bersih',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedbacks')->insert([
            'perjalanan_id' => 7,
            'rating' => 4,
            'review' => 'nyaman',
            'komentar' => 'sudah bagus',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedbacks')->insert([
            'perjalanan_id' => 8,
            'rating' => 5,
            'review' => 'sangat nyaman',
            'komentar' => 'supirnya ramah sekali',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedbacks')->insert([
            'perjalanan_id' => 9,
            'rating' => 4,
            'review' => 'sangat nyaman',
            'komentar' => 'walaupun sudah malam tetapi perjalanannya lancar',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedbacks')->insert([
            'perjalanan_id' => 10,
            'rating' => 4,
            'review' => 'sangat nyaman',
            'komentar' => 'bagus',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        // ==========================================================
        // ======================= Target ===========================
        // ==========================================================

        DB::table('targets')->insert([
            'name' => 'pengeluaran',
            'input' => 233500,
            'target' => 500000,
        ]);

        DB::table('targets')->insert([
            'name' => 'pengguna berlangganan',
            'input' => 0,
            'target' => 20,
        ]);

        DB::table('targets')->insert([
            'name' => 'user',
            'input' => 0,
            'target' => 5,
        ]);

        DB::table('targets')->insert([
            'name' => 'feedback user',
            'input' => 0,
            'target' => 5,
        ]);


        // ================================================================
        // ======================= Feedback app ===========================
        // ================================================================
        // excellent,happy,sad,awful,neutral

        // Submitted
        DB::table('feedback_app')->insert([
            'user_id' => 'user-123456',
            'review' => 'happy',
            'tanggapan' => 'selama ini saya nyaman menggunakan aplikasi, sangat membantu sekali',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'komeng-123456',
            'review' => 'excellent',
            'tanggapan' => 'aplikasinya sangat membantu saya dalam menggunakan transportasi umum',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'supir-123456',
            'review' => 'neutral',
            'tanggapan' => 'sedikit masukan dari saya, kalau bisa aplikasinya ditingkatkan',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'sad',
            'tanggapan' => 'aplikasinya lemot banget',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'awful',
            'tanggapan' => 'aplikasinya sering tertutup tiba-tiba',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'user-123456',
            'review' => 'happy',
            'tanggapan' => 'selama ini saya nyaman menggunakan aplikasi, sangat membantu sekali',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'komeng-123456',
            'review' => 'excellent',
            'tanggapan' => 'aplikasinya sangat membantu saya dalam menggunakan transportasi umum',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'user-123456',
            'review' => 'happy',
            'tanggapan' => 'saya sangat nyaman ketika naik angkot',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'komeng-123456',
            'review' => 'excellent',
            'tanggapan' => 'menurut saya udh bagus banget dan sangat membantu',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'supir-123456',
            'review' => 'neutral',
            'tanggapan' => 'overall sudah bagus, tetapi masih banyak bug',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'sad',
            'tanggapan' => 'sangat lemot',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'awful',
            'tanggapan' => 'gabisa dibuka aplikasinya',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'user-123456',
            'review' => 'happy',
            'tanggapan' => 'membantu saya ketika berangkat kerja',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'komeng-123456',
            'review' => 'excellent',
            'tanggapan' => 'sangat inovatif dan membantu',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'user-123456',
            'review' => 'happy',
            'tanggapan' => 'bikin saya aman ketika naik angkot di malam hari',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'komeng-123456',
            'review' => 'excellent',
            'tanggapan' => 'saya jadi mau naik angkot lagi',
            'status' => 'submitted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // pending
        DB::table('feedback_app')->insert([
            'user_id' => 'supir-123456',
            'review' => 'neutral',
            'tanggapan' => 'sedikit masukan dari saya, kalau bisa aplikasinya ditingkatkan',
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'sad',
            'tanggapan' => 'aplikasinya lemot banget',
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'awful',
            'tanggapan' => 'aplikasinya sering tertutup tiba-tiba',
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'supir-123456',
            'review' => 'neutral',
            'tanggapan' => 'tambahin payment online dong',
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'sad',
            'tanggapan' => 'bikin hp saya lemot',
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'awful',
            'tanggapan' => 'saya gabisa nyalain maps',
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'awful',
            'tanggapan' => 'rekomendasi biayanya terlalu mahal',
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // processed
        DB::table('feedback_app')->insert([
            'user_id' => 'user-123456',
            'review' => 'happy',
            'tanggapan' => 'selama ini saya nyaman menggunakan aplikasi, sangat membantu sekali',
            'status' => 'processed',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'komeng-123456',
            'review' => 'excellent',
            'tanggapan' => 'aplikasinya sangat membantu saya dalam menggunakan transportasi umum',
            'status' => 'processed',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'supir-123456',
            'review' => 'neutral',
            'tanggapan' => 'sedikit masukan dari saya, kalau bisa aplikasinya ditingkatkan',
            'status' => 'processed',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'wahyu-123456',
            'review' => 'sad',
            'tanggapan' => 'aplikasinya lemot banget',
            'status' => 'processed',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // cancelled
        DB::table('feedback_app')->insert([
            'user_id' => 'user-123456',
            'review' => 'happy',
            'tanggapan' => 'selama ini saya nyaman menggunakan aplikasi, sangat membantu sekali',
            'status' => 'cancelled',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'komeng-123456',
            'review' => 'excellent',
            'tanggapan' => 'aplikasinya sangat membantu saya dalam menggunakan transportasi umum',
            'status' => 'cancelled',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('feedback_app')->insert([
            'user_id' => 'supir-123456',
            'review' => 'neutral',
            'tanggapan' => 'sedikit masukan dari saya, kalau bisa aplikasinya ditingkatkan',
            'status' => 'cancelled',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        // ================================================================
        // ======================= Premium User ===========================
        // ================================================================

        // bulan ini
        DB::table('premium_users')->insert([
            'user_id' => 'supir-123456',
            'payment_date' => '2022-07-01',
            'from' => '2022-07-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'dayat-123456',
            'payment_date' => '2022-07-01',
            'from' => '2022-07-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'kusnandar-123456',
            'payment_date' => '2022-06-01',
            'from' => '2022-06-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'dwi-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'rizad-123456',
            'payment_date' => '2022-07-01',
            'from' => '2022-07-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'ramli-123456',
            'payment_date' => '2022-07-01',
            'from' => '2022-07-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'luhut-123456',
            'payment_date' => '2022-06-01',
            'from' => '2022-06-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'lanang-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'roy-123456',
            'payment_date' => '2022-07-01',
            'from' => '2022-07-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'william-123456',
            'payment_date' => '2022-07-01',
            'from' => '2022-07-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'agung-123456',
            'payment_date' => '2022-06-01',
            'from' => '2022-06-01',
            'to' => '2022-09-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 1 bulan kemarin
        DB::table('premium_users')->insert([
            'user_id' => 'hercules-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-06-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'agung-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-06-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'tigor-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-06-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'rizky-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-06-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'azzam-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-06-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'lanang-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-06-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'roy-123456',
            'payment_date' => '2022-05-01',
            'from' => '2022-05-01',
            'to' => '2022-06-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 2 bulan kemarin
        DB::table('premium_users')->insert([
            'user_id' => 'tigor-123456',
            'payment_date' => '2022-04-01',
            'from' => '2022-04-01',
            'to' => '2022-05-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'rizky-123456',
            'payment_date' => '2022-04-01',
            'from' => '2022-04-01',
            'to' => '2022-05-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'azzam-123456',
            'payment_date' => '2022-04-01',
            'from' => '2022-04-01',
            'to' => '2022-05-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'rohmat-123456',
            'payment_date' => '2022-04-01',
            'from' => '2022-04-01',
            'to' => '2022-05-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 3 bulan kemarin
        DB::table('premium_users')->insert([
            'user_id' => 'rohmat-123456',
            'payment_date' => '2022-03-01',
            'from' => '2022-03-01',
            'to' => '2022-04-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'amil-123456',
            'payment_date' => '2022-03-01',
            'from' => '2022-03-01',
            'to' => '2022-04-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'surya-123456',
            'payment_date' => '2022-03-01',
            'from' => '2022-03-01',
            'to' => '2022-04-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 4 bulan kemarin
        DB::table('premium_users')->insert([
            'user_id' => 'amil-123456',
            'payment_date' => '2022-02-01',
            'from' => '2022-02-01',
            'to' => '2022-03-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'surya-123456',
            'payment_date' => '2022-02-01',
            'from' => '2022-02-01',
            'to' => '2022-03-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('premium_users')->insert([
            'user_id' => 'nendy-123456',
            'payment_date' => '2022-02-01',
            'from' => '2022-02-01',
            'to' => '2022-03-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 5 bulan kemarin
        DB::table('premium_users')->insert([
            'user_id' => 'nendy-123456',
            'payment_date' => '2022-01-01',
            'from' => '2022-01-01',
            'to' => '2022-02-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
