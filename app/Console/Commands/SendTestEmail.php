<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test {name}';

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
        $this->info('hello ' ." " . $this->argument('name') ." in laravel 12");
        return Command::SUCCESS;
        
    }
}
