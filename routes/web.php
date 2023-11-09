<?php

use App\Http\Controllers\PostsController;
use App\Models\Country;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

/**
 * DB query
 */
Route::get('/insBsc', function () {
    DB::insert('INSERT INTO countries (name) VALUES (?)', ['germany']);
    DB::insert('INSERT INTO users (name, email, password, country_id) VALUES (?, ?, ?, ?)', ['veronika', 'niky@gmail.com', bcrypt('1234'), 1]);
    DB::insert('INSERT INTO roles (name) VALUES (?)', ['administrator']);
    DB::insert('INSERT INTO roles (name) VALUES (?)', ['subscriber']);
    return 'done';
});

Route::get('/selBsc', function () {
   $rs = DB::select('SELECT * FROM roles WHERE id=?', [1]);
   return $rs;
});

Route::get('updBsc', function () {
   $updated = DB::update('UPDATE roles SET name=? WHERE id=?', ['student', 2]);
   return $updated;
//   return 'done';
});

Route::get('delBsc', function () {
   $deleted = DB::delete('DELETE FROM roles WHERE id=?', [2]);
   return $deleted;
//   return 'done';
});

/**
 * Relations
 */
Route::get('/insOnetoone', function () {
   $user = User::findOrFail(1);
   $phone = new Phone(['number' => '010-1234-1234']);
   $user->phone()->save($phone);
   return 'done';
});

Route::get('/updOnetoone', function () {
   $phone = Phone::whereUserId(1)->first();
//   return $phone;
   $phone->number = "010-1234-5678";
   $phone->save();
});

Route::get('/selOnetoone', function () {
    $user = User::findOrFail(1);
    return $user->phone->number;
});

Route::get('/delOnetoone', function () {
   $user = User::findOrFail(1);
   if ($user->phone()->delete()) {
       return 'done';
   }
   return 'err';
});

Route::get('/insOnetomany', function () {
    $country = Country::findOrFail(1);
    $user = new User(['name' => 'nana', 'email' => 'nana@naver.com', 'password' => bcrypt('1234')]);
    if ($country->user()->save($user)) {
        return 'ins ok';
    }
    return 'err';
});

Route::get('/updOnetomany/{id}', function ($id) {
    $country = Country::findOrFail(1);
    $user = $country->user()->whereId($id)->first();
    $user->email = "niky@daum.net";
    if ($user->save()) {
        return 'upd ok';
    }
    return 'err';
});


