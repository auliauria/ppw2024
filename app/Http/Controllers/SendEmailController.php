<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendEmail;
use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessMail;

class SendEmailController extends Controller
{
    public function index()
    {
        return view('emails.kirim-email');
        // $content = [
        //     'name' => 'Ini Nama Pengirim',
        //     'subject' => 'Ini subject email',
        //     'body' => 'Ini adalah isi email yang dikirim dari laravel 10'
        // ];
        // Mail::to('aulia4035@gmail.com')->send(new SendEmail($content));
        // return "Email berhasil dikirim.";
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        SendMailJob::dispatch($user);

        return redirect()->route('dashboard')->withSuccess('User successfully registered!');
    }
}
