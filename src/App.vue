<template>
  <div id="app">
    <!-- img alt="Vue logo" src="./assets/logo.png" //-->
    <!-- HelloWorld msg="Welcome to Your Vue.js App"/ //-->
		<User />
		<ProjSummary />
		<Issue />
  </div>
</template>

<script>
import User from './components/User.vue'
import ProjSummary from './components/ProjSummary.vue'
import Issue from './components/Issue.vue'

var NotFoundPage = {
	template: `<div> Page is not found.</div>`
};
const routes = [
	{path:'/', component: ProjSummary},
	{path:'/User', component: User},
	{path:'/issues', component: Issue},
	{path: '*', component: NotFoundPage},
];

const router = new VueRouter({
	mode: 'history',
	routes,
});

export default {
  name: 'app',
  components: {
		User,
		ProjSummary,
		Issue,
  },
	routes,
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
