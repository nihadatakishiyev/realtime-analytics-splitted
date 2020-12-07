/*
export function someAction (context) {
}
*/
export function getRealtime ({ commit }, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('http://localhost:8000/api/services/realtime/' + payload,
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

export function getCard ({ commit }, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('http://localhost:8000/api/services/card/' + payload,
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
export function getDeviceCategory ({ commit }, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('http://localhost:8000/api/services/getDeviceCategory/' + payload,
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
export function bringUserStats ({ commit }, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('http://localhost:8000/api/services/bringUserStats/' + payload,
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
