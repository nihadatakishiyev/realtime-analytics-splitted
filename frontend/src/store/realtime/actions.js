/*
export function someAction (context) {
}
*/
export function getRealtime ({ commit }, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('http://127.0.0.1:8000/api/services/realtime/' + payload,
      payload
    )
      .then(function (response) {
        res(response)
      })
      .catch(function (error) {
        rej(error.response)
      })
  })
}
