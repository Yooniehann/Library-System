<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KidContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function index()
    {
        // Loads the kidcontact.blade.php view
        return view('dashboard.kid.kidcontact');
    }

    /**
     * Handle the contact form submission.
     */
    public function send(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Send email using Laravel's Mail facade
        Mail::raw(
            "Name: {$validated['name']}\nEmail: {$validated['email']}\n\nMessage:\n{$validated['message']}",
            function ($message) use ($validated) {
                $message->to('yonakou2002@gmail.com')
                        ->subject($validated['subject']);
            }
        );

        // Redirect back with a success message
        return back()->with('success', 'Message sent successfully!');
    }
}
