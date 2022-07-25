<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthorizeDevice;
use Stevebauman\Location\Facades\Location;
use App\Models\device_verification;
use DB;


class UserMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {



        $ip=\request()->ip();
         //dd("yes");
        $oldip=DB::select('select ip_address from device_verifications where user_id = ?', [Auth::id()]);

        //dd($oldip[0]->ip_address);

        if($oldip[0]->ip_address != $ip){
            $location= Location::get();
            $rand=rand(0, 99999);

            $flight = device_verification::where('user_id', Auth::id())->first();
            device_verification::where('usr_id', Auth::id())
            ->update(['reg_id' => $rand]);

            $authorize = [
                'ip_address' => \Request::ip(),
                'browser' => $request->header('User-Agent'),
                'token' =>$rand,
                'location' =>$location->countryName
            ];

            Mail::to($request->user())
                ->send(new AuthorizeDevice($authorize, $request));
                return response()->view('auth.authorize');
        }


        return $next($request);
    }
}
