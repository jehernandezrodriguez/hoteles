<template>
    <div>    <br>
    <div class="container mt-4">
    <b-alert :show="loading" variant="info">Cargando...</b-alert>
    <b-row>
      <b-col sm="8">
        <h2 v-if="!loading">Número máximo de habitaciones # {{hotel.numero_habitaciones}}</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Identificador</th>
              <th>Cantidad</th>
              <th>Tipo habitación</th>
              <th>Acomodación</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registro in registros" :key="registro.id">
              <td>{{ registro.id }}</td>
              <td>{{ registro.cantidad }}</td>
              <td>{{ registro.habitacion.nombre }}</td>
              <td>{{ registro.acomodacion.nombre }}</td>
              <td v-if="false">{{ registro.habitacion_id }}</td>
              <td v-if="false">{{ registro.acomodacion_id }}</td>

              </td>

              <td class="text-right">
                <a href="#" @click.prevent="populateModelToEdit(registro)"><edit-icon class="custom-class"></edit-icon></a>
              </td>
              <td>
                <a href="#" @click.prevent="deleteModel(registro.id)"> <delete-icon class="custom-class"></delete-icon> </a>
              </td>
            </tr>


          </tbody>
        </table>
        <h3 v-if="!loading">  Total de habitaciones {{total}}</h3>
      </b-col>
     <b-col sm="4">
        <b-card :title="(model.id ? 'Editar ID#' + model.id : 'Agregar')">
          <form @submit.prevent="saveModel">
            <b-form-select  v-model="model.cantidad" class="my-2" >
               <option :value="null" disabled>-- Seleccione --</option>
               <option  v-for="i in (4,100)"  :key="i" :value="i">{{i}}</option>
              </b-form-select>


            <b-form-select  v-model="model.habitacion_id" class="my-2" >
                 <option :value="null" disabled>-- Seleccione --</option>
                 <option  v-for="tipo in tipo_habitaciones"  :key="tipo.id" :value="tipo.id">{{tipo.nombre}}</option>
            </b-form-select>


            <b-form-select  v-model="model.acomodacion_id" class="my-2" >
                             <option :value="null" disabled>-- Seleccione --</option>
                             <option  v-for="tipo in acomodaciones[model.habitacion_id]"  :key="tipo.id" :value="tipo.id">{{tipo.nombre}}</option>
            </b-form-select>


            <div>
              <b-btn type="submit" variant="success">Guardar</b-btn>
            </div>
          </form>
        </b-card>
      </b-col>

    </b-row>
  </div>

  </div>



</template>

<script>
import api from '@/api'
import { EditIcon,DeleteIcon } from 'vue-feather-icons'
export default {
  data () {
    return {
      id:this.$route.params.id,
      loading: false,
      registros: [],
      acomodaciones: [],
      tipo_habitaciones: [],
      hotel:{},
      tipo_habitaciones : [],
      total:0,
      model: {},
    }
  },
  components: {
    EditIcon,DeleteIcon
  },
  async created () {
    this.refresh()
  },
  methods: {
    async refresh () {

      this.loading = true
      this.model = {} // reset form;

      this.hotel = await api.get(this,false,'hoteles/'+this.id)
      console.log("hotel en configuración", this.hotel );
      this.registros = await api.get(this,'id='+this.id,'habitaciones/search')
      this.tipo_habitaciones = await api.get(this,false,'tipos')

    this.acomodaciones = [];
    this.acomodaciones["1"]= [{id:1,nombre:'Sencilla'},{id:2,nombre:'Doble'}];
    this.acomodaciones["2"]= [{id:3,nombre:'Triple'},{id:3,nombre:'Cuádruple'}];
    this.acomodaciones["3"]= [{id:1,nombre:'Sencilla'},{id:2,nombre:'Doble'},{id:3,nombre:'Triple'}];
    console.log("acomodaciones ",this.acomodaciones);

    for (var i = 0; i < this.registros.length; i++) {
        this.total +=  parseInt(this.registros[i].cantidad);
    }
      
    this.loading = false
    

    },
    async populateModelToEdit (registro) {
      this.model = Object.assign({}, registro)
    },
    async saveModel () {
      var modelC = (this.model.id) ?  this.model.cantidad : 0;

      var total = (parseInt(this.total)+parseInt(this.model.cantidad)) - modelC;
      if ( total > this.hotel.numero_habitaciones ) {
        alert("No puedes gestionar esta operación. El numero maximo de habitaciones es "+this.hotel.numero_habitaciones)
        return;
      }

      this.model.hotel_id = this.hotel.id
      if (this.model.id) {
        await api.update(this,this.model.id, this.model,'habitaciones')
      } else {
        console.log("Modelo a enviar para su creación",this.model);
        await api.create(this,this.model,false,'habitaciones')
      }
      this.model = {} // reset form
      await this.refresh()
    },
    async deleteModel (id) {
      if (confirm('¿Estas seguro de eliminar este registro?')) {
        if (this.model.id === id) {
          this.model = {}
        }
        await api.delete(this,id,'habitaciones')
        await this.refresh()
      }
    }
  }
}
</script>

<style >
</style>
