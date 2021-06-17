<template>
    <main class="container">

      



      <NewPost/>
    </main>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'

import NewPost from "@/components/NewPost.vue";

export default {
  name: 'Home',
  components: {
    NewPost
  }
}
</script>
