<template>
    <main class="container ">
        <h4 class="mainGrey font-weight-bold mt-5">Buscar contactos:</h4>
        <input type="text" v-model="search">
        <div class="container mt-4 d-flex flex-wrap">
            <div class="col-md-4 mt-4" v-for="contacts in filterdContact" :key="contacts.id">
              <div class="card profile-card-5">
                <div class="card-img-block">
                  <img class="card-img-top" src="https://images.unsplash.com/photo-1517832207067-4db24a2ae47c" alt="Card image cap">
                </div>
                <div class="card-body pt-0">
                  <h5 class="card-title">{{contacts.name + ' ' + contacts.last_name}}</h5>
                  <p class="card-text"><span class="font-weight-bold">Email:</span> {{contacts.email}}</p>
                  <a href="#" class="btn btn-primary">Ver Post de este usuario</a>
                  <span>Icono de +</span>
                </div>
              </div>

        </div>
        </div>

         <!-- <p v-else> Aún no has agregado ningún contacto</p> -->
    </main>
</template>


<script>
import { apiFetch } from '../api/fetch'
import { stripVowelAccent } from '../services/parser'

export default {

    data: function () {
      return {
        search: '',
        contacts: [
        ],
      };
    },

    methods: {
        getUser(){
        let getUser = JSON.parse(localStorage.getItem('userData'));
        return getUser.id
        },
    },

    computed: {
      filterdContact(){
        return this.contacts.filter(contact => stripVowelAccent(contact.name.toLowerCase()).match(stripVowelAccent(this.search.toLowerCase())) 
               || stripVowelAccent(contact.last_name.toLowerCase()).match(stripVowelAccent(this.search.toLowerCase()))
               || stripVowelAccent(contact.email.toLowerCase()).match(stripVowelAccent(this.search.toLowerCase())))
               
      }
    },

    mounted() {
      
        apiFetch('getAllUsers/' + this.getUser())
            .then(res => {
              console.log(res)
            this.contacts = res;
        });

        
    },
}
</script>