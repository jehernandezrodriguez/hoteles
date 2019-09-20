<template>
  <transition name="el-zoom-in-top">
    <div class="content-wrapper home-page">
      <!-- Content Header (Page header) -->
      <div class="jumbotron">
  <h1 class="display-4">Gestión de hoteles </h1>
  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <hr class="my-4">
  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
  <p class="lead">

    <router-link tag="li" class="btn btn-primary btn-lg" to="/site/hotel">
  Administrar
</router-link>

  </p>
</div>
    </div>
  </transition>

</template>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
body {
     background: red;
}
.iframeHome{
    height:   100%;
    left:   0px;
    position: absolute;
    top:      0px;
    width:    100%;
}


</style>

<script>
  export default {
    name: 'Blank',
    data: function () {
      return {
        host: process.env.API_BASE
      }
    },
    methods: {
      createAgricultor: function () {
        this.$router.push('/registro')
      },
      createAgricultor: function () {
        this.$router.push('/login')
      }
    }
  }
</script>
