// dependencies
import Vue from 'vue'

new Vue({
  el: '#vue-app',
  data: {
    title: 'tcgpairs'
  },
  components: {
    TournamentsIndex: require('./components/tournaments/index.vue')
  }
})
