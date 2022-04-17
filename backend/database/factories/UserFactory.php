<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->regexify('[A-Z]{6}[0-9]{2}'),
            'display_name'=> $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'avatar' => $this->faker->imageUrl(),
            'password' => 'password',
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'bio'  => $this->faker->text(80),
            'birthday' => $this->faker->date()
        ];
    }
}
