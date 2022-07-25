@extends('layouts.app')

@section('content')

<main class="py-4">
    <div class="container">
        <div class="lg:flex lg:flex-row md:flex md:flex-row" >
            <div class="p-5 " >

                {{-- <img src="{{$user->profile->profileImage()}}" class="rounded-circle w-100"> --}}
                <img src="{{ $user->profile->profileImage()}}" class="rounded-circle w-44">

            </div>
            <div class="p-5 ">
                <div >
                    <div >
                        <div class="flex justify-between items-baseline">
                            <h1 class="text-4xl bold">{{$user->username}}</h1>
                            <follow-button user-id="{{ $user->id }}" follows={{ $follows }}></follow-button>
                            @can('update',$user->profile)
                                <a href="/p/create" class="ml-4">Add New Post</a>
                            @endcan



                        </div >

                        {{-- <follow-button user-id="{{$user->id}}" follows="{{$follows}}"></follow-button> --}}
                    </div>
                    @can('update',$user->profile)
                    <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
                    @endcan

                    {{-- @can('update',$user->profile)
                        <a href="#">Add New Post</a>
                    @endcan --}}

                </div>
                @can('update',$user->profile)
                    {{-- <a href="/profile/{{$user->id}}/edit">Edit Profile</a> --}}
                @endcan
                <div class="d-flex pt-3">

                    <div class="pr-5"><strong id="postcnt2">{{ $postCount }}</strong> posts</div>
                    <input type="hidden" id="postcnt" value="{{ $postCount }}">
                    <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                    <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
                </div>
                <br>
                <div class="pt-4 font-bold">{{$user->profile->title ?? 'nothing'}}</div>
                <div>
                    <h1>{{$user->profile->description ?? 'nothing'}}</h1>

                </div>
                <div><a href="#">{{$user->profile->url ?? 'N/A'}}</a></div>
            </div>
        </div>
        <hr>
        <input type="hidden" class="hiddenid" value="{{ $user->id }}">
        <div class="inline-grid grid-cols-3 gap-4  posts_all">


            {{-- @foreach($user->posts as $post)
                <div class="pt-4 relative">
                    <div class="absolute">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-edit"></i>
                            Edit
                          </button>
                          <button class="bg-red-700 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="far fa-trash-alt"></i>
                            Delete
                          </button>
                    </div>
                    <a href="/p/{{$post->id}}">
                        <img src="{{ asset('images/' . $post->thumbnail) }}" class="w-4/5">
                        <div class="h4">{{$post->title}}</div >
                    </a>
                </div>
            @endforeach --}}

        </div>


        <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Student Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Confirm to Delete Data ?</h4>
                        <input type="hidden" id="deleteing_id">
                    </div>
                    <div class="modal-footer">
                        <button class="bg-red-700 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full delete_student">
                            Confirm
                          </button><button data-bs-dismiss="modal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            Cancel
                          </button>

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
@section('scripts')
<script type="application/javascript">
$(document).ready(function () {
    new FroalaEditor('#forala');
        fetchstudent();

        function fetchstudent() {
           var id=$('.hiddenid').val();
           var id2=$('.hiddenauth').val();

            $.ajax({
                type: "GET",
                url: "/postall/"+id,
                dataType: "json",
                success: function (response) {
                    $('.posts_all').html("");
                    $.each(response.students, function (key, item) {

                        $('.posts_all').prepend(
                    '<div class="pt-4 relative transition transform hover:-translate-y-1 motion-reduce:transition-none motion-reduce:transform-none" id="'+item.id+'-post">\
                        <div class="absolute">\
                            @can('update',$user->profile)\
                            <a href="/p/'+item.id+'/edit">\
                                <button class="bg-blue-500 hover:bg-blue-700 text-white hidden md:block\
                                 font-bold py-2 px-4 rounded" >\
                                    <i class="fas fa-edit"></i>\
                                    Edit\
                                </button>\
                                <i class="fas fa-edit md:hidden bg-blue-500"></i>\
                            </a>\
                          <button value="'+item.id+'" class="bg-red-700 hover:bg-blue-700 hidden md:block\
                           text-white font-bold py-2 px-4 rounded deletebtn"\
                            >\
                            <i class="far fa-trash-alt"></i>\
                            Delete\
                          </button>\
                          <button class="deletebtn md:hidden" value="'+item.id+'">\
                            <i class="far fa-trash-alt  bg-red-700 " ></i>\
                          </button>\
                          @endcan\
                    </div>\
                    <a href="/p/'+item.id+'">\
                        <img src="/images/'+item.thumbnail+'" class="w-4/5\
                        hover:border-t-4 hover:border-r-4 hover:border-l-4 rounded-md border-indigo-500">\
                        <div class="h4 line-clamp-1">'+item.title+'</div >\
                    </a>\
                </div>');
                    });
                }
            });
        }

        $(document).on('click', '.deletebtn', function () {
            var stud_id = $(this).val();

            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(stud_id);


        });

        $(document).on('click', '.delete_student', function (e) {

           var posts;
           var id=$('.hiddenid').val();
            $.ajax({
                type: "GET",
                url: "/cntpost/"+id,
                dataType: "json",
                success: function (response) {
                    posts=response.students;
                    $('.delete_student').text('Deleting..');
                    var id = $('#deleteing_id').val();
                    console.log(posts);
                    posts--;
                    $('#postcnt2').text(posts);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "DELETE",
                        url: "/postd/" + id,
                        dataType: "json",
                        success: function (response) {
                            // console.log(response);
                            $('#DeleteModal').modal('hide');
                            $('.delete_student').text('Confirm');
                            $('#postcnt2').text(posts);

                            $('#'+id+'-post').remove();
                        }
                    });

                }
            });


        });


    });

</script>

@endsection
