<template>
  <div class="container mt-5">
    <p class="login-card-description">Bienvenido, bro.</p>
    <p class="login-card-subtitle">Creá tu usuario y comenzá a disfrutar esta red social de Snowboarders!</p>

    <form action="#">
      <div class="form-group">
        <label for="name" class="sr-only">Nombre</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control"
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
            placeholder="***********"
        >
      </div>

      <div class="form-group">
        <label for="gender_id" class="sr-only">Genero</label>
        <input
            type="text"
            name="gender_id"
            id="gender_id"
            class="form-control"
            placeholder="Ingresá tu Género"
        >
      </div>
      <div class="form-group">
        <label for="country_id" class="sr-only">País</label>
        <input
            type="text"
            name="country_id"
            id="country_id"
            class="form-control"
            placeholder="Ingresá tu País"
        >
      </div>
      <div class="form-group">
        <label for="country_id" class="sr-only">Imágen</label>
        <input
            type="file"
            name="profile_pic"
            id="profile_pic"
            class="form-control"
            placeholder="Ingresá tu Imágen de Perfil"
        >
      </div>

      <input name="newUser" id="newUser" class="btn btn-block login-btn mb-4" type="submit" value="Registrarse">

    </form>
  </div>
</template>