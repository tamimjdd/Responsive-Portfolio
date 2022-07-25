@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10">

    <div class="w-4/5 m-auto text-left">
        <div class="py-15">
            <h1 class="text-6xl">
                Edit Profile
            </h1>
        </div>
    </div>
    <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST"
        action="/profile/{{ $user->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="flex flex-wrap">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                Title:
            </label>

            <input id="title" type="text" class="form-input w-full @error('title')  border-red-500 @enderror"
                name="title" value="{{ old('title') ?? $user->profile->title ?? 'N/A' }}" required autocomplete="title" autofocus>

            @error('title')
            <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="flex flex-wrap">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                Description:
            </label>

            <input id="description" type="text" class="form-input w-full @error('description')  border-red-500 @enderror"
                name="description" value="{{ old('description') ?? $user->profile->description ?? 'N/A' }}" required autocomplete="description" autofocus>

            @error('description')
            <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="flex flex-wrap">
            <label for="url" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                Url:
            </label>

            <input id="url" type="text" class="form-input w-full @error('url')  border-red-500 @enderror"
                name="url" value="{{ old('url') ?? $user->profile->url ?? 'N/A' }}" required autocomplete="url" autofocus>

            @error('url')
            <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
            </p>
            @enderror
        </div>

        <div clss="bg-gray-lighter pt-15">
            <label class="lg:w-50 sm:w-50 flex flex-col items-center px-2 py-3
            bg-white-rounded-lg shadow-lg tracking-wide border
            border-blue cursor-pointer">
                <span class="mt-2 text-base leading-normal">
                    Profile Image
                </span>
                {{-- <input type="file" name="image" class="hidden"> --}}
                <input name= "image" class="block w-full cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 focus:outline-none focus:border-transparent text-sm rounded-lg" aria-describedby="user_avatar_help" id="user_avatar" type="file">
            </label>

            @error('image')
            <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
            </p>
            @enderror
        </div>

        <button
            type="submit"
            class=" mt-15 bg-blue-500 text-gray-100 text-lg
            font-extrabold py-4 px-8 rounded-3xl">
            Save Profile
        </button>

    </form>

</main>
@endsection
