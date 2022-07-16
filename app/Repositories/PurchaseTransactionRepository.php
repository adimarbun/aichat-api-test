<?php

namespace App\Repositories;

use App\Models\PurchaseTransactions;

class PurchaseTransactionRepository
{
    protected $purchaseTransaction;

    public function __construct(PurchaseTransactions $purchaseTransaction)
    {
        $this->purchaseTransaction = $purchaseTransaction;
    }
    public function findByCustomerIdAndTransactionAt($customer_id,$date){
        return $this->purchaseTransaction->where('customer_id','=',$customer_id)
                        ->whereDate('transaction_at','>=',$date)->get();
    }
}