<template>
  <div id="project-new" class="center" style="width:100%;margin-top:1em;">
	  <h3>New Project</h3>
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
					<input type="text" v-model="project_desc.name" placeholder="Input New Project Name">
				</div>
				<div class="tbcell"> Code</div>
				<div class="tbcell">
					<input type="text" v-model="project_desc.code" placeholder="Input Project Code">
				</div>
			</div>
			<div class="tbrow">
			<div class="tbcell">Start Date </div>
				<div class="tbcell"><vuejs-datepicker v-model="project_desc.start"></vuejs-datepicker></div>
			<div class="tbcell">End Date</div>
				<div class="tbcell"><vuejs-datepicker name="end-date" v-model="project_desc.end"></vuejs-datepicker></div>
			</div>
	
	    <div class="tbrow">
				<div class="tbcell">Project Manager: </div>
				<div class="tbcell">
					<input type=text placeholder='Input Project Manager' v-model='project_desc.projManager'>
				</div>
			</div>
	
		</div>
		<div class="ttable">
			<div class="tbrow">
				<div class="tbcell midalign">Description</div>
				<div class="tbcell"><textarea v-model="project_desc.description" rows=5 cols=100></textarea></div>
			</div>
		</div>
		<div class="ttable">
			<div class="tbrow">
				<div class="tbcell" v-if="project_desc.isNewProject">
					<button @click="saveProjectSummary();"> Save </button>
				</div>
			</div>
		</div>
	
	</div>
</template>
 
<script>
import Datepicker from 'vuejs-datepicker'

export default {
	name: 'ProjectNew',
  components: {
		'vuejs-datepicker': Datepicker,
  },
  data () {
		return {
			project_desc : {
				name: '',
				code: '',
				manager: '',
				start: new Date(),
				end: new Date(),
			  startDate: '',
				endDate: '',
				description: '',
				tasks: [ ],
				ganttChart: {},
				isNewProject: true,
				},
			errorMessage: "",
			successMessage: "",
			}
		},
	computed: {
	},
	watch: {
	},
  methods: {
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
					self.isNewProject = false;
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
			this.project_desc.startDate = this.projtoDateFormat(this.project_desc.start);
			this.project_desc.endDate = this.projtoDateFormat(this.project_desc.end);
		},
		projtoDateFormat: function (val) {
			var year = val.getFullYear();
			var month = val.getMonth() + 1;
			var days = val.getDate();
			return  year+'-'+month+'-'+days;
		}
  }
}
/***
var	ganttChart =  new Gantt("#ganttView", projApp.tasks, {
		on_click: function (task) {
			console.log(task);
		},
		on_date_change: function(task, start, end) {
			console.log(task, start, end);
		},
		on_progress_change: function (task, progress) {
			console.log(task, progress);
		},
		on_view_change: function (mode) {
			console.log(mode);
		},
		view_mode: 'Week',
		header_height: 40,
		bar_height: 20,
		date_format: 'YYYY-MM-DD',
		language: 'ko',
		step: 12,
	});
***/
</script>
<style>
@import '../styles/spms_base.css';
</style>
