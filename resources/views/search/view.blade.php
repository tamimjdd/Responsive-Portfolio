@extends('layouts.app')

@section('content')

<div class="sidenav bg-blue-900">
    <a href="#"onclick="showpost()">Post</a>
    <a href="#" onclick="showpeople()">People</a>
  </div>

  <div class="w-1/5"></div>
  <div class="main" id="one">

      <div class="w-4/5">
        @foreach($posts as $post)
        <div class="pt-4">
            <a href="/p/{{$post->id}}">
                <img src="{{ asset('images/' . $post->thumbnail) }}" class="w-4/5">
                <div class="flex pt-4">
                    <img src="{{ $post->user->profile->profileImage()}}" class="w-6 rounded-full lg:w-14" alt="">

                    <div class="text-sm lg:text-2xl">{{$post->title}}</div >
                </div>
            </a>
        </div>
        @endforeach
      </div>
      <div class="w-1/5"></div>

  </div>

  <div class="main" id="two">
    <?php

    $count=1;

    ?>
    <div class="w-4/5">
      @foreach($people as $pep)

      <div class="pt-4">
          <a href="/profile/{{$pep->id}}">
              <div class="flex pt-4">
                  <div>{{ $count }}. </div>
                  <div class="text ">{{$pep->name}}</div >
              </div>

          </a>
      </div>
      <?php

    $count++;

    ?>
      @endforeach
    </div>
    <div class="w-1/5"></div>

</div>


@endsection

<script type="application/javascript">
    function showpost(){
        $("#one").show();
        $("#two").hide();
    }

    function showpeople(){
        $("#one").hide();
        $("#two").show();
    }
</script>
