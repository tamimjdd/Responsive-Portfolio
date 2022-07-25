<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class AuthorizeDevice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    protected $authorize;
    public $request=null;

    /**
     * Create a new message instance.
     *
     * @param $authorize
     *  @return void
     */
    public function __construct($authorize,Request $request)
    {
        $this->authorize = $authorize;
        $this->request=$request;
    }

    /**
     * @return mixed
     */


    /**
     * @return mixed
     */


    /**
     * @return mixed
     */


    /**
     * @return mixed
     */




    /**
     * Build the message.
     *
     *
     * @return $this
     */
    public function build()
    {


        return $this
            ->view('emails.auth.authorize')
            ->with(['authorize' => $this->authorize]);
    }
}
