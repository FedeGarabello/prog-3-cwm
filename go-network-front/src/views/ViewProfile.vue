<template>
    <main class="container mt-5">
       <div v-if="!notification.type">
         <form
             action="#"
             @submit.prevent="editProfile">

           <div class="form-group">
             <label for="name">Nombre</label>
             <input
                 type="text"
                 name="name"
                 id="name"
                 class="form-control"
                 v-model="userData.name"
                 placeholder="Ingresá tu Nombre"
             >
           </div>
           <div class="form-group">
             <label for="last_name" >Apellido</label>
             <input
                 type="text"
                 name="last_name"
                 id="last_name"
                 class="form-control"
                 v-model="userData.last_name"
                 placeholder="Ingresá tu Apellido"
             >
           </div>
           <div class="form-group">
             <label for="email" >Email</label>
             <input
                 type="email"
                 name="email"
                 id="email"
                 class="form-control"
                 v-model="userData.email"
                 placeholder="Ingresá tu Email"
             >
           </div>

           <div class="form-group">
             <label for="gender_id" >Género</label>
             <input
                 type="text"
                 name="gender_id"
                 id="gender_id"
                 class="form-control"
                 v-model="userData.gender_id"
                 placeholder="Ingresá tu Género"
             >
           </div>
           <div class="mt-2">
             <p class="mt-1">Fecha de Nacimiento: {{userData.birth_date}}</p>
             <p class="mt-1">Miembro desde: {{userData.created_at}}</p>
           </div>
           <input name="editProfile" id="editProfile" class="btn btn-block login-btn mb-4" type="submit" value="Editar Perfil">

         </form>




         <h4 class="mainGrey font-weight-bold mt-5">Tus posts:</h4>
         <div class="container mt-5"
         v-if="posts.length > 0">
           <div class="row">
             <div class="col-4 postContainer text-center" v-for="post in posts" :key="post.id">
               <div class="container" >
                 <img :src="imgPath +'/'+post.post_pic" alt="Imagen del post" width="250">
                 <p class="mt-2">{{post.title}}</p>
               </div>
             </div>
           </div>
         </div>
         <p v-else> Aún no has creado POST</p>

      </div>


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
    
    </main>
</template>


<script>
import { apiFetch } from "@/api/fetch";
import {API_IMAGES} from "../env/env";
import CheckSuccess from "@/components/CheckSuccess";
import CheckError from "@/components/CheckError";


export default {
    name: 'ViewProfile',
    components: {
      CheckSuccess,
      CheckError
    },
    data: function () {
      return {
        imgPath: API_IMAGES,
        userData: [],
        posts: [],
        notification: {
          msg: null,
          type: null,
        },
      };
    },

    methods: {
      editProfile() {
        //this.loading = true;
        apiFetch("editProfile",{
          method: 'POST',
          body: JSON.stringify(this.userData)
        })
            .then(res => {
              console.log(res);
              if(res.success) {

                this.notification.type = res.success;
                this.notification.msg = res.msg;

                setTimeout(() => {
                  this.notification.type = null;
                  this.$router.push('/profile');
                }, 3000 );

              }

            });
      },
      getUser(){
        let getUser = JSON.parse(localStorage.getItem('userData'));
        return getUser.id
      },

      getAllPostByUser(){
        let id = this.getUser();
          apiFetch(`postByUser/${id}`)
            .then((res) => {
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

.login-btn {
  padding: 13px 20px 12px;
  background-color: #353535 !important;
  border-radius: 4px;
  font-size: 17px;
  font-weight: bold;
  line-height: 20px;
  color: #fff !important;
  margin-bottom: 24px;

  &:hover {
    border: 1px solid #000;
    background-color: transparent !important;
    color: #353535 !important;
  }
}


</style>