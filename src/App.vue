<template>
  <div id="app">
    <!-- img alt="Vue logo" src="./assets/logo.png" //-->
    <!-- HelloWorld msg="Welcome to Your Vue.js App"/ //-->
		<User />
		<ProjSummary />
  </div>
</template>

<script>
import User from './components/User.vue'
import ProjSummary from './components/ProjSummary.vue'

export default {
  name: 'app',
  components: {
		User,
		ProjSummary,
  }
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
