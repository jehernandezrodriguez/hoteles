<template>
      <div class="row">
      <div class="offset-1 col-4">
       <a @click="$router.go(-1)" class="btn"><img src="../assets/volver.png"></a>
      </div>

     <div class="offset-md-3 col-md-6 order-md-1">
      <div class="message"> <p> {{message}} </p>  </div>
      <p v-if="errors.length">
          <b>Por favor corregir los siguientes errores:</b>
          <ul>
            <li v-for="error in errors">{{ error }}</li>
            </ul>
      </p>
          <h4 class="mb-3">Registro</h4>
          <form class="registro" v-on:submit.prevent="sendForm"  novalidate>

              <div class="mb-3">
                <label for="firstName">Nombre</label>
                <input type="text" class="form-control"   v-model="registro.nombre" required>
               </div>


            <div class="mb-3">
              <label for="email">Email </label>
              <input type="email" class="form-control"  v-model="registro.email" required>
            </div>

            <div class="mb-3">
              <label for="email">Cedula </label>
              <input type="number" class="form-control"  v-model="registro.cedula" required>
            </div>


            <div class="mb-3">
              <label for="email">Contraseña </label>
              <input type="password" class="form-control"  v-model="registro.password" required>

            </div>

            <div class="mb-3">
              <label for="address">Direccion</label>
              <input type="text" class="form-control" placeholder="Cra 24f # 71 -22"  v-model="registro.direccion" required>
            </div>
             <div class="mb-3">
              <label for="address">Ciudad</label>
              <input type="text" class="form-control" placeholder="Bogota" value="Bogota" readOnly="true"  v-model="registro.ciudad" >
            </div>

             <div class="mb-3">
              <label for="address">Celular</label>
              <input type="text" class="form-control"  v-model="registro.celular" required>
            </div>

            <center>
                    <button class="btn btn-primary btn-lg" type="submit">Registro</button>

            </center>

          </form>
        </div>
        </div>
</template>
<script>
import { required, minLength } from 'vuelidate/lib/validators'
import auth from '../auth'
import { log } from 'util';

export default {
  name: 'Registro',
  data()
  {
      return {
        registro: {
            nombre: '',email:'',cedula:'',password:'',celular:'',ciudad:'Bogota',direccion:''
        },
        errors: [],
        message:'',
        reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
     }
  },
  methods:
  {
    sendForm() {

        this.checkForm();

        if(this.errors.length==0)
          auth.sigin(this,this.registro);
    },
    isEmailValid: function() {
      return (this.registro.email == "")? false : (this.reg.test(this.registro.email)) ? true: false;
    },
    checkForm: function ()
    {

      this.errors = [];

      if (!this.registro.nombre) {
        this.errors.push('Nombre es requerido.');
      }
      if (!this.registro.email) {
        this.errors.push('Email es requerido.');
      }
      if (!this.registro.celular) {
        this.errors.push('Celular es requerido.');
      }
      if (!this.registro.direccion) {
        this.errors.push('Direccion es requerido.');
      }
      if (!this.registro.password) {
        this.errors.push('contraseña es requerida.');
      }
      if (!this.registro.cedula) {
        this.errors.push('Cedula es requerida.');
      }
      if (!this.isEmailValid()){
        this.errors.push('El formato del email no es valido.');
      }

    }

  },
  validations: {
   registro: {
   nombre: {
      required,
      minLength: minLength(4)
    },
    password: {
     required,
      minLength: minLength(4)
    },
    email: {
     required,
      minLength: minLength(4)
    },
    celular: {
     required,
      minLength: minLength(4)
    }
    ,
    direccion: {
     required,
      minLength: minLength(4)
    }
   }
  }
}
</script>
<style >

</style>
