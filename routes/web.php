<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthorizeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\FacebookSocialiteController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfilesController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\PostsController::class, 'index']);
//login with google routes
Route::get('/auth/google', [\App\Http\Controllers\Auth\FacebookSocialiteController::class, 'redirectToFB'])->name('autho');
Route::get('/callback/google', [\App\Http\Controllers\Auth\FacebookSocialiteController::class, 'handleCallback']);
//login with google routes ends

Auth::routes();



Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');


// device verification routes
Route::group(['middleware' => ['auth']], function () {
    Route::post('/authorize/device', [
        'name' => 'Authorize Login',
        'as' => 'authorize.device',
        'uses' => '\App\Http\Controllers\Auth\AuthorizeController@verify',
    ]);

    Route::post('/authorize/resend', [
        'name' => 'Authorize',
        'as' => 'authorize.resend',
        'uses' => '\App\Http\Controllers\Auth\AuthorizeController@resend',
    ]);
});
//device verification routes ends

//Email verificaiton routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//Email verification routes ends


//profiles routes

Route::post('/follow/{user}',[\App\Http\Controllers\FollowsController::class, 'store']);

Route::put('/profile/{user}',[\App\Http\Controllers\ProfilesController::class, 'update']);

Route::get('/profile/{user}',[\App\Http\Controllers\ProfilesController::class, 'index']);

Route::get('/profile/{user}/edit',[\App\Http\Controllers\ProfilesController::class, 'edit']);

Route::get('/postall/{id}',[\App\Http\Controllers\ProfilesController::class, 'getPost']);


Route::get('/p/create',[\App\Http\Controllers\PostsController::class, 'create']);

Route::get('/cntpost/{id}',[\App\Http\Controllers\PostsController::class, 'countpost']);

Route::get('/p/{post}',[\App\Http\Controllers\PostsController::class, 'show']);

Route::get('/p/{post}/edit',[\App\Http\Controllers\PostsController::class, 'edit']);

Route::put('/p/{post}',[\App\Http\Controllers\PostsController::class, 'update']);

Route::get('/post/{id}',[\App\Http\Controllers\PostsController::class, 'allphoto']);

Route::delete('/photo/{id}',[\App\Http\Controllers\PostsController::class, 'deletephoto']);

Route::delete('/postd/{id}', [\App\Http\Controllers\PostsController::class, 'delete']);

Route::post('/p',[\App\Http\Controllers\PostsController::class, 'store']);

Route::get('/search',[\App\Http\Controllers\searchController::class, 'search']);

//profiles routes ends

//like comment routes
Route::group(['namespace' => 'risul\LaravelLikeComment\Controllers', 'prefix'=>'laravellikecomment', 'middleware' => 'web'], function (){
	Route::group(['middleware' => 'auth'], function (){
		Route::get('/like/vote', [\App\Http\Controllers\LikeController::class, 'vote']);
		Route::get('/comment/add', [\App\Http\Controllers\CommentController::class, 'add']);
        Route::delete('/comment/{id}', [\App\Http\Controllers\CommentController::class, 'delete']);
        Route::put('/edit/{id}', [\App\Http\Controllers\CommentController::class, 'edit']);
        Route::get('/fetch/{id}', [\App\Http\Controllers\CommentController::class, 'getonecomment']);
        Route::get('/cntcom/{id}', [\App\Http\Controllers\CommentController::class, 'getComments']);
        Route::get('/likes/{id}', [\App\Http\Controllers\LikeController::class, 'getLikeViewData']);
	});
});
//like comment routes ends

//Notification routes
Route::group([ 'middleware' => 'auth' ], function () {
    // ...
    Route::get('/notifications',     [\App\Http\Controllers\FollowsController::class, 'notifications']);
    Route::get('/notifications2',     [\App\Http\Controllers\FollowsController::class, 'notifications2']);

    Route::get('/markAsRead', function(){
        auth()->user()->unreadNotifications->markAsRead();
    });

});
//Notification routes ends
