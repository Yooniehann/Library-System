<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Example books data
        $featuredBooks = [
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'cover' => 'https://m.media-amazon.com/images/I/71FTb9X6wsL._AC_UF1000,1000_QL80_.jpg'
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'cover' => 'https://m.media-amazon.com/images/I/71FxgtFKcQL._AC_UF1000,1000_QL80_.jpg'
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'cover' => 'https://m.media-amazon.com/images/I/61ZewDE3beL._AC_UF1000,1000_QL80_.jpg'
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'cover' => 'https://m.media-amazon.com/images/I/71Q1tPupKjL._AC_UF1000,1000_QL80_.jpg'
            ]
        ];

        return view('home', ['books' => $featuredBooks]);
    }
}