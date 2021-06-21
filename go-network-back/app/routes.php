<?php
/*
 * Este archivo va a contener TODAS las rutas de
 * nuestra aplicación.
 *
 * Para esto, vamos a crear una clase Route cuya
 * función sea la de registrar y administrar las rutas.
 */
use GoNetwork\Core\Route;

// Registramos la primer ruta! :D
//Route::add('GET', '/', 'HomeController@index');

Route::add('GET','/posts','PostsController@listAll');
Route::add('POST','/newPost','PostsController@createNewPost');
Route::add('GET','/comments/{id}','CommentsController@getCommentsByPost');
