<?php

use Illuminate\Support\Facades\Route;
use App\Post;

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

Route::resource('posts', 'PostsController');

Route::get('/contact', 'PostsController@contact');

Route::get('post/{id}/{name}', 'PostsController@showPost');

/*
|--------------------------------------------------------------------------------------------------------------
| DATABASE RAW SQL QUERIES
|--------------------------------------------------------------------------------------------------------------
*/

Route::get('/insert', function () {
    DB::insert('insert into posts(title, body) values(?, ?)', ['PHP with Laravel', 'PHP is good with Laravel']);
});

Route::get('/read', function () {
    $results = DB::select('select * from posts where id = ?', ['1']);

    foreach ($results as $post) {
        return $post->title;
    }
});

Route::get('/update', function () {
    $updated = DB::update('update posts set title = "Updated title" where id = ?', [1]);
    return $updated;
});

Route::get('/delete', function () {
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
    Post::create(['title'=>'This the title, done by the create method', 'body'=>'This is the body, done by the create method']);
});