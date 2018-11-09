/* eslint-disable */
import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Router	from 'vue-router'
import routes from './routes.vue'

Vue.use(VueAxios, axios)

Vue.use(Router)

const router = new Router({
	mode: 'history',
	routes,
})


new Vue({
	router,
  render: h => h(App),
}).$mount('#app')
