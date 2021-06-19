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
        <form class="form-inline my-2 my-lg-0">
          <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
          <button class="btn btn-logout" type="submit">Cerrar Sesión</button>
        </form>
      </div>
    </nav>
    <SideMenu/>
  <router-view/>
</div>

</template>
