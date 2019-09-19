<script>
import { Line } from 'vue-chartjs'
import auth from '../../auth'
import yyyymmdd from   'yyyy-mm-dd'
import axios from 'axios'  
export default {
  extends: Line,
   mounted() {
         var date = new Date();
         var firstDay = new Date(date.getFullYear(), date.getMonth(), 1); 
         var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
         
         var fechaStart = yyyymmdd(new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate())) + "T00:00:00.000Z";
         var fechaEnd = yyyymmdd(new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate())) + "T23:59:59.999Z";
         var agricultorId = "string";
         var token  = "YEn1cOFJ8RnQKQEEopkchJRhtBJKrnm85P58PYLxQik81T4msc4f4D2IX8MqYHH2";
         let uri = auth.api_url + "riegos/?filter{  where: {and :[ {'fecha': { gte:  "+Date.parse(fechaStart)+", lte:  "+Date.parse(fechaEnd)+"}},{'agricultorId': "+agricultorId+" }  ] } }";
         uri + "&access_token="+token;
         console.log(uri);
         
         let plantas = new Array();
         let Labels = new Array();
         let cantidad = new Array();
         axios.get(uri).then((response) => {
            let data = response.data;
            if(data) {
               data.forEach(element => {
               plantas.push(element.nomPlanta);
               Labels.push(element.nomPlanta);
               cantidad.push(element.cantAplicada);
               });
               this.renderChart({
               labels: plantas,
               datasets: [{
                  label: 'Riego',
                  backgroundColor: '#FC2525',
                  data: cantidad
            }]
         }, {responsive: true, maintainAspectRatio: false})
       }
       else {
          console.log('No data');
       }
      });  
      
      
   }
  
  
}
</script>
