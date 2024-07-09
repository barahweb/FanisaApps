<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'id_kategori' => mt_rand(1, 3),
            'nama_barang' => $this->faker->company,
            'harga' => $this->faker->numberBetween($min = 10000, $max = 40000),
            'jumlah' => mt_rand(1, 10),
            'berat' => mt_rand(1, 2),
        ];
    }
}
