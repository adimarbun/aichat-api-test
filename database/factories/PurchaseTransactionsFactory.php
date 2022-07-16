<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseTransactions>
 */
class PurchaseTransactionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' =>mt_rand(1,20),
            'total_spent' =>$this->faker->numberBetween($min = 100000, $max = 5000000),
            'total_saving' =>$this->faker->numberBetween($min = 100000, $max = 5000000),
            'transaction_at'=>$this->faker->dateTimeBetween($startDate = '-5 month', $endDate = 'now'),
        ];
    }
}
