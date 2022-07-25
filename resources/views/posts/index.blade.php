@extends('layouts.app')

@section('content')

<div class="inline-grid grid-cols-3 gap-4">
    @foreach($posts as $post)
        <div class="pt-4 transition transform hover:-translate-y-1 motion-reduce:transition-none motion-reduce:transform-none">
            <a href="/p/{{$post->id}}">
                <img src="{{ asset('images/' . $post->thumbnail) }}" class="w-4/5 hover:border-t-4
                 hover:border-r-4 hover:border-l-4 rounded-md border-indigo-500" id="image22">
                <div class="flex pt-4" onmouseover="func()">
                    <img src="{{ $post->user->profile->profileImage()}}" class="w-6 rounded-full lg:w-14" alt="">
                    <div>
                        <div class="text-sm lg:text-2xl line-clamp-1">{{$post->title}}</div >
                        <div class="text-sm">{{$post->user->name}}</div >
                    </div>
                </div>
            </a>
        </div>
    @endforeach

</div>


@endsection

