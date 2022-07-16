<?php

namespace App\Console;

use App\Models\Voucher;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
             $vouchers = Voucher::where('claim_expired_at','<',now())->get();
                foreach($vouchers as  $voucher){
                    $voucher->is_pending = false;
                    $voucher->claim_by = null;
                    $voucher->claim_expired_at = null;
                    $voucher->save();
                }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
