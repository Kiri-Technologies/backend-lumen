<?php

namespace Database\Seeders;

use App\Models\Riwayat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Riwayat::factory(5)->create();

        $user = [
            [
                'id' => 'user-123456',
                'name' => 'user',
                'email' => 'user@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'penumpang',
                'no_hp' => '081234567890',
                'password' => bcrypt('password'),
            ],
            [
                'id' => 'supir-123456',
                'name' => 'supir',
                'email' => 'supir@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'no_hp' => '081234567891',
                'password' => bcrypt('password'),
            ],
            [
                'id' => 'owner-123456',
                'name' => 'owner',
                'email' => 'owner@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'owner',
                'no_hp' => '081234567891',
                'password' => bcrypt('password'),
            ],
            [
                'id' => 'admin-123456',
                'name' => 'admin',
                'email' => 'admin@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'admin',
                'no_hp' => '081234567891',
                'password' => bcrypt('password'),
            ],

            // ========================================================
            // ========= User Tambahan Soalnya migrasi error ==========
            // ========================================================
            [
                'id' => '1',
                'name' => 'supir',
                'email' => 'supir1@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'no_hp' => '081234567891',
                'password' => bcrypt('password'),
            ],
            [
                'id' => '2',
                'name' => 'supir',
                'email' => 'supir2@kiri.id',
                'birthdate' => '2017-06-15',
                'role' => 'supir',
                'no_hp' => '081234567891',
                'password' => bcrypt('password'),
            ],
            
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
