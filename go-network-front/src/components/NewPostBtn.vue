<template>
    <div id="container">
      <router-link to="/newPost">
        <div id="z_button">
            <div id="z_plus">+</div>
        </div>
      </router-link>
    </div>
</template>

<style>

#z_button {
  background-color: #3386AF;
  height: 50px;
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  outline: 0;
  display: block;
  color: #fff;
  border-radius: 100%;
  width: 50px;
  z-index: 999;
}

#z_button:hover {
  cursor: default;
}

#z_plus {
  text-align: center;
  line-height: 50px;
  font-size: 30px;
}
</style>