<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    public function build()
    {
        $resetLink = url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->user->email,
        ], false));

        return $this->subject('Скидання пароля')
            ->view('emails.reset_password')
            ->with([
                'name' => $this->user->name,
                'resetLink' => $resetLink,
            ]);
    }
}


