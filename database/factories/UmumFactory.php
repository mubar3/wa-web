<?php

namespace Database\Factories;

use App\Models\Umum;
use Illuminate\Database\Eloquent\Factories\Factory;

class UmumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Umum::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama'  => 'Master Web',
            'logo'  => 'logo.png',
            'favicon' => 'favicon.png'
        ];
    }
}
