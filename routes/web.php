<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/insert', function(){
    DB::insert('insert into posts(title, body) values(?, ?)', ['PHP with Laravel', 'PHP is good with Laravel']);
});

//Route::get('/post/{id}', 'PostsController@index');

Route::resource('posts', 'PostsController');

Route::get('/contact', 'PostsController@contact');

Route::get('post/{id}/{name}', 'PostsController@showPost');