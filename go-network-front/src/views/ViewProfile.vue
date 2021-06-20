<template>
    <main class="container mt-5">
        <div>
            <p>Nombre:</p>
            <p>Apellido:</p>
            <p>Miembro desde:</p>
            <p>Fecha de Nacimiento:</p>
            <p>Genero:</p>
            <p>Pais de residencia:</p>
        </div>
    </main>
</template>


<script>
import { apiFetch } from "@/api/fetch";

export default {
    name: 'ViewProfile',
    components: {

    },
    data: function () {
    return {
      posts: [],
    };
  },
  mounted() {
    apiFetch("posts").then((res) => {
      console.log(res);
      this.posts = res;
    });
  },
}



</script>