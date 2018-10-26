import Request from '../resources/requestHandler.js'

export default {
  create: function (params) {
    return Request.post('/api/teams', params)
  }
}
