<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // public $data;
    public $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        // $email = new SendEmail($this->data);
        // Mail::to($this->data['email'])->send($email);

        Mail::to($this->user->email)->send(new RegistrationSuccessMail($this->user));
    }
}
