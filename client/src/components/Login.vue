<template>
      <div class="row">

     <div class="offset-1 col-4">
      <a @click="$router.go(-1)" class="btn"><img src="../assets/volver.png"></a>
     </div>

     <div class="offset-md-3 col-md-6 order-md-1">


          <h4 class="mb-3">Ingresa a Riwa</h4>
          <br>
          <p>{{message}}</p>
          <form class="registro" v-on:submit.prevent="sendForm" >



            <div class="mb-3">
              <label for="user">Email O Cedula</label>
              <input type="text" class="form-control"  v-model="registro.user" required>

            </div>

            <div class="mb-3">
              <label for="email">Contraseña </label>
              <input type="password" class="form-control"  v-model="registro.password" required >

            </div>


            <center>
                    <button class="btn btn-primary btn-lg" type="submit">Login</button>

            </center>

          </form>
        </div>
        </div>
</template>
<script>
import { required, minLength } from 'vuelidate/lib/validators'
import auth from '../auth'
import axios from 'axios'
import { log } from 'util';

export default {
  name: 'Login',
  data()
  {
      return {
        registro: {
            password:'',user:''
        },
        message:''
     }
  },
  methods:
  {
    sendForm() {
       let credenciales = {"password" : this.registro.password};
       if (this.registro.user.indexOf('@') > -1)
          credenciales.email = this.registro.user;
       else credenciales.username = this.registro.user;

        auth.login(this,credenciales)

    }

  },
  validations: {
   registro: {

    password: {
     required,
      minLength: minLength(4)
    },
    user: {
     required,
      minLength: minLength(4)
    }
   }
  }
}
</script>
<style >

</style>
