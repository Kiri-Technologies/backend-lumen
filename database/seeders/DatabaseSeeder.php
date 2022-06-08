<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\History;
use App\Models\User;
use App\Models\Trip;

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
                'user_id' => 'owner-123456',
                'route_id' => 1,
                'plat_nomor' => 'B 8123 AB',
                'qr_code' => 'http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($_ENV['APP_URL'] . '/vehicle/1'),
                'pajak_tahunan' => '2017-06-15',
                'pajak_stnk' => '2017-06-15',
                'kir_bulanan' => '2017-06-15',
                'is_beroperasi' => null,
                'supir_id' => null,
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
                'plat_nomor' => 'B 7123 XA',
                'qr_code' => 'http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($_ENV['APP_URL'] . '/vehicle/3'),
                'pajak_tahunan' => '2017-06-15',
                'pajak_stnk' => '2017-06-15',
                'kir_bulanan' => '2017-06-15',
                'is_beroperasi' => null,
                'supir_id' => null,
                'status' => 'approved',
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
            'supir_id' => 'supir-123456',
            'angkot_id' => 2,
            'is_confirmed' => 1,
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);


        // ========================================================
        // ==================== Seeder History =======================
        // ========================================================
        

        DB::table('histories')->insert([
            'user_id' => 'supir-123456',
            'angkot_id' => 1,
            'jumlah_pendapatan' => 15000,
            'mulai_narik' => $faker->dateTime,
            'selesai_narik' => $faker->dateTime,
            'status' => 'done',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ]);

        DB::table('histories')->insert([
            'user_id' => 'supir-123456',
            'angkot_id' => 2,
            'jumlah_pendapatan' => 10000,
            'mulai_narik' => $faker->dateTime,
            'selesai_narik' => $faker->dateTime,
            'status' => 'done',
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
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
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
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
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
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
    }
}
