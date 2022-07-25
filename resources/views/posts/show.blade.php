@extends('layouts.app')

@section('content')

    <div class="w-4/5 m-auto text-left">
    <div class="py-15">
        <h1 class="text-6xl">
            {{ $post->title }}
        </h1>
    </div>
    <div >
        <div
        id="carouselExampleCrossfade"
        class="carousel slide carousel-fade relative"
        data-bs-ride="carousel"
        >
        <div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-4">
            @foreach($photo as $slider)
                <button
                type="button"
                data-bs-target="#carouselExampleCrossfade"
                data-bs-slide-to="{{ $loop->index }}"
                class="{{ $loop->first ? 'active' : '' }}"
                aria-current="true"
                aria-label="Slide 1"
                ></button>
            @endforeach

        </div>

            <div class="carousel-inner relative w-full overflow-hidden">
                @foreach($photo as $key =>$slider)
                <div class="carousel-item float-left w-full {{$key == 0 ? 'active' : '' }}">


                    <img src="{{ asset('images/' . $slider->photo_name) }}" alt="slider" class="block w-full">
                </div>

                @endforeach
            </div>

        <button
            class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
            type="button"
            data-bs-target="#carouselExampleCrossfade"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon inline-block bg-no-repeat" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
            type="button"
            data-bs-target="#carouselExampleCrossfade"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon inline-block bg-no-repeat" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    </div>
    </div>

    <div class="w-4/5 m-auto pt-20">

    <span class="text-gray-500">
        By
        <a href="/profile/{{ $post->user->id }}">
            <span class="font-bold italic text-gray-800">{{ $post->user->name }}</span>
        </a>
        , Created on {{ date('jS M Y', strtotime($post->updated_at)) }},

    </span>
    <?php

    $tags = App\Http\Controllers\PostsController::tagShow($post->id);


    ?>
    <strong>Tag:</strong>
    @foreach($tags as $tag)
    <label class="label label-info">{{ $tag->tag_name }}</label>
    @endforeach


    {{-- @include('laravelLikeComment::like', ['like_item_id' => $post->id]) --}}
    <likes :like_item_id="{{ $post->id }}"></likes>

    <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
        {!! $post->description !!}
    </p>



    @include('laravelLikeComment::comment', ['comment_item_id' => $post->id] )

    </div>


@endsection

