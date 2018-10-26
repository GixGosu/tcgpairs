
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('datetime', Datetime);
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('tournament-index', require('./components/tournament/TournamentIndex.vue'));
Vue.component('tournament-create', require('./components/tournament/TournamentCreate.vue'));
Vue.component('team-create', require('./components/team/TeamCreate.vue'));
Vue.component('game-index', require('./components/game/GameIndex.vue'));
Vue.component('player-index', require('./components/player/PlayerIndex.vue'));

const app = new Vue({
    el: '#app'
});
