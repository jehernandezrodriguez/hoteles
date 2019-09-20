import Vue from 'vue'
import Router from 'vue-router'
// vistas sin registro
import NotFoundView from '@/components/404.vue'
import Home from '@/components/Home'
import Login from '@/components/Login'
import Registro from '@/components/Registro'
// layout main
import DashView from '@/components/layouts/Main'
//views
import AcomodacionView from '@/components/views/Acomodacion.vue'
import HotelesView from '@/components/views/Hoteles.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/registro',
        name: 'registro',
        component: Registro
    }
    ,{
      path: '/site',
      component: DashView,
      children: [
         {
          path: 'hotel',
          component: HotelesView,
          name: 'Hoteles',
          meta: {description: 'Todas los hoteles del sistema'}
        },
        {
          path: 'config/:id',
          component: AcomodacionView,
          name: 'Configuracion',
          meta: {description: 'Acomodación'}
        },
      ]
    }, {
      // not found handler
      path: '*',
      component: NotFoundView
    }
  ],linkActiveClass: "active",
  linkExactActiveClass: "active"
})
