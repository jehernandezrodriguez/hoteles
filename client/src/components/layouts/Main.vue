<template>
<div>

     <nav class="navbar navbar-dark fixed-top bg-green flex-md-nowrap p-0 shadow">
      <router-link tag="li" class="navbar-brand col-sm-3 col-md-2 mr-0" to="/site/hoteles">Hoteles</router-link>
       <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link"  v-on:click="logout" >Salir</a>
        </li>
      </ul>

    <div class="navbar-header" id="navbar-mobile">
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
            <menu-icon class="custom-class"></menu-icon>
        </button>
        Bienvenido
    </div>
    <!-- Collection of nav links and other content for toggling -->
    <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
            <li><router-link tag="li" to="/site/hotel" >Hoteles</router-link> </li>
        </ul>
    </div>
    </nav>


     <div class="container-fluid">
         <div class="row">
        <nav class="col-sm-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">


              <li class="nav-item">
                <router-link class="nav-link" tag="li" to="/site/hotel">
                 <clipboard-icon class="custom-class"></clipboard-icon>
                  Hoteles
                </router-link>

              </li>

            </ul>

          </div>
        </nav>

        <main role="main" class="col-sm-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Administración</h1>
          </div>

           <router-view></router-view>
        </main>
      </div>
    </div>
</div>
</template>

<script>
import { BarChart2Icon,ActivityIcon,CloudSnowIcon,ZapIcon,MenuIcon,ClipboardIcon } from 'vue-feather-icons'
import auth from '../../auth'

export default {

  name: 'Main',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  },
   components: {
    BarChart2Icon,
    CloudSnowIcon,
    ActivityIcon,
    ZapIcon,MenuIcon ,ClipboardIcon
  },
  methods:
  {
      logout()
      {
        auth.logout(this);
      }
  }

}
</script>


<style>
.bg-green {
    background-color: #51C85D!important;
}
.nav-link
{
    cursor: pointer;
}
</style>
