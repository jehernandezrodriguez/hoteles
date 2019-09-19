import axios from 'axios'

// URL and endpoint constants
const api_url = process.env.API_BASE || 'http://localhost:8080/hotel/server/web'
const login_url = api_url + 'login/login'
const logout_url = api_url + 'login/logout'
const signin_url = api_url + 'login'
const url_client = process.env.url_client || 'http://localhost:8000/#/'
const filter_user = 'filter[where][id]=';
const filter_Person = 'filter[where][PersonId]=';
const filter_email = 'filter[where][email]=';
const filter_token = '?access_token=';

let contexto = null

export default {
  api_url,
  contexto, filter_user,filter_token,filter_email,filter_Person,

  // Send a request to the login URL and save the returned JWT
  login (contexto,credenciales) {
    axios.post(login_url,credenciales).then(
      response => {
                  //get data
                  this.setToken(response.data.tokenId);
                  delete response.data.tokenId;
                  this.setPerson(response.data);
                  contexto.$router.push({ path: '/site/hoteles' });
      }).catch(err =>
        {
            if (err.response.status === 401){
              console.log("No esta autorizado ");
              contexto.message= 'Usuario o password invalido!!, corrige los datos';
            }
      });


  },
  // To log out, we just need to remove the token
  logout (context) {

    let token = this.getToken(context);

    localStorage.removeItem('access_token')
    localStorage.removeItem('Person')
    localStorage.removeItem('user')

    axios.post(logout_url+'?access_token='+token).then(
      res => {
        context.$router.push('/')
      }).catch(err => {
        context.$router.push('/login')
      });
  },
  sigin(contexto,registro)
  {
          //guardar Person
          var uri = api_url + 'hoteles/';
          axios.post(uri,{'nombre':registro.nombre,'email':registro.email,'username':registro.cedula,'celular':registro.celular,
                  'ciudad':registro.ciudad,'direccion':registro.direccion,'password':registro.password,'cedula':registro.cedula
          }).then( response =>
          {
                        contexto.$router.push({ path: '/site/report' });
                        //get data
                        this.setToken(response.data.tokenId);
                        delete response.data.tokenId;
                        this.setPerson(response.data);

          }).catch(err => {

            if (err.response.status === 422){
              console.log("Invalid data ");
              let m = err.response.data.error.message;
              contexto.errors = m.split(";");
            }
          });


  },
  setPerson(Person)
  {
    localStorage.setItem('Person', JSON.stringify(Person));
  },
  getPerson () {
    if (!localStorage.getItem('Person')) return {}
    return  JSON.parse(localStorage.getItem('Person'))
  },
  setToken(token)
  {
    console.log(token);
    localStorage.setItem('access_token', token);
  },
  getToken(contexto)
  {
    if (!localStorage.getItem('access_token')) {
        contexto.$router.push('/login')
    }
    return    localStorage.getItem('access_token')
  }
}
