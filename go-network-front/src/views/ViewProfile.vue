<template>
    <main class="container mt-5">
        <div class="mt-5">
            <h2 class="mainGrey font-weight-bold">{{userData.name}}  {{userData.last_name}}</h2>
            <p class="mt-4">Miembro desde: {{userData.created_at}}</p>
            <p class="mt-4">Fecha de Nacimiento: {{userData.birth_date}}</p>
            <p class="mt-4">Genero: {{userData.gender_id == 1 ? 'Masculino' : 'Femenino'}}</p>
        </div>

        <h4 class="mainGrey font-weight-bold mt-5">Tus posts:</h4>
        <div class="container mt-5">
            <div class="row">
                <div class="col-4 postContainer text-center" v-for="post in posts" :key="post.id">
                    <div class="container" >
                        <img :src="imgPath +'/'+post.post_pic" alt="Imagen del post" width="250">
                        <p class="mt-2">{{post.title}}</p>
                    </div>
                </div>
            </div>
        </div>
    
    </main>
</template>


<script>
import { apiFetch } from "@/api/fetch";
import {API_IMAGES} from "../env/env";

export default {
    name: 'ViewProfile',

    data: function () {
      return {
        imgPath: API_IMAGES,
        userData: [],
        posts: [],
      };
    },

    methods: {
      getUser(){
        let getUser = JSON.parse(localStorage.getItem('userData'));
        return getUser.id
      },

      getAllPostByUser(){
        let id = this.getUser();
          apiFetch(`postByUser/${id}`)
            .then((res) => {
              console.log(res);
              this.posts = res;
          })
      },

      loadUser(){
        let id = this.getUser();
          apiFetch(`user/${id}`)
            .then((res) => {
              this.userData = res;
          })
      }
    },
    mounted() {
      this.loadUser();
      this.getAllPostByUser();
    },
}
</script>

<style lang="scss">
img {
  border-radius: 15px;
}

.postContainer{
  margin: 20px 15px;
  border-radius: 20px;
  background: #ffffff;
  box-shadow:  32px 32px 63px #d9d9d9,
              -32px -32px 63px #ffffff;
}

.row {
  justify-content: space-around !important;
}



</style>