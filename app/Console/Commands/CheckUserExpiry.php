<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckUserExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-user-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCustomers = User::whereDate('expiry_date', '<', now())->get();
        foreach ($expiredCustomers as $customer){
            $customer->update(['status' => '0']);
        }
        $this->info('Expired User status changes successfully');
    }
}
