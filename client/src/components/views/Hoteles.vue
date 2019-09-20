<template>
    <div>    <br>
    <div class="container mt-4">
    <b-alert :show="loading" variant="info">Cargando...</b-alert>
    <b-row>
      <b-col sm="8">
        <table class="table table-striped">
          <thead>
            <tr>
              <th v-if="false">Identificador</th>
              <th>Nit</th>
              <th>Nombre</th>
              <th>Dirección</th>
              <th>Cantidad de habitaciones</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registro in registros" :key="registro.id">
              <td v-if="false">{{ registro.id }}</td>
              <td>{{ registro.nit }}</td>
              <td>{{ registro.nombre }}</td>
              <td>{{ registro.direccion }}</td>
              <td>{{ registro.numero_habitaciones }}

            <router-link  tag="li" class="btn btn-link" :to="`/site/config/${registro.id}`">Gestionar</router-link>
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
      </b-col>
     <b-col sm="4">
        <b-card :title="(model.id ? 'Editar ID#' + model.nit : 'Agregar')">
          <form @submit.prevent="saveModel">


            <b-form-group >
                    <b-form-input type="text" placeholder="Nit"  v-model="model.nit"></b-form-input>
            </b-form-group>

            <b-form-group >
                    <b-form-input type="text" placeholder="Nombre de hotel"  v-model="model.nombre"></b-form-input>
            </b-form-group>



            <b-form-group >
                    <b-form-input type="text" placeholder="Dirección"  v-model="model.direccion"></b-form-input>
            </b-form-group>

            <b-form-select  v-model="model.ciudad_id" class="my-2" >
               <option :value="null" disabled>-- Seleccione --</option>
               <option  v-for="city in citys"  :key="city.id" :value="city.id">{{city.nombre}}</option>
              </b-form-select>

              <b-form-group >
                      <b-form-input type="number" placeholder="Número de habitaciones"  v-model="model.numero_habitaciones"></b-form-input>
              </b-form-group>



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
      loading: false,
      registros: [],
      citys: [],
      tipo_habitaciones : [],
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
      this.registros = await api.get(this,false,'hoteles')
      this.model = {}
      this.citys = await api.get(this,false,'ciudades')
      this.loading = false
    },
    async populateModelToEdit (registro) {
      this.model = Object.assign({}, registro)
      this.model.riego = 'true';
    },
    async saveModel () {

      if (this.model.id) {
        await api.update(this,this.model.id, this.model,'hoteles')
      } else {
        console.log("Modelo a enviar para su creación",this.model);
        await api.create(this,this.model,false,'hoteles')
      }
      this.model = {} // reset form
      await this.refresh()
    },
    async deleteModel (id) {
      if (confirm('¿Estas seguro de eliminar este registro?')) {
        if (this.model.id === id) {
          this.model = {}
        }
        await api.delete(this,id,'hoteles')
        await this.refresh()
      }
    }
  }
}
</script>

<style >
</style>
