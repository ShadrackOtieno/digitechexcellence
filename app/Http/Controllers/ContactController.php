<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'subject' => 'required|string|max:160',
            'message' => 'required|string|max:4000',
            'website' => 'max:0', // honeypot: real people leave this empty
        ]);
        unset($data['website']);

        $msg = ContactMessage::create($data);

        if ($to = Setting::get('notify_email')) {
            try {
                Mail::raw("From: {$msg->name} <{$msg->email}>\n\n{$msg->message}", fn ($m) => $m->to($to)->replyTo($msg->email)->subject("Website message: {$msg->subject}"));
            } catch (\Throwable $e) {
                report($e); // the message is already saved, so never lose it because mail failed
            }
        }

        return redirect()->route('contact')->with('success', 'Message sent. We will reply within one working day.');
    }
}
