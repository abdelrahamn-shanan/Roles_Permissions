<?php
// app/Console/Commands/DailyUsersReport.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DailyUsersReport extends Command
{
    protected $signature = 'report:daily-users';
    protected $description = 'Send daily users report';

   public function handle()
   {
    
    Mail::raw('Hello test', function ($message) {
        $message->to('admin@example.com')
                ->subject('Test Mail');
    });
    
    return 0;
   }
}
