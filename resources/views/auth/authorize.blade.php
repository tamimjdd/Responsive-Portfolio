@extends('layouts.app')

@section('head')
    <meta http-equiv="refresh" content="15">
@stop

@section('content')
    <div class="container content-center">
        <div class="authorize_holder">
            <div class="authorize__holder--section">
                <div class="text-lg  pl-10">
                    <h3>Authorize New Device</h3>

                    <p>It looks like you're signing in to <a href="{{ url('/') }}">{{ url('/') }}</a> from a computer or device we haven't seen before, or for some time.</p>
                    <p>
                        This is a process that protects the security of your account.
                    </p>

                </div>
                <form class="w-50 px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST" action="{{ route('authorize.device') }}">
                    {{ csrf_field() }}

                    <div class="flex flex-wrap">

                        <input id="code" type="code"
                            class="form-input w-full @error('email') border-red-500 @enderror" name="code"
                              autofocus>


                        <button type="submit"
                        class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                            Submit
                        </button>
                    </div>

                 </form>


                <div class="authorize__resend">
                        <form action="{{ route('authorize.resend') }}" method="POST">
                            {{ csrf_field() }}

                            @include('partials.message')

                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Email didn't arrive?</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
