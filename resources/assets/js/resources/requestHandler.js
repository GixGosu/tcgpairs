if (!window.Vue) {
  window.Vue = require('vue')
}

export default {
  get: function (endpoint, params) {
    return axios.get(endpoint, { params: params })
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  post: function (endpoint, params, options) {
    /*if (options && options.header) {
      options.header['X-CSRF-TOKEN'] = standardOptions.header['X-CSRF-TOKEN']
    } else {
      options = standardOptions
    }*/
    // return window.Vue.http.post(endpoint, params, options)
    return axios.post(endpoint, params)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  put: function (endpoint, params) {
    return window.Vue.http.put(endpoint, params, standardOptions)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  patch: function (endpoint, params) {
    return window.Vue.http.patch(endpoint, params, standardOptions)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  delete: function (endpoint, params) {
    var options
    if (params) {
      options = {
        params: params,
        headers: { 'X-CSRF-TOKEN': standardOptions.headers['X-CSRF-TOKEN'] }
      }
    } else {
      options = standardOptions
    }
    return window.Vue.http.delete(endpoint, options)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  handleError: function (error) {
    var message
    switch (error.status) {
      case 500:
        message = ['500 ERROR: Please contact support.']
        break
      case 404:
        message = ['The requested data was not found.']
        break
      case 400:
        message = error.body
        break
      case 422:
        message = error.body
        break
      default:
        message = error.body
    }
    return {
      error: true,
      code: error.status,
      message: message
    }
  }
}
