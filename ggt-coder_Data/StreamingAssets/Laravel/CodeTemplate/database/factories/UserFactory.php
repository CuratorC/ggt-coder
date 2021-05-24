<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;

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
  public function definition(): array
  {
    return [
      'phone' => rand(13200000000, 19999999999),
      'name' => $this->faker->name,
    ];
  }
}
