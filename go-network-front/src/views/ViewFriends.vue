<template>
    <main class="container">
        <h4 class="mainGrey font-weight-bold mt-5">Tus contactos:</h4>


        <div class="wrapper">
          <div class="label">Submit your search</div>
          <div class="searchBar">
            <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Buscar" v-model="search"/>
            <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
              </svg>
            </button>
          </div>
        </div>

         <div class="container mt-4 d-flex flex-wrap" 
         v-if="friends.length > 0">
            <div class="col-md-4 mt-4" v-for="friend in filterdFriend" :key="friend.id">
              <div class="card profile-card-5">
                <div class="card-img-block">
                  <img class="card-img-top" src="https://images.unsplash.com/photo-1517832207067-4db24a2ae47c" alt="Card image cap">
                </div>
                  <div v-if="relation.state == 2">
                    <div class="card-body pt-0">
                      <h5 class="card-title">{{friend.name + ' ' + friend.last_name}}</h5>
                      <p class="card-text"><span class="font-weight-bold">Email:</span> {{friend.email}}</p>
                      <a href="#" class="btn btn-primary">asdusuario</a>
                    </div>
                  </div>

                  <div v-else>
                    <div class="card-body pt-0">
                      <h5 class="card-title">{{friend.name + ' ' + friend.last_name}}</h5>
                      <p class="card-text"><span class="font-weight-bold">Email:</span> {{friend.email}}</p>
                      <a href="#" class="btn btn-primary">Ver Post de este usuario</a>
                    </div>
                  </div>
                  
              </div>
            </div>

         </div>
         <p class="mt-4" v-else> Aún no has agregado ningún contacto</p>
    </main>
</template>


<script>
import { apiFetch } from '../api/fetch'
import { stripVowelAccent } from '../services/parser'

export default {

    data: function () {
      return {
        search: '',
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

    computed: {
      filterdFriend(){
        return this.friends.filter(friend => stripVowelAccent(friend.name.toLowerCase()).match(stripVowelAccent(this.search.toLowerCase())) 
               || stripVowelAccent(friend.last_name.toLowerCase()).match(stripVowelAccent(this.search.toLowerCase()))
               || stripVowelAccent(friend.email.toLowerCase()).match(stripVowelAccent(this.search.toLowerCase())))    
      }
    },

    mounted() {
        apiFetch('friends/' + this.getUser())
            .then(res => {
                console.log(res)
                this.friends = res
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

.label {
  font-size: .625rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: +1.3px;
  margin-bottom: 1rem;
}

.searchBar {
  width: 100%;
  display: flex;
  flex-direction: row;
  align-items: center;
}

#searchQueryInput {
  width: 100%;
  height: 2.8rem;
  background: #f5f5f5;
  outline: none;
  border: none;
  border-radius: 1.625rem;
  padding: 0 3.5rem 0 1.5rem;
  font-size: 1rem;
  background: #f5f5f5;
box-shadow:  9px 9px 18px #d0d0d0,
             -9px -9px 18px #ffffff;
}

#searchQuerySubmit {
  width: 3.5rem;
  height: 2.8rem;
  margin-left: -3.5rem;
  background: none;
  border: none;
  outline: none;
}

#searchQuerySubmit:hover {
  cursor: pointer;
}

.add-friend {
  color: #3386AF;
}

</style>