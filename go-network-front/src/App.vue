<template>
<div class="">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand orelga colorMain" href="#">Go | Snow</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item mt-1">
              <router-link class="nav-link" to="/profile">Mi Perfil</router-link>
          </li>

        </ul>
        <form 
            class="form-inline my-2 my-lg-0"
            v-if="auth.user.id === null"
        >
          <router-link class="btn btn-logout" to="/login">Inicia Sesión</router-link>
        </form>

        <form 
            class="form-inline my-2 my-lg-0"
            v-else
        >
          <a class="btn btn-logout" @click="logout">Cerrá Sesión {{auth.user.email}}</a>
        </form>
      </div>
    </nav>
    <router-view
        @logged="logUser"
    ></router-view>
</div>

</template>

<script>
import authService from "./services/auth.js";

export default {
    data() {
        return {
            auth: {
                user: {
                    id: null,
                    email: null,
                },
            }
        }
    },
    methods: {
        logUser() {
            this.auth.user = authService.getUserData();
        },
        logout() {
            authService.logout();
            this.$router.push('/login')
            this.auth.user = {
                id: null,
                email: null,
            },
            this.$router.push('/login');
        }
    },
    mounted() {
        if(authService.isAuthenticated()) {
            this.auth.user = authService.getUserData();
        }
    }
};

</script>