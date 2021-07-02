<template>
  <main class="container">
    <LoaderComponent v-if="loading" />

    <div class="container" v-for="post in posts" :key="post.id">
      <input type="hidden" name="" value="{{post.id}}" />

      <div class="blog-container">
        <div class="blog-header">
          <div
            class="blog-cover"
            :style="`background:url(${imageURL(
              post.post_pic
            )}); background-size: cover;  background-position: center;`"
          >
            <div class="blog-author">
              <h3>{{ post.user_name }} {{ post.last_name }}</h3>
            </div>
          </div>
        </div>

        <div class="blog-body mt-3">
          <div class="blog-title">
            <h2>{{ post.title }}</h2>
          </div>
          <div class="blog-summary">
            <p>
              {{ post.content }}
            </p>
          </div>
          <div class="blog-tags">
            <ul>
              <p class="category-name">
                {{ post.category_id.name }}
              </p>
            </ul>
          </div>
        </div>

        <div class="blog-footer">
          <ul>
            <li class="published-date">{{ post.created_At }}</li>

            <li class="comments accordion" id="accordionExample">
              <a
                href="#"
                data-toggle="collapse"
                :data-target="`#collapseOne${post.id}`"
                aria-expanded="true"
                aria-controls="collapseOne"
                @click="loadComments(post.id)"
              >
                <i class="far fa-2x fa-comments colorMain" id="headingOne"></i>
              </a>
            </li>

            <li class="edit" v-if="post.owner_id == auth.user.id">
              <router-link :to="`home/${post.id}`">
                <i class="far fa-2x fa-edit colorMain"></i>
              </router-link>
            </li>

            <!-- Tacho de Basura -->
            <li class="delete" >
              <i
                v-if="confirmDeletePost === null || confirmDeletePost != post.id"
                class="far fa-2x fa-trash-alt colorDanger ml-3"
                @click="requestDeleteConfirmation(post.id)"
              ></i>
              
              <div v-else>

                <p v-if="!canDelete(post.owner_id, auth.user.id)">No podes borrar el post</p>

                <div v-else>                  
                  <span class="confirmDeleteText">Seguro?</span>
                  <button class="btn-cancel-delete" @click="cancelDeleteConfirmation">Cancelar</button>
                  <button class="btn-confirm-delete" @click="deletePost(post.id)">Si, borrar</button>
                </div>

              </div>

            </li>

          </ul>
        </div>

        <!-- NewComment -->

        <div v-if="errors.content !== null" id="errors-comment-content" class="container text-danger mb-2">{{ errors.content }}</div>
        <form class="pb-3" @submit.prevent="addComment(post.id, auth.user.id)" action="#">
          <div class="form-group d-flex container" id="new-comment">

            <input
              type="text"
              class="form-control"
              id="comment"
              placeholder="Dejá tu comentario..."
              v-model="comment.content"
              :aria-describedby="errors.content !== null ? 'errors-comment-content' : null"
            />
            <button id="buttonComment" type="submit"><i class="fas fa-paper-plane"></i> </button>
          </div>
        </form>

        <!-- Comentarios -->
        <div class="accordion pb-3" id="accordionExample">
          <div
            :id="`collapseOne${post.id}`"
            class="collapse accordion-container"
            aria-labelledby="headingOne"
            data-parent="#accordionExample"
          >
            <div
              class="card-body card-comments"
              v-for="comment in comments"
              :key="comment.id"
            >
              <p class="commentOwner colorMain">{{comment.owner_id.name}} {{comment.owner_id.last_name}} <span class="commentDate">{{comment.created_at}}</span></p>
              <p class="mainGrey ml-2 comment-text">{{ comment.comment }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <NewPostBtn />
  </main>
</template>

<script>
import NewPostBtn from "@/components/NewPostBtn.vue";
import LoaderComponent from "@/components/LoaderComponent.vue";
import { apiFetch } from "@/api/fetch";
import { API_IMAGES } from "@/env/env";
import authService from "../services/auth.js";

export default {
  name: "Home",
  components: {
    NewPostBtn,
    LoaderComponent,
  },
  data: function () {
    return {
      posts: [],
      comments: [],
      isFilled: true,
      loading: false,
      auth: {
        user: {
          id: null,
          email: null,
        },
      },
      comment: {
        content: null,
      },
      confirmDeletePost: null,
      errors: {
        content: null,
      }
    };
  },

  methods: {
    imageURL(image) {
      return `${API_IMAGES}/${image}`;
    },
    loadPosts() {
      this.loading = true;
      apiFetch("posts").then((res) => {
        this.posts = res;
        this.loading = false;
      });
    },

    canDelete(post, user){
      if(post !== user) {
        return false
      } else {
        return true;
      }
    },

    requestDeleteConfirmation(id) {
      this.confirmDeletePost = id
    },

    cancelDeleteConfirmation(){
      this.confirmDeletePost = null
    },

    deletePost(id) {
      apiFetch(`deletePost/${id}`).then((res) => {
        this.loadPosts();
      });
    },

    addComment(id, owner) {
      if(!this.validates()) return;

      let obj = {
        post_id: id,
        owner_id: owner,
        content: this.comment.content
      }
      apiFetch("createComment", {
        method: "POST",
        body: JSON.stringify(
          obj
        ),
      }).then((res) => {
        if (res.success) {
          this.comment = {
            post_id: null,
            owner_id: null,
            content: null,
          };
          let accordionContainer = document.querySelector('.accordion-container');
          accordionContainer.className = 'accordion-container collapse';
        }
      });
      this.getAllComments();
    },

    loadComments(id) {
      apiFetch(`comments/${id}`).then((res) => {
        this.comments = res;
      });
    },

    getAllComments() {
      return this.comments;
    },

    validates() {
      let hasErrors = false;

      if(this.comment.content == null || this.comment.content === ''){
        this.errors.content = 'Ingresá un comentario';
        hasErrors = true;
      } else {
        this.errors.content = null;
        hasErrors = false;
      }
      return !hasErrors;
    }
  },

  mounted() {
    if (authService.isAuthenticated()) {
      this.auth.user = authService.getUserData();
    }
    this.loadComments();
    this.loadPosts();
  },
};
</script>

<style>
.comment-text{
  margin: 0;
  padding: 0;
  
}

.card-comments {
  padding: 0 !important;
  border-bottom: 1px solid lightgray;
  margin-bottom: 7px;
}

.accordion-container{
      width: 80%;
    margin: auto;
}

.commentOwner {
  margin-bottom: 0;
}

.commentDate {
  font-size: 10px;
}

#errors-comment-content{
  width: 80%;
  padding: 0;
}

.confirmDeleteText{
  position: absolute;
  bottom: 25px;
  left: 50px;
}


.btn-confirm-delete {
  border: none;
  background-color: #3386AF;
  color: white;
  padding: 3px 10px;
  margin: 0px 3px;
}

.btn-cancel-delete {
  border: none;
  background-color: #8a3333;
  color: white;
  padding: 3px 10px;
  margin: 0px 3px;
}

#new-comment{
  width: 80%;
  padding: 0;
}

#buttonComment {
  padding: 0px 40px;
  border: none;
  color: white;
  background-color: #3386AF;  
}

.blog-container {
  background: #fff;
  border-radius: 5px;
  box-shadow: hsla(0, 0, 0, 0.2) 0 4px 2px -2px;
  font-family: "adelle-sans", sans-serif;
  font-weight: 100;
  margin: 5vh auto;
  box-shadow: 24px 24px 49px #d9d9d9, -24px -24px 49px #ffffff;
}

.blog-container a {
  color: #4d4dff;
  text-decoration: none;
  transition: 0.25s ease;
}

.blog-cover {
  background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/17779/yosemite-3.jpg");
  background-size: cover;
  border-radius: 5px 5px 0 0;
  height: 500px;
  box-shadow: inset hsla(0, 0, 0, 0.2) 0 64px 64px 16px;
}

.blog-author,
.blog-author--no-cover {
  margin: 0 auto;
  padding-top: 0.125rem;
  width: 80%;
}

.blog-author h3::before,
.blog-author--no-cover h3::before {
  background-size: cover;
  border-radius: 50%;
  content: " ";
  display: inline-block;
  height: 32px;
  margin-right: 0.5rem;
  position: relative;
  top: 8px;
  width: 32px;
}
.blog-author h3 {
  color: #212529;
  font-weight: bold;
  text-shadow: white 2px 2px 3px;
}
.blog-author--no-cover h3 {
  color: lighten(#333, 40%);
  font-weight: 100;
}

.blog-body {
  margin: 0 auto;
  width: 80%;
}
.video-body {
  height: 100%;
  width: 100%;
}
.blog-title h1 a {
  color: #333;
  font-weight: 100;
}
.blog-summary p {
  color: lighten(#333, 10%);
}
.blog-tags ul {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  list-style: none;
  padding-left: 0;
}
.blog-tags li + li {
  margin-left: 0.5rem;
}
.blog-tags a {
  border: 1px solid lighten(#333, 40%);
  border-radius: 3px;
  color: lighten(#333, 40%);
  font-size: 0.75rem;
  height: 1.5rem;
  line-height: 1.5rem;
  letter-spacing: 1px;
  padding: 0 0.5rem;
  text-align: center;
  text-transform: uppercase;
  white-space: nowrap;
  width: 5rem;
}

.blog-footer {
  border-top: 1px solid lighten(#333, 70%);
  margin: 0 auto;
  padding-bottom: 0.125rem;
  width: 80%;
}
.blog-footer ul {
  list-style: none;
  display: flex;
  flex: row wrap;
  justify-content: flex-end;
  padding-left: 0;
}
.blog-footer li:first-child {
  margin-right: auto;
}
.blog-footer li + li {
  margin-left: 0.5rem;
}
.blog-footer li {
  color: lighten(#333, 40%);
  font-size: 0.75rem;
  height: 1.5rem;
  letter-spacing: 1px;
  line-height: 1.5rem;
  text-align: center;
  text-transform: uppercase;
  position: relative;
  white-space: nowrap;
  /* & a {
    color: lighten(#333, 40%);
  } */
}
.comments {
  margin-right: 1rem;
}
.published-date {
  border: 1px solid lighten(#333, 40%);
  border-radius: 3px;
  padding: 0 0.5rem;
}
.numero {
  position: relative;
  top: -0.5rem;
}

@media (min-width: 990px) {
  .blog-container {
    max-width: 80%;
  }
}
</style>
