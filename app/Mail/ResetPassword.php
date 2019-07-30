<?php

namespace App\Mail;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email)
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = hash('sha256', Str::random(60));

        User::where(['email' => $this->email])->update(['reset_password' => $token]);
        $url = getEnv('SITE').'/reset/'.$token;

        return $this->markdown('emails.users.resetpassword', [
            'url' => $url,
            'name' =>  $this->name,
        ]);
    }
}
