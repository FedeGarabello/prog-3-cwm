<?php

use GoNetwork\Core\Route;
// POSTS
Route::add('GET','/posts','PostsController@listAll');
Route::add('POST','/newPost','PostsController@createNewPost');
Route::add('GET','/getPostById/{id}','PostsController@getPostById');
Route::add('GET','/postByUser/{id}','PostsController@getPostByOwner');
Route::add('GET','/deletePost/{id}','PostsController@deletePost');
Route::add('POST','/editPost','PostsController@editPostById');

Route::add('GET','/categories','PostsController@getCategories');

Route::add('GET','/comments/{id}','CommentsController@getCommentsByPost');
Route::add('POST','/createComment','CommentsController@createComment');
Route::add('GET','/deleteComment/{id}','CommentsController@deleteComment');

// LOGIN
Route::add('POST','/login','AuthController@login');
Route::add('POST','/logout','AuthController@logout');

// PROFILE
Route::add('GET','/user/{id}','UserController@getUser');
Route::add('GET','/getAllUsers','UserController@getAllUsers');

// REGISTRO
Route::add('POST','/register','UserController@createUser');
Route::add('POST','/register','UserController@empty');
Route::add('POST','/editProfile','UserController@editUser');

// FRIENDS
Route::add('GET','/friends/{id}','FriendController@listFriends');
Route::add('POST','/friends/{id}','FriendController@empty');


