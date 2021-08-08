<template>
    <div>
        ASDASDA
    </div>
</template>


<script>
import { apiFetch } from '../api/fetch'

export default {
    methods: {
        getUser(){
        let getUser = JSON.parse(localStorage.getItem('userData'));
        return getUser.id
      },
    },

    mounted() {
        apiFetch('friends/' + this.getUser())
            .then(res => {
             console.log(res);
        });
    },
}
</script>