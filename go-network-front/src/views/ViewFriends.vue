<template>
    <main class="container">
        <h4 class="mainGrey font-weight-bold mt-5">Tus contactos:</h4>
         <div class="container mt-5"
         v-if="friends.length > 0">

           <div class="row">
             <div class="col-4 postContainer text-center" v-for="friend in friends" :key="friend.id">
               <div class="container" >
                 <p class="mt-2">{{friend.name + ' ' + friend.last_name}}</p>
               </div>
             </div>
           </div>
         </div>
         <p v-else> Aún no has agregado ningún contacto</p>
    </main>
</template>


<script>
import { apiFetch } from '../api/fetch'

export default {

    data: function () {
      return {
        friends: [
        ],
      };
    },

    methods: {
        getUser(){
        let getUser = JSON.parse(localStorage.getItem('userData'));
        return getUser.id
      },
    },

    mounted() {
        apiFetch('friends/' + this.getUser())
            .then(res => {
             this.friends = res;
        });
    },
}
</script>