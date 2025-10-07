<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'eventdate' => 'required|date',
            'eventtype' => 'required',
            'eventplace' => 'required',
            'message' => 'required',
        ]);

        // Assuming mail is configured to use the log driver for testing
        Mail::to('admin@example.com')->send(new ContactFormMail($validatedData));

        return redirect('/')->with('success', 'Gracias por contactarnos. Te responderemos a la brevedad.');
    }
}
