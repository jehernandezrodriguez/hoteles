<template>
<div>
<div id='dpi' style='height: 1in; left: -100%; position: absolute; top: -100%; width: 1in;'></div>

    <div class="container-fluid mt-4">
    <b-alert :show="loading" variant="info">Cargando...</b-alert>
    <b-row>
      <b-col sm="12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th >Identificador</th>
              <th>Nombre </th>
              <th>Dirección</th>
              <th>Nit</th>
              <th>cantidad habitaciones</th>
              <th>Ciudad</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registro in registros" :key="registro.id">
              <td >{{ registro.id }}</td>
              <td>{{ registro.alias }}</td>
              <td>{{ registro.especieComun }}</td>
              <td>{{ registro.temperatura }}</td>
              <td>{{ registro.humedad }}</td>
              <td>{{ registro.cantAgua }}</td>

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

    </b-row>
  </div>

    <div>

      <form @submit.prevent="saveModel">
         <div class="mx-auto bg-info" >
              <b-alert show variant="success"> Datos generales.</b-alert>
          </div>
        <b-row class="filacampos">
       <b-col sm="4" offset-sm="1">
            <b-form-group label="Especie comun">
              <b-form-input type="text" placeholder="Ej Tomate"  v-model="model.especieComun"></b-form-input>
            </b-form-group>
            <b-form-group label="Alias">
              <b-form-input type="text" placeholder="Ej Tomate 1" v-model="model.alias"></b-form-input>
            </b-form-group>
            <b-form-group label="Diametro Raices">
              <b-form-input type="range" min="0" step="0.25" max="50"  v-model="model.diametroRaices"></b-form-input>
            </b-form-group>

      </b-col>
      <b-col sm="4" offset-sm="1">
            <b-form-group label="Temperatura Ideal">
              <b-form-input type="range" min="0" step="0.25" max="50" v-model="model.temperatura"></b-form-input>
            </b-form-group>
            <b-form-group label="Humedad Ideal">
              <b-form-input  type="range" min="0" step="0.25" max="50" v-model="model.humedad"></b-form-input>
            </b-form-group>
            <b-form-group label="Cantidad Agua Ideal">
              <b-form-input  type="range" min="0" step="0.25" max="50" v-model="model.cantAgua"></b-form-input>
            </b-form-group>
      </b-col>
      </b-row>
  <hr class="half-rule"/>
      <b-row>

       <b-col sm="12">
          <div class="mx-auto bg-info" >

            <b-alert show variant="success"> Posiciones para el riego y senso de humedad.</b-alert>
           <b-alert variant="danger"
             :show="messageError"
            >
            Cuando emparejes tu dispositivo,las posiciones no pueden estar vacias.
          </b-alert>

          <b-alert variant="danger" :show="messageErrorModel">
            {{message}}
         </b-alert>
           </div>
          <b-row>
               <b-col sm="9 cont-cultivo">
                 <b-card title="Debes buscar donde está la planta">
                  <b-row>
                    <b-col sm="5">
                      <div class="cont-tipo-pos">
                   <b-form-radio-group v-model="tipoPos"
                          :options="optionsPos"
                          name="radioInline">
                  </b-form-radio-group>
                 </div>
                    </b-col>
                    <b-col sm="7">
                      <div class="textoposiciones" v-on:mousemove="getPos" >

                         <span> <circle-icon class="circulo-verde"></circle-icon> Donde se deposita el agua</span> <br>
                         <span> <circle-icon class="circulo-azul"></circle-icon> Donde se realiza la medición de humedad</span>
                       </div>
                    </b-col>


                  </b-row>

                   <b-card title="Tu cultivo" style="position:relative">
                    <div class="cultivo">
                        <div class="pos_planta" v-for="plat_pos in registros" :key="plat_pos.id+'_pos'">

                            <span  v-bind:style="{top:centimeterToPixel(plat_pos.posRiego.y,'y')+'px',left:centimeterToPixel(plat_pos.posRiego.x,'x')+'px'}"> <circle-icon class="circulo-verde"></circle-icon></span>
                            <span v-bind:style="{top:centimeterToPixel(plat_pos.posHumedad.y,'y')+'px',left:centimeterToPixel(plat_pos.posHumedad.x,'x')+'px'}"> <circle-icon class="circulo-azul"></circle-icon></span>
                            <span  v-bind:style="{top:calculatePos(plat_pos.posHumedad.y,plat_pos.posRiego.y)+'px',left:calculatePos(plat_pos.posHumedad.x,plat_pos.posRiego.x)+'px'}"> {{plat_pos.alias}} </span>
                        </div>
                     </div>
                   </b-card>
                    </b-card>
               </b-col>
               <b-col sm="3">
                  <b-card title="Posiciones de planta">

                  <b-button class="btonmover" v-on:click="moverDispositivo" variant="outline-success">Mover dispositivo</b-button>

                  <p class="card-text">Riego</p>

                  <b-form-group >
                    <b-form-input type="number" placeholder="x"  v-model="modelPos.posRiego.x"></b-form-input>
                  </b-form-group>

                  <b-form-group >
                    <b-form-input type="number" placeholder="y" v-model="modelPos.posRiego.y"></b-form-input>
                   </b-form-group>

                   <p class="card-text">Humedad</p>

                  <b-form-group >
                    <b-form-input type="number" placeholder="x"  v-model="modelPos.posHumedad.x"></b-form-input>
                  </b-form-group>

                  <b-form-group >
                    <b-form-input type="number" placeholder="y" v-model="modelPos.posHumedad.y"></b-form-input>
                   </b-form-group>
                  </b-card>
               </b-col>

          </b-row>
      </b-col>
      </b-row>

       <div>
                       <b-btn type="submit" variant="success">Guardar Planta</b-btn>
        </div>
       </form>

       </div>

  </div>
</template>

<script>
import api from '@/api'
import { EditIcon,DeleteIcon,CircleIcon,EyeIcon } from 'vue-feather-icons'
export default {
  data () {
    return {
      loading: false,
      messageError:false,
      messageErrorModel:false,
      message:'',
      registros: [],
      configuracion: {},
      model: {},
      plantas : [],
      tabIndex: 0,
      updateModel : false,
      tipoPos: 'riego',
      optionsPos: [
        { text: 'Escoger Riego', value: 'riego' },
        { text: 'Escoger Humedad', value: 'humedad' },
      ],

    }
  },
  components: {
    EditIcon,DeleteIcon,CircleIcon,EyeIcon
  },
  async created () {
    this.refresh()
  },
  methods: {
    changeTab()
    {
      if(!this.updateModel)
          this.model = {}
      else
         this.updateModel = false;

    },
    calculatePos(pos1,pos2)
    {    pos1= this.centimeterToPixel(pos1,'y');
         pos2= this.centimeterToPixel(pos2,'x');
          return Math.round((pos1+pos2)/2);
    },
    centimeterToPixel( steps,type){
      //convert pasos
        let cm = steps*0.3/64;//regla de tres para convertir los pasos del motor a cm
        let dpi = (type=="x") ? document.getElementById('dpi').offsetWidth : document.getElementById('dpi').offsetHeight ;
        return 0.03937007 * dpi * cm;
    },
    getPos(event)
    {
      if(this.tipoPos=='riego'){
          this.modelPos.posRiego.x = event.clientX;
          this.modelPos.posRiego.y = event.clientY;
      }
      else{
        this.modelPos.posHumedad.x = event.clientX;
        this.modelPos.posHumedad.y = event.clientY;
      }

    },
    async refresh () {
      this.loading = true
      this.model = {} // reset form;
      this.modelPos = {posHumedad :{"x":'',"y":''},posRiego :{"x":'',"y":''}};
      this.registros = await api.getAgricultorRelation(this,'planta')
      this.configuracion = await api.getAgricultorRelation(this,'configuracion')

      if(this.configuracion === null  ||  this.configuracion.length == 0 )
      {
          this.$refs.modalMsg.show();
          var v = this;
          setTimeout(()=>{ v.$router.push('/site/config');}, 3000);
      }else
        this.configuracion= this.configuracion[0];

      this.loading = false
      this.tabIndex = 0;
    },
    async populateModelToEdit (registro) {
      this.updateModel = true;
      this.tabIndex=1;
      this.model = Object.assign({}, registro)
      this.modelPos.posRiego = this.model.posRiego;
      this.modelPos.posHumedad = this.model.posHumedad;
    },
    async saveModel ()
    {
      if ( this.model.cantAgua=="" || this.model.diametroRaices=="" || this.model.humedad=="" || this.model.temperatura=="" || this.model.alias=="" || this.model.alias=="" || this.model.especieComun=="" || this.modelPos.posHumedad.x=="" || this.modelPos.posHumedad.y=="" || this.modelPos.posRiego.x=="" || this.modelPos.posRiego.y=="" ) {
         this.messageErrorModel = true;
         this.message = "Llena los datos de la planta";
      }else {
        this.messageErrorModel = false;
        this.model.posHumedad= this.modelPos.posHumedad;
        this.model.posRiego= this.modelPos.posRiego;

        if (this.model.id)
          await api.update(this,this.model.id, this.model,'plantas')
          else
          await api.create(this,this.model,true,'plantas')

        this.refresh();
      }

    },
    async deleteModel (id) {
      if (confirm('¿Estas seguro de eliminar este registro?')) {
        if (this.model.id === id) {
          this.model = {}
        }
        await api.delete(this,id,'plantas')
        await this.refresh()
      }
    },
    async moverDispositivo () {
       let x='',y ='';
       if(this.tipoPos=='riego'){
          x = this.modelPos.posRiego.x;
          y =  this.modelPos.posRiego.y;
      }else{
          x=  this.modelPos.posHumedad.x;
          y = this.modelPos.posHumedad.y;
      }

      if(x!=='' && y!=='' ){
          await api.create(this,{tipo:'ir_planta',status:0,datos:{posPlantax:x,posPlantay:y} },true,'operacionesPrototipo')
          this.$refs.modalMoverDis.show();
      }else
        this.messageError= true;
    }
  }
}
</script>

<style >
.circulo-azul
{
 color: transparent;
  fill: #66cdaa;
}
.circulo-verde
{  color: transparent;
  fill: #00cd00;
}
.textoposiciones
{
  text-align: start;
  line-height: 23px;
}
.tabcrear .tab-content
{
  margin-top: 2%;
}
.curso-irriwation
{

  cursor: url('/static/img/cursor_irriwation.svg');
}
.curso-humedity
{
  cursor: url('/static/img/cursor_humedity.svg');
}
.cultivo
{
  position: relative;
  overflow: auto;
  width: 105vh;
  height: 80vh;
  z-index: 3;
}


.pos_planta span
{
  position: absolute;
  z-index: 2;
}
.filacampos
{
  margin-top: 2%;
}
.btonmover {
    margin: 10%;
}
.cont-planta
{
  position: relative;
  z-index: 1;
}
</style>
