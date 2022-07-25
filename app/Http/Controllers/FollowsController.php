<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Http\Request;

class FollowsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user){
        //$bool= $user->following()->where('profile_id', $user->id)->count();
        $user2 = User::findOrFail(auth()->user()->id);

        $checkUser = User::findOrFail($user->id);


        if(!$user2->isFollowing($user)){
            $follower = auth()->user();
            $user->notify(new UserFollowed($follower));
        }

        return auth()->user()->following()->toggle($user->profile);
    }

    public function notifications()
    {
        $noti=auth()->user()->notifications()->paginate(10);
        // dd($noti);
        return response()->json($noti);
    }

    public function notifications2()
    {
        return view('notifications.show');
    }
}
