import Request from '../resources/requestHandler.js'

export default {
  create: function (params, url) {
    return Request.post('/api/tournaments/' + url + '/roster', params)
  }
}
