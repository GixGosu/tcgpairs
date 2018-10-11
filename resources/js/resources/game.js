import Request from '../resources/requestHandler.js'

export default {
  index: function (params) {
    return Request.get('/api/games', params)
  }
}
