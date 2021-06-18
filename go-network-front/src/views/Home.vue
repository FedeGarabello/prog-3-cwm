<template>
    <main class="container">

      <pre>
        {{ post }}
      </pre>



      <NewPost/>
    </main>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'

import NewPost from "@/components/NewPost.vue";
import {apiFetch} from "@/api/fetch";

export default {
  name: 'Home',
  components: {
    NewPost
  },
  data: function () {
    return {
      post :  [

      ]
    }
  },
  mounted() {
    apiFetch("posts")
    .then(res => {
      console.log(res);
      this.post = res;
    })
  }
}
</script>
