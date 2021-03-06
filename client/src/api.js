import Vue from 'vue'
import axios from 'axios'
import auth from './auth'

const client = axios.create({
  baseURL: auth.api_url,
  json: true
})

export default {
  async execute (contexto,method, resource, data,filter,totalResource=false) {
    let accessToken = "dGVzdDEwMGtleS1ob3RlbC1jYW1lcnVuLXRlc3QxMDBrZXktaG90ZWwtY2FtZXJ1bi0=";
    let url = "";
    if (!totalResource) {
      url =  resource + '?access-token='+accessToken;
      if (filter)
       url = resource + '?'+filter+'&access-token='+accessToken;
    }else
     url = resource;
    console.log(url);
    if(accessToken)
    {
      let axiosConfig = {
      headers: {
          'Content-Type': 'application/json;charset=UTF-8',
          "Access-Control-Allow-Origin": "*",
          "accept": 'application/json',
      }
    };
        return client({
            method,
            url: url,
            data,
            axiosConfig,
          }).then(req => {return req.data})
    }
    else
    {
        contexto.$router.push('/login')
    }

  },
  get (context,filterHotel=false,modelurl) {
    console.log(" Petición get ")
    return this.execute(context,'get', '/'+modelurl,null,filterHotel)
  },
  getById (context,id,modelurl) {
    return this.execute(context,'get', `/${modelurl}/${id}`)
  },
  getModelRelation (context,modelRelation) {
    let id = auth.getPerson().modelId;
    return this.execute(context,'get', `/models/${id}/${modelRelation}`)
  },
  getWithCondition (context,conditition) {
    return this.execute(context,'get', conditition,'',false,true)
  },
  create (context,data,relationModel,modelurl){
    if(relationModel) data.modelId = auth.getPerson().modelId;
    console.log("datos",data);
    return this.execute(context,'post', '/'+modelurl, data)
  },
  update (context,id, data,modelurl) {
    return this.execute(context,'put', `/${modelurl}/${id}`, data)
  },
  delete (context,id,modelurl) {
    return this.execute(context,'delete', `/${modelurl}/${id}`)
  }
}
