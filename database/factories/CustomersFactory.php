<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name'=> $this->faker->firstName(),
            'last_name'=> $this->faker->lastName(),
            'gender'=>$this->faker->randomElement($array = array ('male', 'female')), 
            'date_of_birth' =>$this->faker->date(),
            'contact_number' =>$this->faker->phoneNumber(),
            'email'=>$this->faker->email()
        ];
    }
}
