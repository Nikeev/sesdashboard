import Vue from 'vue';
import { TablePlugin, PaginationPlugin, SpinnerPlugin, ModalPlugin, TooltipPlugin } from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css';

import ActivityApp from "./App/ActivityApp";

Vue.use(TablePlugin);
Vue.use(PaginationPlugin);
Vue.use(SpinnerPlugin);
Vue.use(ModalPlugin);
Vue.use(TooltipPlugin);

new Vue({
  el: '#app',
  render: h => h(ActivityApp)
})
