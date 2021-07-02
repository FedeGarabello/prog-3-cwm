<template>
  <div class="container mt-5">
    <p class="login-card-description">Bienvenido, bro.</p>
    <p class="login-card-subtitle">Creá tu usuario y comenzá a disfrutar esta red social de Snowboarders!</p>

    <form action="#"
          v-if="!notification.type"
          @submit.prevent="register">

      <div class="form-group">
        <label for="name" class="sr-only">Nombre</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control"
            v-model="user.name"
            placeholder="Ingresá tu Nombre"
        >
      </div>
      <div class="form-group">
        <label for="last_name" class="sr-only">Apellido</label>
        <input
            type="text"
            name="last_name"
            id="last_name"
            class="form-control"
            v-model="user.last_name"
            placeholder="Ingresá tu Apellido"
        >
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">Email</label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            v-model="user.email"
            placeholder="Ingresá tu Email"
        >
      </div>
      <div class="form-group mb-4">
        <label for="password" class="sr-only">Password</label>
        <input
            type="password"
            name="password"
            id="password"
            class="form-control"
            v-model="user.password"
            placeholder="***********"
        >
      </div>

      <div class="form-group">
        <label for="gender_id" class="sr-only">Género</label>
        <select
            name="gender_id"
            id="gender_id"
            class="form-control"
            v-model="user.gender_id">
          <option value="1">Masculino</option>
          <option value="2">Femenino</option>
        </select>

      </div>

      <input name="newUser" id="newUser" class="btn btn-block login-btn mb-4" type="submit" value="Registrarse">

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
</template>


<script>
import { apiFetch } from "@/api/fetch";
import CheckSuccess from "@/components/CheckSuccess";
import CheckError from "@/components/CheckError";

export default {
  name: 'Register',
  components: {
    CheckSuccess,
    CheckError
  },
  data() {
    return {
      user: {
        name: null,
        last_name: null,
        email: null,
        password: null,
        gender_id: null,
        birth_date: null,
        profile_pic: null
      },
      loading: false,
      notification: {
        msg: null,
        type: null,
      },
    };
  },
  methods: {
    register() {
      this.loading = true;

      apiFetch("register",{
        method: 'POST',
        body: JSON.stringify(this.user)
      })
        .then(res => {
          if(res.success) {

            this.notification.type = res.success;
            this.notification.msg = res.msg;
            this.user = {
              name: null,
              last_name: null,
              email: null,
              password: null,
              gender_id: null,
              birth_date: null,
              profile_pic: null
            };

            setTimeout(() => {
              this.$router.push('/login')
            }, 3000 );
          }

        });
    }
  }
};

</script>