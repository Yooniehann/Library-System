<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use App\Helpers\DateHelper;

class UpdateOverdueBooks extends Command
{
    protected $signature = 'books:update-overdue';
    protected $description = 'Update book status to overdue when due date has passed';

    public function handle()
    {
        $currentDate = DateHelper::now();

        // Find active books where due date has passed
        $overdueBooks = Borrow::where('status', 'active')
            ->where('due_date', '<', $currentDate)
            ->get();

        $count = $overdueBooks->count();

        if ($count > 0) {
            // Update status to overdue
            Borrow::where('status', 'active')
                ->where('due_date', '<', $currentDate)
                ->update(['status' => 'overdue']);

            $this->info("Updated {$count} books to overdue status.");
        } else {
            $this->info("No books need to be updated to overdue status.");
        }

        return 0;
    }
}
