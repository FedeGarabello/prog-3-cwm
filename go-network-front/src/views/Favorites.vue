<template>
  <div class="container">
    <h2>Favoritos</h2>

    <p>Aca los favoritos</p>
  </div>
</template>

<script>
import NewPostBtn from "@/components/NewPostBtn.vue";
import { apiFetch } from "@/api/fetch";
import { API_IMAGES } from "@/env/env";
import authService from "../services/auth.js";

export default {
  name: "Favorites",
  components: {
    Favorites,
  },
  data: function () {
    return {
      post: {
        id: null,
        user_id: null,
        post_id: null
      },
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
      apiFetch(`deletePost/${id}`).then(() => {
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

    deleteComment(id) {
      apiFetch(`deleteComment/${id}`)
      .then((res) => {
        if(res.success){
          this.comments = this.comments.slice().filter(comment => comment.id !== id)
        }
      });
    },

    loadComments(id) {
      this.comments = [];
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
  position: relative;
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

.new-comment{
  width: 80%;
  padding: 0;
}

.buttonComment {
  padding: 0px 40px;
  border: none;
  color: white;
  background-color: #3386AF;  
}

.blog-container {
  background: #fff;
  border-radius: 5px;
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
  border-radius: 3px;
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
  margin: 0 auto;
  padding-bottom: 0.125rem;
  width: 80%;
}
.blog-footer ul {
  list-style: none;
  display: flex;
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
