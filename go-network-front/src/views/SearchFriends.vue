<template>
    <main class="container">
        <h4 class="mainGrey font-weight-bold mt-5">Buscar contactos:</h4>
         <div class="container mt-5"
         v-if="contacts.length > 0">
           <div class="row"  v-for="contact in contacts" :key="contact.id">
             <div class="col-4 postContainer text-center" v-if="contact.id != user">
               <div class="container">
                 <p class="mt-2">{{contact.name + ' ' + contact.last_name}}</p>
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
        user: null,
        contacts: [
        ],
      };
    },

    methods: {
        getUser(){
        let getUser = JSON.parse(localStorage.getItem('userData'));
        this.user = getUser.id
      },
    },

    mounted() {
        this.getUser();

        apiFetch('getAllUsers')
            .then(res => {
              console.log(res)
            this.contacts = res;
        });

        
    },
}
</script>