<template>
  <div class="loaderContainer">
    <div class="loader one"></div>
  </div>

</template>

<script>
export default {
  name: "LoaderComponent",
  data () {
    return {

    }
  }
}
</script>

<style>
.loaderContainer {
  display: inline-block;
  position: absolute;
  left: 50%;
  margin-left: -24px;
  top: 50%;
}

/* Common styles */
.loader {
  --size: 48px;
  --primary-color: #3386AF;

  height: var(--size);
  width: var(--size);
}

/* ONE */
@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
.one {
  border: calc(var(--size) / 8) solid var(--primary-color);
  border-left-color: transparent;
  border-radius: 100%;
  box-sizing: border-box;
  animation: spin .7s linear infinite;
}
</style>