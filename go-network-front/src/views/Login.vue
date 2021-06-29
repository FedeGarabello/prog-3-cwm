<template>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="../assets/images/login.jpg" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper d-flex align-items-center">
                <img src="../assets/images/logo.png" width="100" alt="Logo" id="logo-img">
                <p class="ml-2 orelga mainGrey" id="title-logo">Go | Snow</p>
              </div>

              <p class="login-card-description">Bienvenido, bro.</p>
              <p class="login-card-subtitle">Administrá el sitio acá</p>

              <form action="#" 
                @submit.prevent="login"
              >
                  <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input 
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Ingresá tu Email"
                        v-model="user.email"
                        >
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="***********"
                        v-model="user.password"
                        >
                  </div>
                  <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
                  <router-link class="btn btn-block login-btn mb-4" to="/register">Registrarse</router-link>
                </form>
                <a href="#!" class="forgot-password-link">Olvidaste tu contraseña?</a>
                <p class="login-card-footer-text colorMain">Si no tenes credenciales comunicate con el  <a href="#!" class="text-reset">Administrador</a></p>
                <nav class="login-card-footer-nav">
                  <a href="#!">Somos Go Snow</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import authService from "../services/auth.js";

export default {
    name: 'Login',
        emits: ['logged'],
    data() {
        return {
            user: {
                email: null,
                password: null
            },
            loading: false,
            notification: {
                text: null,
                type: 'success',
            },
        };
    },
    methods: {
        login() {
            this.loading = true;
            authService
                .login(this.user.email, this.user.password)
                .then(response => {
                    this.loading = false;
                    if(response.success) {
                        this.$emit('logged', response.data);
                    }
                });
                setTimeout(() => {
                  this.$router.push('/')
                }, 1000 );
        }
    }
};

</script>

<style lang="scss">

$color-main: #3386AF;
$color-main-darker: #225772;
$main-grey: #353535;
$orelga: 'Orelega One', cursive;

.brand-wrapper{
    margin-bottom: 19px;

    #title-logo {
        padding-top: 10px;
        font-size: 50px;
        font-weight: bolder;
    }
}

.login-card {
    border: 0;
    border-radius: 27.5px;
    box-shadow: 0 10px 30px 0 rgba(172, 168, 168, 0.43);
    overflow: hidden;


    &-img {
        border-radius: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .card-body {
        padding: 85px 60px 60px;

        @media (max-width: 422px) {
            padding: 35px 24px;
        }
    }

    &-description {
        font-size: 25px;
        color: $main-grey;
        font-weight: 700;
        letter-spacing: 1px;
    }

    &-subtitle {
        font-size: 0.85rem;
        letter-spacing: 1px;
        color: $main-grey;
        font-weight: 300;
    }

    form {
        max-width: 326px;
    }

    .form-control {
        border: 1px solid #d5dae2;
        padding: 15px 25px;
        margin-bottom: 20px;
        min-height: 45px;
        font-size: 13px;
        line-height: 15;
        font-weight: normal;

        &::placeholder {
            color: #919aa3;
        }
    }

    .login-btn {
        padding: 13px 20px 12px;
        background-color: $main-grey;
        border-radius: 4px;
        font-size: 17px;
        font-weight: bold;
        line-height: 20px;
        color: #fff;
        margin-bottom: 24px;

        &:hover {
            border: 1px solid #000;
            background-color: transparent;
            color: $main-grey;
        }
    }

    .forgot-password-link {
        font-size: 14px;
        color: #919aa3;
        margin-bottom: 12px;
    }

    &-footer-text {
        font-size: 13px;
        color: $color-main;
        letter-spacing: 1px;
        margin-bottom: 60px;

        @media (max-width: 767px) {
            margin-bottom: 24px;
        }
    }

    &-footer-nav {
        a {
            font-size: 14px;
            color: #919aa3;
        }
    }
}

@media (max-width: 1000px) {
    #logo-img {
        display: none;
    }

    #title-logo {
        margin-left: 0 !important;
    }
}

</style>