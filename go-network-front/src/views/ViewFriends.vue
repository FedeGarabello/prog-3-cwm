<template>
    <main class="container">
        <h4 class="mainGrey font-weight-bold mt-5">Tus contactos:</h4>

         <div class="container mt-4 d-flex"
         v-if="friends.length > 0">

           <div class="col-md-4 mt-4" v-for="friend in friends" :key="friend.id">
             <div class="card profile-card-5">
               <div class="card-img-block">
                 <img class="card-img-top" src="https://images.unsplash.com/photo-1517832207067-4db24a2ae47c" alt="Card image cap">
               </div>
               <div class="card-body pt-0">
                 <h5 class="card-title">{{friend.name + ' ' + friend.last_name}}</h5>
                 <p class="card-text"><span class="font-weight-bold">Email:</span> {{friend.email}}</p>
                 <a href="#" class="btn btn-primary">Ver Post de este usuario</a>
               </div>
             </div>
           </div>


<!--           <div class="row">
             <div class="col-4 postContainer text-center" v-for="friend in friends" :key="friend.id">
               <div class="container" >
                 <p class="mt-2">{{friend.name + ' ' + friend.last_name}}</p>
               </div>
             </div>
           </div>-->
         </div>
         <p v-else> Aún no has agregado ningún contacto</p>
    </main>
</template>


<script>
import { apiFetch } from '../api/fetch'

export default {

    data: function () {
      return {
        friends: [
        ],
      };
    },

    methods: {
        getUser(){
        let getUser = JSON.parse(localStorage.getItem('userData'));
        return getUser.id
      },
    },

    mounted() {
        apiFetch('friends/' + this.getUser())
            .then(res => {
             this.friends = res;
        });
    },
}
</script>
<style>
.profile-card-5{
margin-top:20px;
}
.profile-card-5 .btn{
border-radius:2px;
text-transform:uppercase;
font-size:12px;
padding:7px 20px;
}
.profile-card-5 .card-img-block {
width: 91%;
margin: 0 auto;
position: relative;
top: -20px;

}
.profile-card-5 .card-img-block img{
border-radius:5px;
box-shadow:0 0 10px rgba(0,0,0,0.63);
}
.profile-card-5 h5{
color:#3386AF;
font-weight:600;
}
.profile-card-5 p{
font-size:14px;
font-weight:300;
}
.profile-card-5 .btn-primary{
background-color:#3386AF;
border-color:#3386AF;
}
.profile-card-5 .btn-primary:hover{
  background: #225772;
  border-color:#225772;

}

</style>