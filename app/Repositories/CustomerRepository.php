<?php

namespace App\Repositories;

use App\Models\Customers;

class CustomerRepository{
    protected $customer;
    public function __construct(Customers $customer)
    {
        $this->customer = $customer;
    }

    public function findByEmail($email){
        return $this->customer->where('email',$email)->first();
    }
}