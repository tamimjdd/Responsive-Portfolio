<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class searchController extends Controller
{
    public function search(Request $request){

        $posts= Post::where("title","like","%".$request->search."%")
        ->orderBy("id", "desc")
        ->get();
        $people=User::where("name", "like","%".$request->search."%")
        ->orderBy("id","desc")
        ->get();
        return view('search.view', compact('posts','people'));
    }

}
