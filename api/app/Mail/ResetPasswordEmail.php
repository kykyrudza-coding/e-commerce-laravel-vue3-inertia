<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User   $user,
        public string $token,
    ) {}

    public function build(): ResetPasswordEmail
    {
        $resetLink = url(route('password.reset', 'token={token}&email={email}', [
            'token' => $this->token,
            'email' => $this->user->email,
        ]));

        return $this->subject('Скидання пароля')
            ->view('emails.reset_password')
            ->with([
                'name' => $this->user->name,
                'resetLink' => $resetLink,
            ]);
    }
}


