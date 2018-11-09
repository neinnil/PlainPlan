<template>
  <div id="app">
			<div class="ttable">
				<div class="tbrow">
					<div id="sidemenu" class="tbcell fleft" style="max-width:20%;border:solid 1px red;min-width:10em;">
						<ul>
							<li><router-link to="/">Home</router-link></li>
							<li><router-link to="/index.html">Summary</router-link></li>
							<li><router-link to="/User">User</router-link></li>
							<li><router-link to="/ProjectNew"> + Project</router-link></li>
							<li><router-link to="/ProjectList">Projects</router-link></li>
							<li><router-link to="/TaskNew"> + Task</router-link></li>
							<li><router-link to="/TaskList">Tasks</router-link></li>
							<li><router-link to="/Issue">Issue</router-link></li>
							<li><router-link to="/WorkNote">WorkNote</router-link></li>
						</ul>
					</div>
					<div id="contents" class="tbcell topalign" style="padding:0px;">
						<router-view></router-view>
					</div>
					<div class="tbcell clear"></div>
				</div>
			</div>
  </div>
</template>

<script>
//import User from './components/User.vue'
//import ProjSummary from './components/ProjSummary.vue'
//import Issue from './components/Issue.vue'

export default {
  name: 'app',
 // components: {
 // 	User,
 // 	ProjSummary,
 // 	Issue,
 // },
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

