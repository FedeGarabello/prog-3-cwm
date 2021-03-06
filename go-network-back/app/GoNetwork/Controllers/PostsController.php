<?php

namespace GoNetwork\Controllers;

use GoNetwork\Core\App;
use GoNetwork\Core\Route;
use GoNetwork\Core\View;
use GoNetwork\Models\Categories;
use GoNetwork\Models\Posts;


class PostsController
{
    public function listAll() {
        $posts = (new Posts())->getAllPosts();
        View::renderJson($posts);
    }

    public function getPostById() {
        $id = Route::getUrlParameters()['id'];
        $post = (new Posts())->getPostById($id);
        View::renderJson($post);
    }

    public function editPostById() {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $post = (new Posts())->editPostById($postData);
        View::renderJson($post);
    }

    /**
     * Recibe un objeto POST para insertar
     * @return boolean
     */
    public function createNewPost() {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        if($postData['post_pic'] != null || $postData['post_pic'] != '') {
            $imagenParts = explode(',', $postData['post_pic']);
            $imagenDecoded = base64_decode($imagenParts[1]);
            $imagenNombre =  time(). ".jpg";
            file_put_contents( "./../imgs/" . $imagenNombre, $imagenDecoded);
            $postData['post_pic'] = $imagenNombre;
        }

        $post = (new Posts())->createPost($postData);
        View::renderJson($post);
    }

    public function getCategories() {
        $categories = (new Categories())->getAllCategories();
        View::renderJson($categories);
    }

    public function deletePost() {
        
        $id = Route::getUrlParameters()['id'];
        $posts = (new Posts())->deletePost($id);
        View::renderJson($posts);
    }


    public function getPostByOwner() {
        
        $id = Route::getUrlParameters()['id'];
        $posts = (new Posts())->getAllPostByUser($id);
        View::renderJson($posts);
    }

}