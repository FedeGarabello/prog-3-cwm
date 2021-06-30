<?php

use GoNetwork\Core\Route;

Route::add('GET','/posts','PostsController@listAll');
Route::add('POST','/newPost','PostsController@createNewPost');
Route::add('GET','/getPostById/{id}','PostsController@getPostById');
Route::add('GET','/deletePost/{id}','PostsController@deletePost');

Route::add('GET','/categories','PostsController@getCategories');

Route::add('GET','/comments/{id}','CommentsController@getCommentsByPost');

Route::add('POST','/login','AuthController@login');
Route::add('POST','/logout','AuthController@logout');

Route::add('GET','/user/{id}','UserController@getUser');
Route::add('POST','/register','UserController@createUser');
