<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StaffSeeder extends Seeder
{
    // Arrays for random data generation
    private $firstNames = [
        'James',
        'Mary',
        'John',
        'Patricia',
        'Robert',
        'Jennifer',
        'Michael',
        'Linda',
        'William',
        'Elizabeth',
        'David',
        'Barbara',
        'Richard',
        'Susan',
        'Joseph',
        'Jessica',
        'Thomas',
        'Sarah',
        'Charles',
        'Karen',
        'Christopher',
        'Nancy',
        'Daniel',
        'Lisa',
        'Matthew',
        'Betty',
        'Anthony',
        'Margaret',
        'Mark',
        'Sandra',
        'Donald',
        'Ashley',
        'Steven',
        'Kimberly',
        'Paul',
        'Emily',
        'Andrew',
        'Donna',
        'Joshua',
        'Michelle'
    ];

    private $lastNames = [
        'Smith',
        'Johnson',
        'Williams',
        'Brown',
        'Jones',
        'Garcia',
        'Miller',
        'Davis',
        'Rodriguez',
        'Martinez',
        'Hernandez',
        'Lopez',
        'Gonzalez',
        'Wilson',
        'Anderson',
        'Thomas',
        'Taylor',
        'Moore',
        'Jackson',
        'Martin',
        'Lee',
        'Perez',
        'Thompson',
        'White',
        'Harris',
        'Sanchez',
        'Clark',
        'Ramirez',
        'Lewis',
        'Robinson',
        'Walker',
        'Young',
        'Allen',
        'King',
        'Wright',
        'Scott',
        'Torres',
        'Nguyen',
        'Hill',
        'Flores'
    ];

    private $positions = [
        'Librarian',
        'Assistant Librarian',
        'Head Librarian',
        'Reference Librarian',
        'Children\'s Librarian',
        'Technical Services Librarian',
        'Cataloging Librarian',
        'Acquisitions Librarian',
        'Circulation Desk Assistant',
        'Library Assistant',
        'Library Technician',
        'Library Associate',
        'Archivist',
        'Library Director',
        'Branch Manager',
        'Collection Development Librarian',
        'Digital Resources Librarian',
        'Interlibrary Loan Specialist',
        'Library Page',
        'Library Clerk',
        'Media Specialist',
        'Information Services Librarian',
        'Outreach Coordinator',
        'Youth Services Librarian',
        'Reference Assistant',
        'Library Security Officer',
        'Library Maintenance Staff',
        'Volunteer Coordinator'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = [];

        for ($i = 1; $i <= 50; $i++) {
            $firstName = $this->firstNames[array_rand($this->firstNames)];
            $lastName = $this->lastNames[array_rand($this->lastNames)];
            $fullname = $firstName . ' ' . $lastName;
            $email = strtolower($firstName . '.' . $lastName . $i . '@example.com');

            // Ensure email is unique by checking if it exists and modifying if needed
            $baseEmail = $email;
            $counter = 1;
            while (in_array($email, array_column($staff, 'email'))) {
                $email = str_replace('@', $counter . '@', $baseEmail);
                $counter++;
            }

            $hireDate = Carbon::now()->subDays(rand(30, 1000))->format('Y-m-d');
            $status = rand(0, 10) > 1 ? 'active' : 'inactive'; // 90% active, 10% inactive

            $staff[] = [
                'fullname' => $fullname,
                'email' => $email,
                'password' => Hash::make('password123'), // Default password for all staff
                'phone' => $this->generatePhoneNumber(),
                'position' => $this->positions[array_rand($this->positions)],
                'hire_date' => $hireDate,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all staff members in a single query for better performance
        DB::table('staff')->insert($staff);
    }

    /**
     * Generate a random phone number
     */
    private function generatePhoneNumber(): ?string
    {
        // 10% chance of null phone number
        if (rand(1, 10) === 1) {
            return null;
        }

        $areaCode = rand(200, 999);
        $exchangeCode = rand(200, 999);
        $subscriberNumber = rand(1000, 9999);

        return $areaCode . '-' . $exchangeCode . '-' . $subscriberNumber;
    }
}
