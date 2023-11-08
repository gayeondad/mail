<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
//    $data = [
//        'title' => 'Hi, I hope you like this title',
//        'content' => 'This mail is test mail'
//    ];
//
//    Mail::send('email.test', $data, function ($message) {
//        $message->to('niky@gmail.com', 'Veronika')->subject('Hello nana');
//    });


});

//Route::get('/post', [PostsController::class, 'index']);

Route::resource('posts', PostsController::class);

Route::get('/contact', function () {
    return view('contact');
});
