<?php

use App\Http\Controllers\PostsController;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Image;
use App\Models\Phone;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
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
//    DB::insert('INSERT INTO users (name, email, password, country_id) VALUES (?, ?, ?, ?)', ['veronika', 'niky@gmail.com', bcrypt('1234'), 1]);
//    DB::insert('INSERT INTO roles (name) VALUES (?)', ['administrator']);
//    DB::insert('INSERT INTO roles (name) VALUES (?)', ['subscriber']);
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
Route::get('/insOnetoone/{id}/{num}', function ($id, $num) {
   $user = User::findOrFail($id);
   $phone = new Phone(['number' => $num]);
   $user->phone()->save($phone);
   return 'done';
});

Route::get('/selOnetoone/{id}', function ($id) {
    $user = User::findOrFail($id);
    return $user->phone;
//    return $user->phone->number;
});

Route::get('/updOnetoone/{id}', function ($id) {
    $user = User::findOrFail($id);
    $user->phone->number = "010-1234-5679";
    if ($user->phone->save()) {
        return 'upd ok';
    }
    return 'no act';
//    $phone = Phone::whereUserId(1)->first();
//    $phone->number = "010-1234-5678";
//    $phone->save();
});

Route::get('/delOnetoone/{id}', function ($id) {
   $user = User::findOrFail($id);
//   return $user->phone;
   if ($user->phone()->delete()) {
       // $user->phone->delete() 는 관계(hasone) 설정된 한 개만 삭제됨
       // $user->phone()->delete() 는 해당 아이디를 갖는 모든 phone 이 삭제됨
       return 'done';
   }
   return 'err';
});

Route::get('/insOnetomany', function () {
    $country = Country::findOrFail(1);
    $user = new User(['name' => 'veronika', 'email' => 'niky@gmail.com', 'password' => bcrypt('1234')]);
    if ($country->user()->save($user)) {
        return 'ins ok';
    }
    return 'err';
});

Route::get('/selOnetomany/{id}', function ($id) {
    $country = Country::findOrFail($id);
    if (count($country->user) > 0) {
        foreach ($country->user as $user) {
            echo $user->name . '<br />';
        }
    }
//    $user = User::findOrFail(1);
//    return $user->phone->number;
});

Route::get('/updOnetomany/{id}/{uid}', function ($id, $uid) {
    $country = Country::findOrFail($id);
    $user = $country->user()->whereId($uid)->first();
//    if ($user->update(['email' => 'niky@gmail3.com'])) return 'upd ok';
    $user->email = "niky@gmail.com";
    if ($user->save()) return 'upd ok';
    return 'err';
});

Route::get('/delOnetomany/{id}/{uid}', function ($id, $uid) {
   $country = Country::findOrFail($id);
//   $country->user()->delete();
   $user = $country->user()->where('id', '=', $uid)->first();
   if ($user->delete()) return 'del ok';
   return 'err';
});


Route::get('/insManytomany/{id}', function ($id) {
    $user = User::findOrFail($id);
    $role = new Role(['name' => 'subscriber']);
    if ($user->role()->save($role)) return 'ins ok';
    else return 'fail';
});

Route::get('/selManytomany/{id}', function ($id) {
    $user = User::findOrFail($id);
    $roles = $user->role()->get();
    foreach ($roles as $role) {
        echo $role->name . '<br />';
    }
//    return $role->name;
});

Route::get('/updManytomany/{uid}/{rid}', function ($uid, $rid) {
    $user = User::findOrFail($uid);
    $role = $user->role()->where('roles.id', '=', $rid)->first();
    $role->name = 'manager';
    if ($role->save()) return 'upd ok';
    return 'fail';
});

Route::get('/delManytomany/{uid}', function ($uid) {
    $user = User::findOrFail($uid);
    foreach ($user->role as $role) {
        if ($role->name == 'student') {
            $role->delete();    // role_user 로우 까지는 삭제되지 않는다.
        }
//        echo $role . '<br />';
//        echo $role->name . '<br />';
    }
});

Route::get('/attach/{uid}/{rid}', function ($uid, $rid) {
    $user = User::findOrFail($uid);
    $user->role()->attach($rid);
});

Route::get('/detach/{uid}/{rid}', function ($uid, $rid) {
    $user = User::findOrFail($uid);
    $user->role()->detach($rid);
});

Route::get('/sync/{uid}', function ($uid) {
   $user = User::findOrFail($uid);
   $user->role()->sync([1,2]);  // 주어진 배열에 포함되어 있지 않는 ID는 중간 테이블에서 제거되고 배열에 포함된 ID들만 중간 테이블에 남는다.
});


Route::get('/insOnetomany2/{id}', function ($id) {
    $user = User::findOrFail($id);
    $post = new Post(['title' => 'third title', 'content' => 'This is a Third sentence']);
    if ($user->post()->save($post)) {
        return 'ins ok';
    }
    return 'fail';
});

Route::get('/insMorphone/{id}/{type}', function ($id, $type) {
    if ($type == 'user') $obj = User::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
//    $user->image()->create(['path' => '/img/face.jpg']);
    $img = new Image(['path' => '/img/photo4.png']);
    if ($obj->image()->save($img)) return 'ins ok';
    return 'fail';
});

Route::get('/selMorphone/{id}/{type}', function ($id, $type) {
   if ($type == 'user') $obj = User::findOrFail($id);
   elseif ($type == 'post') $obj = Post::findOrFail($id);
   foreach ($obj->image()->get() as $img) {
       return $img->path;
   }
//   return $obj->image()->get();
});

Route::get('/updMorphone/{id}/{type}', function ($id, $type) {
    if ($type == 'user') $obj = User::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
    $row = $obj->image()->where('id', '=', 1)->first();
    $row->path = '/img/changedFace.jpg';
    if ($row->save()) return 'upd ok';
    return $row;
});

Route::get('/delMorphone/{id}/{type}', function ($id, $type) {
    if ($type == 'user') $obj = User::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
    $img = $obj->image()->where('images.path', 'like', '%photo%')->first();
    if ($img->delete()) return 'del ok';
    return 'fail';
});

Route::get('/insMorphmany/{id}/{type}', function ($id, $type) {
    if ($type == 'post') $obj = Post::findOrFail($id);
    elseif ($type == 'video') $obj = Video::findOrFail($id);
    $cmnt = new Comment(['body' => 'this comment id first']);
    if ($obj->comment()->save($cmnt)) return 'ins ok';
    return 'fail';
});

/*
Route::get('/insMorphmany2', function () {
//   $video = Video::create(['name' => 'hungger game.avi']);
   $video = new Video(['name' => 'hungger game3.avi']);
   $video->save();
});
*/

Route::get('/selMorphmany/{id}/{type}', function ($id, $type) {
    if ($type == 'video') $obj = Video::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
    foreach ($obj->comment()->get() as $comment) {
        echo $comment->body . '<br />';
    }
});

Route::get('/updMorphmany/{id}/{type}', function ($id, $type) {
    if ($type == 'video') $obj = Video::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
    $comment = $obj->comment()->where('comments.id', '=', 1)->first();
    $comment->body = '한글 댓글로 업데이트 함...';
    if ($comment->save()) return 'upd ok';
    return 'fail';
});

Route::get('/delMorphmany/{id}/{type}', function ($id, $type) {
    if ($type == 'video') $obj = Video::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
    $comment = $obj->comment()->whereId(2)->first();
    if ($comment->delete()) return 'del ok';
    return $comment;
});

Route::get('/insMorphtomany/{id}/{type}', function ($id, $type) {
    if ($type == 'post') $obj = Post::findOrFail($id);
    elseif ($type == 'video') $obj = Video::findOrFail($id);
    $tag = new Tag(['name' => 'video tagging ...']);
    if ($obj->tag()->save($tag)) return 'ins ok';
    return 'fail';
});

Route::get('/selMorphtomany/{id}/{type}', function ($id, $type) {
    if ($type == 'video') $obj = Video::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
    foreach ($obj->tag()->get() as $tag) {
        echo $tag->name . '<br />';
    }
});

Route::get('/updMorphtomany/{id}/{type}', function ($id, $type) {
    if ($type == 'video') $obj = Video::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
    $tag = $obj->tag()->where('tags.id', '=', 1)->first();
    $tag->name = '태그 데이터';
    if ($tag->save()) return 'upd ok';
    return 'fail';
});

Route::get('/delMorphtomany/{id}/{type}', function ($id, $type) {
    if ($type == 'video') $obj = Video::findOrFail($id);
    elseif ($type == 'post') $obj = Post::findOrFail($id);
    $tag = $obj->tag()->where('name', 'like', '%video%')->get();
    foreach ($tag as $tg) {
        echo $tg->name;
        if ($tg->delete()) echo ' deleted!!<br />';     // tag 데이터는 삭제되는데 taggable 데이터는 남아있다...
        else echo ' fail<br />';
    }
});

