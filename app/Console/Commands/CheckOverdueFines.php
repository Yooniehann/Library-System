<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use App\Models\Fine;
use App\Helpers\DateHelper;

class CheckOverdueFines extends Command
{
    protected $signature = 'fines:check-overdue';
    protected $description = 'Check for overdue books and generate fines automatically';

    public function handle()
    {
        $currentDate = DateHelper::now();

        $overdueBooks = Borrow::with(['user', 'inventory.book'])
            ->where('due_date', '<', $currentDate)
            ->where('status', '!=', 'returned')
            ->whereDoesntHave('fines', function($query) {
                $query->where('fine_type', 'overdue'); // Changed from checking unpaid to checking any overdue fines
            })
            ->get();

        $count = 0;
        foreach ($overdueBooks as $borrow) {
            // Calculate whole days overdue (ceil to ensure we count partial days as full days)
            $daysOverdue = max(0, ceil($currentDate->diffInHours($borrow->due_date, false) / 24 * -1));

            Fine::create([
                'borrow_id' => $borrow->borrow_id,
                'fine_type' => 'overdue',
                'amount_per_day' => 1.00, 
                'description' => "Overdue fine for '{$borrow->inventory->book->title}'. " .
                    ($daysOverdue == 1 ? "1 day overdue." : "{$daysOverdue} days overdue."),
                'fine_date' => $currentDate,
                'status' => 'unpaid',
            ]);

            $count++;
        }

        $this->info("Generated {$count} overdue fines.");
        return 0;
    }
}
