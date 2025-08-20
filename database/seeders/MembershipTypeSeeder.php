<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\MembershipType;
use Illuminate\Database\Seeder;

class MembershipTypeSeeder extends Seeder
{
    public function run(): void
    {
        MembershipType::create([
            'type_name' => 'Kids',
            'description' => 'For children under 13',
            'max_books_allowed' => 5,
            'start_date' => Carbon::now()->toDateString(),
            'expiry_date' => Carbon::now()->addMonth()->toDateString(),
            'membership_monthly_fee' => 2,
            'membership_annual_fee' => 20,
        ]);

        MembershipType::create([
            'type_name' => 'Student',
            'description' => 'For learners of all ages',
            'max_books_allowed' => 10,
            'start_date' => Carbon::now()->toDateString(),
            'expiry_date' => Carbon::now()->addMonth()->toDateString(),
            'membership_monthly_fee' => 5,
            'membership_annual_fee' => 50,
        ]);

        MembershipType::create([
            'type_name' => 'Public',
            'description' => 'For avid readers',
            'max_books_allowed' => 20,
            'start_date' => Carbon::now()->toDateString(),
            'expiry_date' => Carbon::now()->addMonth()->toDateString(),
            'membership_monthly_fee' => 10,
            'membership_annual_fee' => 100,
        ]);

        MembershipType::create([
            'type_name' => 'Family',
            'description' => 'Perfect for households',
            'max_books_allowed' => 30,
            'start_date' => Carbon::now()->toDateString(),
            'expiry_date' => Carbon::now()->addMonth()->toDateString(),
            'membership_monthly_fee' => 15,
            'membership_annual_fee' => 150,
        ]);

    }
}
