<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        
        // User::create([
            //     'name' => 'capricron',
            //     'email' => 'capricron@gmail.com',
            //     "password" => bcrypt('12345')
            // ]);      
            
            // User::create([
                //     'name' => 'leirion',
                //     'email' => 'leirion@gmail.com',
                //     "password" => bcrypt('12345')
                // ]); 
                
        User::factory(5)->create();
        
        Category::create([
            'name' => 'Programing',
            'slug' => 'programing'
        ]);

        Category::create([
            'name' => 'Design',
            'slug' => 'design'
        ]);

        Category::create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        Post::factory(20)->create();
    }
}
