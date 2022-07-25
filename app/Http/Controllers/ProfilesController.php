<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index($user){
        $user= User::findOrFail($user);

        $follows=(auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->posts->count();
            });

        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->profile->followers->count();
            });

        $followingCount = Cache::remember(
            'count.following.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->following->count();
            });

        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(\App\Models\User $user){
        $this->authorize('update',$user->profile);

        return view('profiles.edit',[
            'user' => $user
        ]);
    }

    public function update(User $user){
        $this->authorize('update',$user->profile);


        $data= request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);




        if(request('image')){
            $slug = SlugService::createSlug(Post::class, 'slug',
            request('title'));
            $newImageName= uniqid(). '-'. $slug.'.' .
            request('image')->extension();
            request('image')->move(public_path() . '/images/',$newImageName);
            $image=Image::make(public_path() . '/images/'.$newImageName);
            $image->resize(1200,1200);
            $image->save();
            $imageArray= ['image' => $newImageName];
        }


        auth()->user()->profile->update(array_merge(
            $data,
           $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
    }

    public function getPost($id){

        $user= Post::where('user_id',$id)->get();
        return response()->json([
            'students'=>$user,
        ]);
    }


}
