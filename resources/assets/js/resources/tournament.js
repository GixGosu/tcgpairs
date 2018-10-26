import Request from '../resources/requestHandler.js'

export default {
  index: function (params) {
    return Request.get('/api/tournaments', params)
  },
  create: function (params) {
    return Request.post('/api/tournaments', params)
  }
}
