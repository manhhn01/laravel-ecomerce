<?php

namespace App\Mail\Front;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $reset_code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reset_code)
    {
        $this->reset_code = $reset_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@lifewear.mn07.xyz', 'Lifewear Store')
            ->view('mail.resetpassword',[
                'reset_code' => $this->reset_code,
            ]);
    }
}
