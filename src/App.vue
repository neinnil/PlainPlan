<template>
  <div id="app" style>
		<div id="topmenu" style="max-width:100%">
			<div class="fleft">
			<router-link to="/ProjectNew" style="padding:1em;"> + New Project</router-link>
			<router-link to="/ProjectList" style="padding:1em;">Projects</router-link>
			<!-- router-link to="/TaskList" style="padding:1em;">
					Tasks</router-link //-->
			<router-link to="/Issue" style="padding:1em;">Issue</router-link>
			<router-link to="/WorkNote" style="padding:1em;">WorkNote</router-link>
			</div><div class="clear"></div>
		</div>
		<div>
				<router-view></router-view>
		</div>
  </div>
</template>

<script>

export default {
  name: 'app',
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
@import './styles/spms_base.css';
</style>

