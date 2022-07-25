<?php


$GLOBALS['commentDisabled'] = "";
if(!Auth::check())
    $GLOBALS['commentDisabled'] = "disabled";
$GLOBALS['commentClass'] = -1;
$comments2 = \risul\LaravelLikeComment\Controllers\CommentController::getComments($comment_item_id);


?>
<div class="laravelComment pt-4" id="laravelComment-{{ $comment_item_id }}">
    <div class="flex">
        <h3 class="ui dividing header">Comments</h3>
        <h3 class="pl-4 commentnum">{{ $comments2->count() }}</h3>
    </div>
    <div class="ui threaded comments" id="{{ $comment_item_id }}-comment-0">
        <button class="ui basic small submit button" id="write-comment" data-form="#{{ $comment_item_id }}-comment-form">Write comment</button>
        <form class="ui laravelComment-form form" id="{{ $comment_item_id }}-comment-form" data-parent="0" data-item="{{ $comment_item_id }}" style="display: none;">
            <div class="field">
                <textarea id="0-textarea" rows="2" {{ $GLOBALS['commentDisabled'] }}></textarea>
                @if(!Auth::check())
                    <small>Please Log in to comment</small>
                @endif
            </div>
            <input type="submit" class="ui basic small submit button" value="Comment" {{ $GLOBALS['commentDisabled'] }}>
        </form>
<?php

$GLOBALS['commentVisit'] = array();

function dfs($comments, $comment){
    $GLOBALS['commentVisit'][$comment->id] = 1;
    $GLOBALS['commentClass']++;


?>

    <div class="comment show-{{ $comment->item_id }}-{{ (int)($GLOBALS['commentClass'] / 5) }}" id="comment-{{ $comment->id }}">
        <a class="avatar">
            <img src="{{ $comment->avatar }}">
        </a>
        <div class="content">
            <a class="author" url="{{ $comment->url or '' }}"> {{ $comment->name }} </a>
            <div class="metadata">
                <span class="date">{{ $comment->updated_at->diffForHumans() }}</span>
            </div>
            <div class="text">
                {{ $comment->comment }}
            </div>
            <div class="actions">
                <input type="hidden" class="{{ $comment->id }}-hiddenid" value="{{ $comment->id }}">
                <a class="{{ $GLOBALS['commentDisabled'] }} reply reply-button" data-toggle="{{ $comment->id }}-reply-form">Reply</a>
                <?php
                 $users_id = App\Http\Controllers\CommentController::postUser($comment->item_id);

                 ?>
                @if (auth()->id()==$comment->user_id || auth()->id()== $users_id[0]->user_id)
                    <a  onclick="deleteComment({{ $comment->id }})"> delete</a>
                @endif
                @if (auth()->id()==$comment->user_id)
                <input type="hidden" class="{{ $comment->id }}-hiddencomment" value="{{ $comment->comment }}">
                    <a class="{{ $comment->id }}-editComment" onclick="editComment({{ $comment->id }})" > Edit</a>
                @endif
            </div>
            {{-- {{ \risul\LaravelLikeComment\Controllers\CommentController::viewLike('comment-'.$comment->id) }} --}}
            <likes :like_item_id="'comment-'+{{ $comment->id }}" ></likes>
            <form id="{{ $comment->id }}-reply-form" class="ui laravelComment-form form" data-parent="{{ $comment->id }}" data-item="{{ $comment->item_id }}" style="display: none;">
                <div class="field">
                    <textarea id="{{ $comment->id }}-textarea" rows="2" {{ $GLOBALS['commentDisabled'] }}></textarea>
                    @if(!Auth::check())
                        <small>Please Log in to comment</small>
                    @endif
                </div>
                <input type="submit" class="ui basic small submit button" value="Comment" {{ $GLOBALS['commentDisabled'] }}>
            </form>
        </div>
        <div class="comments" id="{{ $comment->item_id }}-comment-{{ $comment->id }}">
<?php

    foreach ($comments as $child) {
        if($child->parent_id == $comment->id && !isset($GLOBALS['commentVisit'][$child->id])){
            dfs($comments, $child);
        }
    }
    echo "</div>";
    echo "</div>";
}


$comments = \risul\LaravelLikeComment\Controllers\CommentController::getComments($comment_item_id);

foreach ($comments as $comment) {
    if(!isset($GLOBALS['commentVisit'][$comment->id])){
        dfs($comments, $comment);
    }
}

?>
    </div>
    <button class="ui basic button" id="showComment" data-show-comment="0" data-item-id="{{ $comment_item_id }}">Show comments</button>
</div>

<script type="application/javascript">
    globalData = null;
    function deleteComment(id){
        //console.log(id);
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: '/laravellikecomment/comment/'+id,
            type: 'DELETE',
            data:{
                _token: token
            },
            success: function(response){
                $("#comment-"+id).remove();
            }
        });
    }

    function editComment(id){
        $.ajax({
                type: "GET",
                url: "/laravellikecomment/fetch/"+id,
                dataType: "json",
                success: function (response) {
                    $.each(response.students, function (key, item) {
                        if(globalData!=null){
                            console.log(globalData);
                            $('#'+id+'-edit').hide();
                        }

                        var comment=item.comment;
                        //  $("#comment-"+id).toggle();
                        var newComment = '<div class="flex items-center" id="'+id+'-edit"><textarea id="'+id+'-edit2" rows="2" ></textarea><input type="submit" onclick="updateComment('+id+')" class="ui basic small submit button" value="update"></div>';
                        $("#comment-"+id).append(newComment);
                        $('#'+id+'-edit2').val(comment);
                        $('.'+id+'-editComment').hide();
                        globalData=id;
                    });
                }
            });

    }
        $(document).mouseup(function(e){
            var container = $('#'+globalData+'-edit');

            // If the target of the click isn't the container
            if(!container.is(e.target) && container.has(e.target).length === 0){
                container.remove();
                $('.'+globalData+'-editComment').show();
            }
        });



        function updateComment(id){

            $.ajax({
                type: "GET",
                url: "/laravellikecomment/fetch/"+id,
                dataType: "json",
                success: function (response) {
                        //console.log(1);
                        var data={
                            'comment': $('#'+id+'-edit2').val(),
                        }
                        var comment2=$('#'+id+'-edit2').val();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                        type: 'PUT',
                        url: '/laravellikecomment/edit/'+id,
                        data: data,
                        datatype: "json",
                        success: function(response2){
                            $.each(response.students, function (key, item) {
                                //console.log(item.comment);
                                var container = $('#'+globalData+'-edit');
                                container.remove();

                                var newComment = '<div class="comment" id="comment-'+id+'" style="display: initial;">\
                                    <input type="hidden" class="'+id+'-hiddencomment" value="'+comment2+'">\
                                    <a class="avatar"><img src="'+item.avatar+'"></a>\
                                    <div class="content">\
                                        <a class="author">'+item.name+'</a>\
                                        <div class="metadata">\
                                            <span class="date">0 second ago</span>\
                                        </div>\
                                        <div class="text">'+comment2+'</div>\
                                        <div class="actions">\
                                            <a class="reply reply-button" data-toggle="'+id+'-reply-form">Reply</a>\
                                            <a  onclick="deleteComment('+id+')"> Delete</a>\
                                            <a class="'+id+'-editComment" onclick="editComment('+id+')" > Edit</a>\
                                        </div>\
                                        <form class="ui laravelComment-form form" id="'+id+'-reply-form" data-parent="'+id+'" data-item="'+item.item_id+'" style="display: none;">\
                                            <div class="field">\
                                                <textarea id="'+id+'-textarea" rows="2"></textarea>\
                                            </div>\
                                            <input type="submit" class="ui basic small submit button" value="Reply">\
                                        </form>\
                                    </div>\
                                    <div class="ui threaded comments" id="'+item.item_id+'-comment-'+id+'"></div>\
                                    </div>';


                                jQuery('#comment-'+id).replaceWith(jQuery(newComment));
                            });
                        }
                    });
                }

            });

        }

</script>

