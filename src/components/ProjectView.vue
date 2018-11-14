<template>
	<div id="projectview">
		<div class="modal" v-if="errorMessage || successMessage">
			<p class="errorMessage" v-if="errorMessage">
				{{errorMessage}}
			</p>
			<p class="successMessage" v-if="successMessage">
				{{successMessage}}
			</p>
		</div>
			
		<div class="ttable">
			<div class="tbrow"> 
				<div class="tbcell">Name</div>
				<div class="tbcell">
					<input type="text" v-model="project.name" placeholder="Input New Project Name">
				</div>
				<div class="tbcell"> Code</div>
				<div class="tbcell">
					<input type="text" v-model="project.code" placeholder="Input Project Code">
				</div>
			</div>
			<div class="tbrow">
			<div class="tbcell">Start Date </div>
				<div class="tbcell"><vuejs-datepicker v-model="project.start"></vuejs-datepicker></div>
			<div class="tbcell">End Date</div>
				<div class="tbcell"><vuejs-datepicker name="end-date" v-model="project.end"></vuejs-datepicker></div>
			</div>
	
	    <div class="tbrow">
				<div class="tbcell">Project Manager: </div>
				<div class="tbcell">
					<input type=text placeholder='Input Project Manager' v-model='project.projManager'>
				</div>
			</div>
		</div>
		<div class="ttable">
			<div class="tbrow">
				<div class="tbcell midalign">Description</div>
				<div class="tbcell"><textarea v-model="project.description" rows=5 cols=100></textarea></div>
			</div>
		</div>
		<div class="ttable">
			<div class="tbrow">
				<div class="tbcell" v-if="project.isNewProject">
					<button @click="saveProjectSummary();"> Save </button>
				</div>
			</div>
		</div>
		<div class="fleft">
		<button class="nil" @click="addingTask=true;">새 작업 추가 </button>
		<button class="nil" @click="addingIssue=true;">새 이슈 추가 </button>
		</div>
		<div class="fright"></div>
		<div class="clear"></div>
		<div v-if="addingTask">
			<TaskNew :projectId="projid" v-on:updateResult="resultOfNewTask($event);"/>
		</div>
		<div v-else>
			<TaskList :projectId="projid" :showGanttChart="true"/>
		</div>

		<div >
			<Issue :project="project"
			></Issue>
		</div>

 </div>
</template>

<script>
import TaskList from "./TaskList.vue"
import TaskNew from "./TaskNew.vue"
import Issue from "./Issue.vue"
import Datepicker from "vuejs-datepicker"

export default {
  name: 'ProjectView',
	props:{
		projid: [Number,String],
		writer: {
			type: Object,
			default: loginUser,
		},
	},
	data () {
			return {
				project: {},
				tasks: [],
				addingTask: false,
			}
	},
  components: {
		'vuejs-datepicker': Datepicker,
		TaskList,
		TaskNew,
		Issue,
	},
	mounted: function () {
		console.log("projectView: ", this.projid);
		this.getProjectInfo();
		console.log("ProjectView: mounted");
	},
  methods: {
		getProjectInfo : function (){
			var apiuri = String.prototype.concat(location.origin, baseURL, '/api/project.php','?action=read&projectId=',this.projid);
			var self = this;
			this.axios.get(apiuri)
			.then(function (response) {
				console.log(response);
				if (response.data.error) {
					console.log("get list error", response.data.message);	
					self.errorMessage = response.data.message;	
					setTimeout(function() {self.clearMessage();}, 1000);
				} else {
					console.log("get list success", response.data.message);	
					//self.successMessage = response.data.message;	
					self.project = response.data.projects[0];
					console.log("Count: ", response.data.count);
				}
				//setTimeout(function() {self.clearMessage();}, 1000);
			});
		},
		resultOfNewTask: function (obj) {
			this.addingTask = false;
		},
		saveProjectSummary: function() {
			this.toDateString();
			var formData = this.toFormData(this.project_desc);
			console.log("form Data: ",formData);
			var apiuri = String.prototype.concat(location.origin,baseURL,'/api/project.php','?action=create');
			var self = this;
			this.axios.post(apiuri, formData)
			.then(function (response) {
				console.log(response);
				if (response.data.error) {
					console.log("create error", response.data.message);	
					self.errorMessage = response.data.message;	
				} else {
					console.log("create success", response.data.message);	
					self.successMessage = response.data.message;	
				}
				setTimeout(function() {self.clearMessage();}, 1000);
			});
		},
		toFormData: function (obj) {
			var formData = new FormData();
			for (var key in obj) {
				console.log(key);
				console.log(obj[key]);
				formData.append(key, obj[key]);
			}
			return formData;
		},
		clearMessage: function () {
			this.errorMessage = "";
			this.successMessage = "";
		},
		toDateString: function () {
			this.project.startDate = this.projtoDateFormat(this.project.start);
			this.project.endDate = this.projtoDateFormat(this.project.end);
		},
		projtoDateFormat: function (val) {
			var year = val.getFullYear();
			var month = val.getMonth() + 1;
			var days = val.getDate();
			return  year+'-'+month+'-'+days;
		}
  }
}
</script>

<style>
@import '../styles/spms_base.css';
</style>
