<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupOldSessions extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:cleanup';
    protected $description = 'Clean up old user sessions';

    /**
     * The console command description.
     *
     * @var string
     */
   

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear session IDs from users where session expired
        DB::table('users')
            ->whereNotNull('session_id')
            ->where('updated_at', '<', now()->subHours(2))
            ->update(['session_id' => null]);
            
        $this->info('Old sessions cleaned up successfully.');
    }
}
