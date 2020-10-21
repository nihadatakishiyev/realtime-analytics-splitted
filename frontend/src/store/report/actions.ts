import { ActionTree } from 'vuex'
import { StateInterface } from '../index'
import { ExampleStateInterface } from './state'
import axios from 'axios'
const actions: ActionTree<ExampleStateInterface, StateInterface> = {
  getReport ({ commit }, payload) {
    console.log(payload)
    return new Promise((resolve, reject) => {
      axios.get('http://127.0.0.1:8000/api/services/' + payload + '/report')
        .then((response: { data: unknown }) => {
          resolve(response.data)
        })
        .catch((error: any) => {
          reject(error)
        })
    })
  }
}

export default actions
