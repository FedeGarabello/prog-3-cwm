<template>
  <div>
    <form action="">

      <div class="custom-file mt-4">
        <input type="file" class="custom-file-input" id="profile_pic" ref="profile_pic" @change="loadProfilePic">
        <label class="custom-file-label" for="profile_pic" data-browse="Buscar">Eliga una imagen</label>
      </div>

    </form>
  </div>
</template>

<script>
export default {
  name: "ProfilePicture",
  data () {
    return {
      user: {
        profile_pic: null,
      }
    };
  },
  methods: {
    loadProfilePic(){
      this.$refs.profile_pic.files = null;
      const reader = new FileReader();
      reader.addEventListener('load',()=>{
        this.user.profile_pic = reader.result;
      });
      reader.readAsDataURL(this.$refs.profile_pic.files[0]);
    },
  }
}
</script>