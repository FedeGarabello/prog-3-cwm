<template>
    <div id="blog-post">
      <!-- <router-link to="/"> -->
        <div id="z_button_edit" tabindex="0">
            <i class="far fa-edit z_edit"></i>
        </div>
    </div>
</template>

<style>

#z_button_edit {
  background-color: #3386AF;
  height: 50px;
  float: right;
  position: relative;
  bottom: 25px;
  left: 22px;
  outline: 0;
  color: #fff;
  border-radius: 100%;
  width: 50px;
  z-index: 999;
}

#z_button_edit:hover {
  cursor: default;
}

i {
  text-align: center;
    position: relative;
    top: 13px !important;
    left: 17px !important;
}
</style>