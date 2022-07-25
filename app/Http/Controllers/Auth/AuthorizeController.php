<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Authorize;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\View;
use App\Models\device_verification;
use Auth;

class AuthorizeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Validate the token for the Authorization.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        //dd("yew");
        $flight = device_verification::where('usr_id', Auth::id())->first();
        $input_code=$request->input('code');
        if ($flight->reg_id == $input_code) {

            $ip=\request()->ip();
            device_verification::where('usr_id', Auth::id())
            ->update(['ip_address' => $ip]);

            return redirect('home')->with('status', 'Awesome ! you are now authorized !');
        }


            return redirect('login')->with('error', 'Oh snap ! the authorization token is either expired or invalid');

    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        //if (Authorize::inactive() && auth()->check()) {
            $authorize = [
                'ip_address' => Request::ip(),
                'browser' => NULL,
                'token' =>NULL,
                'location' =>NULL
            ];

            Mail::to($request->user())
                ->send(new AuthorizeDevice($authorize));

            //$authorize->increment('attempt');

            return view('auth.authorize');
      //  }
    }
}
