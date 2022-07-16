<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTransactions extends Model
{
    use HasFactory;
    protected $table ='purchase_transaction';
    protected $fillable =[
        'customer_id',
        'total_spent',
        'total_saving',
        'transaction_at'
    ];
}
