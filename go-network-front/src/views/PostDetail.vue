<template>
    <main>
      <div class="container w-75 mt-5">
        <h2>Editar Post</h2>
      <form
          v-if="!notification.type"
          @submit.prevent="editpost"
          action="#">
        <div class="form-group">
          <label for="title">Título</label>
          <input type="text" class="form-control" id="title" placeholder="Título" v-model="post.title" :aria-describedby="errors.title !== null ? 'errors-title' : null">
          <div
              v-if="errors.title !== null"
              id="errors-title"
              class="text-danger"
          >{{ errors.title }}</div>
        </div>
        <div class="form-group">
          <label for="content">Contenido</label>
          <textarea class="form-control" id="content" rows="3" v-model="post.content" :aria-describedby="errors.content !== null ? 'errors-content' : null"></textarea>
          <div
              v-if="errors.content !== null"
              id="errors-content"
              class="text-danger"
          >{{ errors.content }}</div>
        </div>
        <div class="form-group">
          <label for="category">Categoría</label>
          <select class="form-control" id="category" v-model="post.category_id" :aria-describedby="errors.category_id !== null ? 'errors-category_id' : null">
            <option
                v-for="category in categories"
                :value="category.id"
                :key="category.id"
            >{{ category.name }}</option>
          </select>
          <div
              v-if="errors.category_id !== null"
              id="errors-category_id"
              class="text-danger"
          >{{ errors.category_id }}</div>
        </div>

        <div class="custom-file mt-4">
          <input type="file" class="custom-file-input" id="post_pic" ref="post_pic" @change="loadPic">
          <label class="custom-file-label" for="post_pic" data-browse="Buscar">Eliga una imagen</label>
        </div>

        <div class="text-center mt-5"
            v-if="post.post_pic !== null">
          <p>Previsualizacion de la portada</p>
          <img
              class="imgPreview"
              :src="imgPath+'/'+post.post_pic"
              alt="Imagen de Portada">

        </div>
        <button type="submit" class="btn btn-block login-btn mt-4 ">Editar</button>
      </form>


      <CheckSuccess
          v-if="notification.type !== null & notification.type"
          :msg="notification.msg"
          class="checkNotific">
      </CheckSuccess>

      <CheckError
          v-if="notification.type !== null & !notification.type"
          :msg="notification.msg"
          class="checkNotific">
      </CheckError>
      </div>
    </main>
</template>

<script>
import { apiFetch } from '../api/fetch'
import {API_IMAGES} from "../env/env";
import CheckSuccess from "@/components/CheckSuccess";
import CheckError from "@/components/CheckError";


export default {
  name: "PostDetail",
  components: {
    CheckSuccess,
    CheckError
  },
  data () {
    return {
      imgPath: API_IMAGES,
      post: {
        id: null,
        title: null,
        content: null,
        category_id: null,
        post_pic: null,
        owner_id: null
      },
      loading: false,
      notification: {
        type: null,
        msg: null
      },
      errors: {
        title: null,
        content: null,
        category_id: null,
        post_pic: null,
      },
      categories: [],
      brands: []
    };
  },
  methods: {
    validateOwner($id){
      let getUser = JSON.parse(localStorage.getItem('userData'));
      if($id != getUser.id){
        this.$router.push('/');
      }
    },
    loadPic(){
      this.$refs.post_pic.files = null;
      const reader = new FileReader();
      reader.addEventListener('load',()=>{
        this.post.post_pic = reader.result;
      });
      reader.readAsDataURL(this.$refs.post_pic.files[0]);
    },
    validates() {
      let hasErrors = false;

      if(this.post.title == null || this.post.title === ''){
        this.errors.title = 'Por favor, ingrese un Título';
        hasErrors = true;
      } else {
        this.errors.title = null;
        hasErrors = false;
      }
      if(this.post.content == null || this.post.content === ''){
        this.errors.content = 'Por favor, cargue un contenido para el POST';
        hasErrors = true;
      } else {
        this.errors.content = null;
        hasErrors = false;
      }
      if(this.post.category_id == null || this.post.category_id === ''){
        this.errors.category_id = 'Debes ingresar una categoría';
        hasErrors = true;
      } else {
        this.errors.category_id = null;
        hasErrors = false;
      }

      return !hasErrors;
    },
    editpost(){
      // Si no pasa la validación, no realizamos la petición.
      if(!this.validates()) return;

      /**
       * Verifico si hay cargada una imagen
       */

      apiFetch("editPost",{
        method: 'POST',
        body: JSON.stringify(this.post)
      })
          .then(res => {
            if(res.success) {

              this.notification.type = res.success;
              this.notification.msg = res.msg;
              this.post = {
                id: null,
                title: null,
                content: null,
                category_id: null,
                post_pic: null,
              };
              // Direcciono a la lista de los POST
              setTimeout(() => {
                this.$router.push('/')
              }, 3000 )
              // this.$router.push('/')
            }

          });
    },
  },
  mounted() {
    apiFetch('getPostById/' + this.$route.params.id)
        .then(postData => {
          this.post = postData;
          this.validateOwner(this.post.owner_id);
        });
    /**
     * Traigo las categorias para el formulario de alta.
     */
    apiFetch("categories")
        .then(data => {
          this.categories = data;
        });
  },

}
</script>

