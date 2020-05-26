<?php

use Illuminate\Support\Facades\Route;
use App\Post;
use App\User;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return "About Page";
});

Route::get('/contact', function () {
    return "Contact Us";
});

Route::get('/admin/post/example', array('as' => 'admin.example', function () {
    $url = route('admin.example');
    return "This url: " . $url;
}));

//Route::get('/post/{id}', 'PostsController@index');

//Route::resource('posts', 'PostsController');

Route::get('/contact', 'PostsController@contact');

Route::get('post/{id}/{name}', 'PostsController@showPost');

/*
|--------------------------------------------------------------------------------------------------------------
| DATABASE RAW SQL QUERIES
|--------------------------------------------------------------------------------------------------------------
*/

Route::get('/insertsql', function () {
    DB::insert('insert into posts(title, body) values(?, ?)', ['PHP with Laravel', 'PHP is good with Laravel']);
});

Route::get('/read', function () {
    $results = DB::select('select * from posts where id = ?', ['1']);

    foreach ($results as $post) {
        return $post->title;
    }
});

Route::get('/updatesql', function () {
    $updated = DB::update('update posts set title = "Updated title" where id = ?', [1]);
    return $updated;
});

Route::get('/deletesql', function () {
    $deleted = DB::delete('delete from posts where id = ?', [1]);
    return $deleted;
});


/*
|--------------------------------------------------------------------------------------------------------------
| ELOQUENT
| ORM - OBJECT RELATIONAL MODEL
|--------------------------------------------------------------------------------------------------------------
*/

Route::get('/find', function () {
    $post = Post::find(2);

    return $post->title;
});

Route::get('/findwhere', function () {
    $posts = Post::where('id', 2)->orderBy('id', 'asc')->take(1)->get();

    return $posts;
});

Route::get('/findmore', function () {
    $posts = Post::findOrFail(1);

    return $posts;
});

Route::get('/easyinsert', function () {
    $post = new Post;

    $post->title = 'New Eloquent Title Insert';
    $post->body = 'New Eloquent Content Insert';

    $post->save();
});

Route::get('/easyinsert2', function () {
    $post = Post::find(4);

    $post->title = 'Title eloquent update';
    $post->body = 'Content eloquent update';

    $post->save();
});

Route::get('/create', function () {
    Post::create(['title' => 'This the title, done by the create method', 'body' => 'This is the body, done by the create method']);
});

Route::get('/update', function () {
    Post::where('id', 2)->where('is_admin', 0)->update(['title' => 'Updated PHP title', 'body' => 'Updated body']);
});

// Delete with delete() method
Route::get('/delete', function () {
    $post = Post::find(3);

    $post->delete();
});

// Delete with destroy() method for multiple
Route::get('/delete2', function () {
    Post::destroy([7, 8]);
});

Route::get('/softdelete', function () {
    Post::find(10)->delete();
});

Route::get('/readsoftdelete', function () {
    $post = Post::onlyTrashed()->where('is_admin', '0')->get();

    return $post;
});

Route::get('/restore', function () {
    Post::withTrashed()->where('is_admin', 0)->restore();
});

Route::get('forcedelete', function () {
    Post::onlyTrashed()->where('is_admin', 0)->forceDelete();
});


/*
|--------------------------------------------------------------------------------------------------------------
| ELOQUENT
| RELATIONSHIPS
|--------------------------------------------------------------------------------------------------------------
*/

// ONE TO ONE RELATIONSHIP
Route::get('/user/{id}/post', function ($id) {
    return User::find($id)->post;
});

// *** Having an error over here, needs fix. ***
Route::get('/post/{id}/user', function ($id) {
    return Post::find($id)->user->name;
});

// ONE TO MANY RELATIONSHIP
Route::get('/posts', function () {
    $user = User::find(1);

    foreach ($user->posts as $post) {
        echo $post->title . "<br>";
    }
});

// MANY TO MANY RELATIONSHIP
Route::get('/user/{id}/role', function ($id) {
    $user = User::find($id)->roles()->orderBy('id', 'asc')->get();
    return $user;

//    foreach ($user->roles as $role) {
//        return $role->name;
//    }
});