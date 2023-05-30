<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'access:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset access column to zero from table shorteners first day of witch month';
    

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('shorteners')->update(['access' => 0]);
        $this->info('Access column reset successfully.');
    }
}
