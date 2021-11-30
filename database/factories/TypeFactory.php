<?php
//指令 php artisan make:factory TypeFactory --model=Type
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Type;


class TypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Type::class;

    public function definition()
    {
        return [
            'name' =>$this->faker->unique()->name,
        ];
    }
}
