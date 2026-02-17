<?php

namespace Database\Factories;

use App\Enums\LoanStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoanRequest>
 */
class LoanRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(LoanStatus::cases());

        $items = [
            'Monitor',
            'Laptop',
            'Keyboard',
            'Mouse',
            'Mousepad',
            'HDMI Cable',
            'Microphone Wireless',
            'Camera',
            'Gamepad',
            'Headset',
        ];

        return [
            'user_id'   => 1,
            'item_name' => $this->faker->randomElement($items),
            'status'    => $status,
            'loan_date' => $this->faker->date(),
            'return_date' => $status === LoanStatus::RETURNED ? $this->faker->date() : null,
            'reason'    => $status === LoanStatus::REJECTED ? $this->faker->sentence() : null,
        ];
    }
}
