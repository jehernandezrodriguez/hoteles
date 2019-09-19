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
              <th>direccion</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registro in registros" :key="registro.id">
              <td v-if="false">{{ registro.id }}</td>
              <td>{{ registro.nit }}</td>
              <td>{{ registro.nombre }}</td>
              <td>{{ registro.direccion }}</td>

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
        <b-card :title="(model.id ? 'Editar ID#' + model.id : 'Agregar')">
          <form @submit.prevent="saveModel">
            <b-form-group label="Planta">

              

            </b-form-group>
            <b-form-group label="Hora Riego">
                <b-form-select v-model="model.horaRiego" :options="optionsHour" class="mb-3">
                  <template slot="first">
                      <option :value="null" disabled>-- Selecciona una hora --</option>
                  </template>
              </b-form-select>
            </b-form-group>
            <b-form-group label="">
                  <b-form-checkbox
                     v-model="model.riego"
                     :checked="true"
                     value= true
                     unchecked-value= false
                     >
                 ¿Regar?
              </b-form-checkbox>

            </b-form-group>

            <div>
              <b-btn type="submit" variant="success">Guardar</b-btn>
            </div>
          </form>
        </b-card>
      </b-col>

    </b-row>
  </div>

  <b-modal ref="modalMsg" hide-footer title="No puedes usar este componente">
    No tienes registros creados ....
  </b-modal>
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
console.log("aa");

    },
    async populateModelToEdit (registro) {
      this.model = Object.assign({}, registro)
      this.model.riego = 'true';
    },
    async saveModel () {

      if (this.model.id) {
        await api.update(this,this.model.id, this.model,'agendaPlanta')
      } else {
        console.log(this.model);

        await api.create(this,this.model,true,'agendaPlanta')
      }
      this.model = {} // reset form
      await this.refresh()
    },
    async deleteModel (id) {
      if (confirm('¿Estas seguro de eliminar este registro?')) {
        if (this.model.id === id) {
          this.model = {}
        }
        await api.delete(this,id,'agendaPlanta')
        await this.refresh()
      }
    }
  }
}
</script>

<style >
</style>
