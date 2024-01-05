<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupActivityLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activitylog:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old activity log records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutOffDate = Carbon::now()->subDays(7);
        $cutOffDate2 = Carbon::now()->subDays(30);
        \Log::alert($cutOffDate);

        ActivityLog::where('created_at', '<', $cutOffDate)->where('deleted_at', null)->delete();
        ActivityLog::where('created_at', '<', $cutOffDate2)->forceDelete();

        $this->info('Old activity log records deleted successfully.');
    }
}
