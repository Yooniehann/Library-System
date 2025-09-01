<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use App\Helpers\DateHelper;

class SyncBorrowStatuses extends Command
{
    protected $signature = 'borrows:sync-status';
    protected $description = 'Sync borrow statuses with fine statuses';

    public function handle()
    {
        $currentDate = DateHelper::now();

        // Get all active and overdue borrows
        $borrows = Borrow::with('fines')
            ->whereIn('status', ['active', 'overdue'])
            ->get();

        $updatedCount = 0;

        foreach ($borrows as $borrow) {
            $originalStatus = $borrow->status;

            // Check if overdue status should be reverted
            if ($borrow->status === 'overdue' && $borrow->due_date >= $currentDate) {
                $borrow->status = 'active';
                $borrow->save();
                $updatedCount++;
                continue;
            }

            $borrow->updateStatusBasedOnFines();

            if ($borrow->status !== $originalStatus) {
                $updatedCount++;
            }
        }

        $this->info("Updated {$updatedCount} borrow statuses.");
        return 0;
    }
}
