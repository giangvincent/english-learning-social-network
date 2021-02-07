<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetPassLink extends Mailable
{
    use Queueable, SerializesModels;
    private $token = null;
    private $email = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->email = $user->email;
        $this->token = $user->token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ThatsGOOD, Khởi tạo lại mật khẩu.')
        ->from('giang.dlinh@gmail.com', 'ThatsGOOD Admin')
        ->markdown('emails.reset_pass_link', [
            'email' => $this->email,
            'token' => $this->token,
        ]);
    }
}
