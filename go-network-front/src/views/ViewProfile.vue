<template>
    <main class="container mt-5">
        <div>
            <p>Nombre: {{userData.name}}</p>
            <p>Apellido: {{userData.last_name}}</p>
            <p>Miembro desde: {{userData.created_at}}</p>
            <p>Fecha de Nacimiento: {{userData.birth_date}}</p>
            <p>Genero: {{userData.gender_id}}</p>
            <p>Pais de residencia: {{userData.country_id}}</p>
        </div>
    </main>
</template>


<script>
import { apiFetch } from "@/api/fetch";

export default {
    name: 'ViewProfile',

    data: function () {
      return {
        userData: [],
      };
    },

    methods: {
      getUser(){
        let getUser = JSON.parse(localStorage.getItem('userData'));
        return getUser.id
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
    },
}



</script>