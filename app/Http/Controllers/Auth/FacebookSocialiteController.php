<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\device_verification;

class FacebookSocialiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFB()
    {
       // dd("yes");
       return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {


            $user = Socialite::driver('google')->user();
            //dd("yes");
            $finduser = User::where('email', $user->email)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/');

            }else{

                $user2 = new User;
                $user2->name = $user->name;
                $user2->email = $user->email;
                $user2->social_id = $user->id;
                $user2->social_type= 'google';
                $user2->password = bcrypt($user2->name);
                $user2->save();

                $finduser2 = User::where('email', $user->email)->first();
                $device = new device_verification();

                $device->usr_id=$finduser2->id;
                $device->ip_address = \request()->ip();
                $device->reg_id=NULL;
                $device->save();

                Auth::login($user2);

                return redirect('/');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
