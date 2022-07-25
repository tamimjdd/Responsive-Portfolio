<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Post;
use App\Models\Photo;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function countpost($user){

        $user= User::findOrFail($user);

        $postCount =  $user->posts->count();

            return response()->json([
                'students'=>$postCount,
            ]);
    }

    public function index(){
        $users= auth()->user()->following()->pluck('profiles.user_id');

        $posts= Post::whereIn('user_id', $users)->latest()->get();



        return view('posts.index', compact('posts'));
    }

    public static  function allphoto($post){
        $photo = DB::table('photos')->where('post_id', $post)->get();
        return response()->json([
            'students'=>$photo,
        ]);
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){

        $data=request()->validate([
            'title' => 'required|max:114',
            'description' => '',
            'description2' => '',
            'images' => 'required',
            'images.*' => 'mimes:jpg,png,jpeg,gif,svg|max:5048',
            'thumbnail' => 'required|mimes:jpg,png,jpeg,gif,svg|max:5048',
            'tags' => 'required',
        ]);

         $newImageName= uniqid(). '-'. $request->title.'.' .
         $request->thumbnail->extension();

         $request->thumbnail->move(public_path() . '/images/',$newImageName);

         $image=Image::make(public_path() . '/images/'.$newImageName);
         $image->resize(1200,1200);
         $image->save();

        $slug = SlugService::createSlug(Post::class, 'slug',
        $request->title);

        $editor=null;

        if($request->input('description')==NULL){
            $description_main=$request->input('description2');
            $editor=2;
        }
        else{
            $editor=1;
            $description_main=$request->input('description');
        }

        $tags=explode(", ",$request->tags);
        $forid=auth()->user()->posts()->create([
            'title' => $request->input('title'),
            'description' => $description_main,
            'slug' => $slug,
            'user_id' => auth()->user()->id,
            'thumbnail' =>$newImageName,
            'editor' => $editor,
        ]);
        $forid->tag($tags);
        $Id = $forid->id;
        //dd($request->file('images'));
        if ($files = $request->file('images')) {

                 foreach($files as $img) {
                    $newImageName= uniqid(). '-'. $request->title.'.' .$img->extension();
                    // Upload Orginal Image
                    $img->move(public_path() . '/images/', $newImageName);
                    $image=Image::make(public_path() . '/images/'.$newImageName);
                    $image->resize(1200,1200);
                    $image->save();
                    // Save In Database
                    $imagemodel= new Photo();
                    $imagemodel->photo_name="$newImageName";
                    $imagemodel->post_id= $Id;
                    $imagemodel->save();
                }

        }

        return redirect('/profile/'.auth()->user()->id);

    }

    public function show(\App\Models\Post $post){

        $photo = DB::table('photos')->where('post_id', $post->id)->get();
        //dd($photo);
        // foreach ($photo as $user) {
        //     echo $user->photo_name;
        // }
        return view('posts.show',[
            'post' => $post,
            'photo' => $photo,
        ]);
    }

    public static function tagShow($id){
        $photo = DB::table('tagging_tagged')->where('taggable_id', $id)->get();
        return $photo;
    }


    public function edit(\App\Models\Post $post){

        return view('posts.edit', compact('post'));
    }

    public function update(\App\Models\Post $post, Request $request){


        $data= request()->validate([
            'title' => 'required',
            'description' => '',
            'images' => '',
            'images.*' => 'mimes:jpg,png,jpeg,gif,svg|max:5048',
            'thumbnail' => 'mimes:jpg,png,jpeg,gif,svg|max:5048'
        ]);

        if ($files = $request->file('images')) {

            foreach($files as $img) {
               $newImageName= uniqid(). '-'. $request->title.'.' .$img->extension();
               // Upload Orginal Image
               $img->move(public_path() . '/images/', $newImageName);
               $image=Image::make(public_path() . '/images/'.$newImageName);
               $image->resize(1200,1200);
               $image->save();
               // Save In Database
               $imagemodel= new Photo();
               $imagemodel->photo_name="$newImageName";
               $imagemodel->post_id= $post->id;
               $imagemodel->save();
           }

        }



        if(request('thumbnail')){
            $newImageName= uniqid(). '-'. $request->title.'.' .
            $request->thumbnail->extension();

            $request->thumbnail->move(public_path() . '/images/',$newImageName);

            $image=Image::make(public_path() . '/images/'.$newImageName);
            $image->resize(1200,1200);
            $image->save();
            $imageArray= ['thumbnail' => $newImageName];
        }


        $data2=[
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ];

        Post::where('id', $post->id)->update(array_merge(
            $data2,
           $imageArray ?? []
        ));

        return redirect("/profile/{$post->user_id}");
    }

    public function deletephoto($id){
        $delete_photo= \DB::table('photos')->where('id',$id)->delete();
        return response()->json(['success' => 'deleted photo!']);
    }

    public function delete($id){
        \DB::table('photos')->where('post_id',$id)->delete();
        \DB::table('laravellikecomment_comments')->where('item_id',$id)->delete();
        \DB::table('laravellikecomment_likes')->where('item_id',$id)->delete();
        \DB::table('laravellikecomment_total_likes')->where('item_id',$id)->delete();
        \DB::table('posts')->where('id',$id)->delete();
        return response()->json(['success' => 'deleted post!']);
    }

}
