<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $user, $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        // return $this->markdown('emails.welcome')
        // ->with('user', $user);

        // $footer = 'Your footer content goes here';
        // $subcopy = 'Your subcopy content goes here';
        // $header = 'Your header content goes here';

        return $this->markdown('emails.user_created_email')
            ->subject('Welcome to Glow Up Skin Care Clinic')->with(['user' => $this->user, 'password' => $this->password]);
    }
}
