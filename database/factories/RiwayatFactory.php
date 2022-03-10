<?php

namespace Database\Factories;

use App\Models\Riwayat;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiwayatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Riwayat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1,2),
            'angkot_id' => $this->faker->unique()->randomDigit(),
            'jumlah_pendapatan' => $this->faker->numberBetween(1000,20000),
            'waktu_narik' =>$this->faker->time(),  
            'selesai_narik' => $this->faker->numberBetween(0,1),
        ];
    }
}
