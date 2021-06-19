<template>
  <div class="container w-75 mt-5">
    <h2>Alta nuevo Post</h2>
    <form
        @submit.prevent=""
        action="#">
      <div class="form-group">
        <label for="title">Título</label>
        <input type="text" class="form-control" id="title" placeholder="Título" v-model="post.title">
      </div>
      <div class="form-group">
        <label for="content">Contenido</label>
        <textarea class="form-control" id="content" rows="3" v-model="post.content"></textarea>
      </div>
      <div class="form-group">
        <label for="category">Categoría</label>
        <select class="form-control" id="category" v-model="post.category_id">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>

      <div class="custom-file mt-4">
        <input type="file" class="custom-file-input" id="post_pic" >
        <label class="custom-file-label" for="post_pic" data-browse="Buscar">Eliga una imagen</label>
      </div>
      <button type="submit" class="btn btn-logout btn-create">Crear</button>
    </form>

  </div>
</template>


<script>
import {apiFetch} from "@/api/fetch";

export default {
  name: "NewPost",
  data () {
    return {
      post: {
        title: null,
        content: null,
        category_id: null,
        post_pic: null,
      },
      loading: false

    };
  },
  methods: {
    createPost(){
      //console.log(this.post)
      apiFetch('newPost',{
        method: 'POST',
        body: JSON.stringify(this.post),
        headers: {
          'Content-Type' : 'application/json'
        }
      })
      .then(response => {
        console.log(response);
      });

    }
  }
}
</script>


<style>
.btn-create{
  margin: 2em auto !important;
  display: block !important;
}
</style>