<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testament>
 */
class TestamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::find(1),
            'title' => fake()->sentence(3),
            'content' => fake()->paragraph(5),
            'send_at' => fake()->dateTimeBetween('+1 day', '+1 year'),
            'recipient_email' => fake()->safeEmail(),
            'is_encrypted' => false,
            'sent_at' => fake()->dateTimeBetween('now', '+1 year'),
            'status' => 'null',
        ];
    }
}
