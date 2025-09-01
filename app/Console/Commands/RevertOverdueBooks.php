<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use Carbon\Carbon;

class RevertOverdueBooks extends Command
{
    protected $signature = 'books:revert-overdue';
    protected $description = 'Revert overdue status for books that are no longer overdue in real time';

    public function handle()
    {
        $realCurrentDate = now(); // Use real current date, not simulated date

        // Find books marked as overdue that are no longer overdue in real time
        $booksToRevert = Borrow::where('status', 'overdue')
            ->where('due_date', '>=', $realCurrentDate)
            ->get();

        $count = $booksToRevert->count();

        if ($count > 0) {
            // Update status back to active
            Borrow::where('status', 'overdue')
                ->where('due_date', '>=', $realCurrentDate)
                ->update(['status' => 'active']);

            $this->info("Reverted {$count} books from overdue to active status.");
        } else {
            $this->info("No books need to be reverted from overdue status.");
        }

        return 0;
    }
}
