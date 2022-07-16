<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code_voucher'=>$this->faker->regexify('[A-Za-z0-9]{10}'),
            'campaign_id' =>1,
            'is_pending' =>false,
            'status_claim' =>false
        ];
    }
}
