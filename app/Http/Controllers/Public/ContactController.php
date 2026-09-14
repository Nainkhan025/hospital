<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ]);

        // TODO: send mail notification in Phase 1
        // Mail::to('info@hospital.test')->send(new ContactFormMail($request->validated()));

        return back()->with('success', 'Thank you! Your message has been received. We\'ll get back to you shortly.');
    }
}
