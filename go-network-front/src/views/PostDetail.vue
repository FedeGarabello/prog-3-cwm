<template>
    <main>
        <div>Estoy a adentro </div>
    </main>
</template>

<script>
import { apiFetch } from '../api/fetch'

export default {
    name: "PostDetail",

    mounted() {
        apiFetch('getPostById/' + this.$route.params.id)
            .then(postData => {
                console.log(postData)
                this.post = postData
            })
    },
}
</script>