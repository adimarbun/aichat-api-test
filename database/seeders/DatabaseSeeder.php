<?php

namespace Database\Seeders;

use App\Models\Customers;
use App\Models\PurchaseTransactions;
use App\Models\Voucher;
use Carbon\Carbon;
use Database\Factories\VoucherFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('customers')->insert([
            [
                'id' => 1,
                'first_name'=> 'budi',
                'last_name'=> 'nugroho',
                'gender'=>'male', 
                'date_of_birth' =>Carbon::parse('1996-4-10'),
                'contact_number' =>'081122334455',
                'email'=>'budi@gmail.com'
            ],
            [
                'id'=>2,
                'first_name'=> 'putri',
                'last_name'=> 'yani',
                'gender'=>'female', 
                'date_of_birth' =>Carbon::parse('1998-1-14'),
                'contact_number' =>'081122334466',
                'email'=>'putri@gmail.com'
            ]
            ]);

        DB::table('purchase_transaction')->insert([
            [
                'customer_id'=>1,
                'total_spent' =>500000,
                'total_saving' =>50000,
                'transaction_at' => Carbon::create(2022,06,20,13,0,0),
            ],
            [
                'customer_id'=>1,
                'total_spent' =>400000,
                'total_saving' =>20000,
                'transaction_at' => Carbon::create(2022,07,01,12,0,0),
            ],
            [
                'customer_id'=>1,
                'total_spent' =>800000,
                'total_saving' =>80000,
                'transaction_at' => Carbon::create(2022,07,05,20,0,0),
            ]
        ]);
        Customers::factory(30)->create();
        PurchaseTransactions::factory(500)->create();

        DB::table('campaign')->insert([
            [
                'start_campaign'=>Carbon::create(2022,07,16,16,0,0),
                'end_campaign'=>null,
                'name'=>'anniversary',
                'link'=>'http://ptcerah.com/anniversary'
            ]
        ]);   

        Voucher::factory(1000)->create();
    }
}
