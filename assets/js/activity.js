import Vue from 'vue';
import { TablePlugin, PaginationPlugin, SpinnerPlugin, ModalPlugin } from 'bootstrap-vue';

import ActivityApp from "./App/ActivityApp";

Vue.use(TablePlugin);
Vue.use(PaginationPlugin);
Vue.use(SpinnerPlugin);
Vue.use(ModalPlugin)

new Vue({
  el: '#app',
  render: h => h(ActivityApp)
})
