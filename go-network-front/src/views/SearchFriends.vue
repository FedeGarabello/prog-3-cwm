<template>
    <main class="container ">
        <h4 class="mainGrey font-weight-bold mt-5">Buscar contactos:</h4>

          <div class="wrapper">
          <div class="label">Ingresá el nombre, apellido o email a buscar</div>
          <div class="searchBar">
            <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Buscar" v-model="search"/>
            <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
              </svg>
            </button>
          </div>
        </div>

        <div class="container mt-4 d-flex flex-wrap">
            <div class="col-md-4 mt-4" v-for="contacts in filterdContact" :key="contacts.id">
              <div class="card profile-card-5">
                <div class="card-img-block">
                  <img class="card-img-top" src="https://images.unsplash.com/photo-1517832207067-4db24a2ae47c" alt="Card image cap">
                </div>
                <div class="card-body pt-0">
                  <h5 class="card-title">{{contacts.name + ' ' + contacts.last_name}}</h5>
                  <p class="card-text"><span class="font-weight-bold">Email:</span> {{contacts.email}}</p>
                  <div class="d-flex justify-content-around align-items-center">
                    <a href="#" class="btn btn-primary">Ver Post de este usuario</a>
                    <i class="fas fa-user-plus add-friend"></i>
                  </div>
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