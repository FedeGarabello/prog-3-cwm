<template>
  <main class="container">
    <!-- Aca la card -->
    <div class="container" 
    v-for="post in posts" 
    :key="post.id">

      <input type="hidden" name="" value="{{post.id}}">

      <div class="blog-container">
        <div class="blog-header">
          <div class="blog-cover">
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
                {{ post.category_id.name}}
              </p>
            </ul>
          </div>
        </div>

        <div class="blog-footer">
          <ul>
            <li class="published-date">{{ post.created_At }}</li>
            <li class="comments" id="headingOne">
                  <a href="#" 
                  data-toggle="collapse" 
                  :data-target="`#collapseOne${post.id}`"
                  aria-expanded="true" 
                  :aria-controls="`collapseOne${post.id}`"
                  @click="loadComments(post.id)">
                    <i class="far fa-2x fa-comments colorMain"></i>
                  </a>
            </li>
            <li class="shares">
                  <i 
                    class='far fa-2x fa-heart colorMain'
                    @click="fillHeart"
                  ></i>
              </li>
          </ul>
        </div>

        <div class="accordion" id="accordionExample" 
        v-for="comment in comments" :key="comment.id">
            <input type="hidden" name="" value="{{comment.id}}">
              <div :id="`collapseOne${post.id}`" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    {{comment.comment}}
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
import { apiFetch } from "@/api/fetch";

export default {
  name: "Home",
  components: {
    NewPostBtn,
  },
  data: function () {
    return {
      posts: [],
      comments: [],
      isFilled: true,
    };
  },

  methods: {
    loadPosts() {
      apiFetch("posts")
      .then((res) => {
        this.posts = res;
      });
    },

    loadComments(id) {
      apiFetch(`comments/${id}`)
        .then((res) => {
          console.log(res)
          this.comments = res;
        })
    },

    fillHeart(evt) {
      if (evt.target.className == "far fa-2x fa-heart colorMain") {
          evt.target.className = "fas fa-2x fa-heart colorMain";
      } else {
          evt.target.className = "far fa-2x fa-heart colorMain";
      }
    },

    getAllComments() {
      return this.comments
    }
  },

  mounted() {
    this.loadPosts()
  }

};
</script>

<style>
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
  /* &:hover {
    border-color: #ff4d4d;
    color: #ff4d4d;
  } */
}

.blog-cover {
  background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/17779/yosemite-3.jpg");
  background-size: cover;
  border-radius: 5px 5px 0 0;
  height: 15rem;
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
  background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/17779/russ.jpeg");
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
  color: #fff;
  font-weight: 100;
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
