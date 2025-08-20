<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishers = [
            [
                'publisher_name' => 'Penguin Random House',
                'phone' => '2127829000',
                'email' => 'info@penguinrandomhouse.com',
                'address' => '1745 Broadway, New York, NY 10019, USA',
                'website' => 'https://www.penguinrandomhouse.com'
            ],
            [
                'publisher_name' => 'HarperCollins',
                'phone' => '2122077000',
                'email' => 'contact@harpercollins.com',
                'address' => '195 Broadway, New York, NY 10007, USA',
                'website' => 'https://www.harpercollins.com'
            ],
            [
                'publisher_name' => 'Simon & Schuster',
                'phone' => '2126987000',
                'email' => 'customerservice@simonandschuster.com',
                'address' => '1230 Avenue of the Americas, New York, NY 10020, USA',
                'website' => 'https://www.simonandschuster.com'
            ],
            [
                'publisher_name' => 'Macmillan Publishers',
                'phone' => '6463075151',
                'email' => 'inquiries@macmillan.com',
                'address' => '120 Broadway, New York, NY 10271, USA',
                'website' => 'https://www.macmillan.com'
            ],
            [
                'publisher_name' => 'Hachette Book Group',
                'phone' => '2123641100',
                'email' => 'publicity@hachettebookgroup.com',
                'address' => '1290 Avenue of the Americas, New York, NY 10104, USA',
                'website' => 'https://www.hachettebookgroup.com'
            ],
            [
                'publisher_name' => 'Scholastic Corporation',
                'phone' => '2123436100',
                'email' => 'customerservice@scholastic.com',
                'address' => '557 Broadway, New York, NY 10012, USA',
                'website' => 'https://www.scholastic.com'
            ],
            [
                'publisher_name' => 'Oxford University Press',
                'phone' => '19825384000',
                'email' => 'enquiry@oup.com',
                'address' => 'Great Clarendon Street, Oxford OX2 6DP, UK',
                'website' => 'https://global.oup.com'
            ],
            [
                'publisher_name' => 'Cambridge University Press',
                'phone' => '1223339111',
                'email' => 'information@cambridge.org',
                'address' => 'University Printing House, Shaftesbury Road, Cambridge CB2 8BS, UK',
                'website' => 'https://www.cambridge.org'
            ],
            [
                'publisher_name' => 'Pearson Education',
                'phone' => '8008823419',
                'email' => 'customer.service@pearson.com',
                'address' => '330 Hudson Street, New York, NY 10013, USA',
                'website' => 'https://www.pearson.com'
            ],
            [
                'publisher_name' => 'Bloomsbury Publishing',
                'phone' => '2076315600',
                'email' => 'contact@bloomsbury.com',
                'address' => '50 Bedford Square, London WC1B 3DP, UK',
                'website' => 'https://www.bloomsbury.com'
            ]
        ];

        foreach ($publishers as $publisher) {
            DB::table('publishers')->insert([
                'publisher_name' => $publisher['publisher_name'],
                'phone' => $publisher['phone'],
                'email' => $publisher['email'],
                'address' => $publisher['address'],
                'website' => $publisher['website'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}