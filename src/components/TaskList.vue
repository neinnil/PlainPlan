<template>
  <div id="task-list" class="center" style="width:100%;">
	  <h3>Task List: {{projname}}</h3>
		<div class="modal" v-if="errorMessage || successMessage">
			<p class="errorMessage" v-if="errorMessage">
				{{errorMessage}}
			</p>
			<p class="successMessage" v-if="successMessage">
				{{successMessage}}
			</p>
		</div>
			
		<div class="ttable">
			<div class="tbrow head"> 
				<div class="tbcell">ID</div>
				<div class="tbcell">WBS</div>
				<div class="tbcell">Task</div>
				<div class="tbcell">Duration</div>
				<div class="tbcell">Start Date </div>
				<div class="tbcell">End Date</div>
				<div class="tbcell">Assignee</div>
				<div class="tbcell">Precedence</div>
				<div class="tbcell">Successor</div>
				<div class="tbcell">Milestone</div>
				<div class="tbcell">Notes</div>
			</div>
			<div class="tbrow" v-for="task in tasks" :key="task.id">
				<div class="tbcell" > {{task.id}}</div>	
				<div class="tbcell" > {{task.wbs}}</div>	
				<div class="tbcell" > {{task.name}} </div>	
				<div class="tbcell" > {{task.duration}}</div>	
				<div class="tbcell" > {{task.start}}</div>	
				<div class="tbcell" > {{task.end}}</div>	
				<div class="tbcell" > {{task.assigneeId}}</div>	
				<div class="tbcell" > {{task.precedenceTasks}}</div>	
				<div class="tbcell" > {{task.successorTasks}}</div>	
				<div class="tbcell" > {{task.isMilestone==1?"Y":""}}</div>
				<div class="tbcell" > {{task.note}}</div>
			</div>
		</div>
	</div>
</template>
  
<script>

export default {
	name: 'TaskList',
//  components: {
//		vuejsDatepicker,
//  },
	props: {
		projectId: {
			type: [Number, String],
			default: 1,
		},
	},
  data () {
		return {
			tasks: [],
			errorMessage: "",
			successMessage: "",
			ganttChart: {},
		}
	},
	computed: {
		projname: function () {
			return "Dummy Project"
		},
	},
	watch: {
			duratoin: function () {
				this.taskitem.duration = this.duration;
			}
	},
	mounted: function (){
		console.log("Mounted");
		this.getAllTasks();
	},
  methods: {
		getAllTasks: function() {
			var apiuri = String.prototype.concat(location.origin,baseURL, '/api/tasks.php','?action=read');
			var self = this;

			this.axios.get(apiuri)
			.then(function (response) {
				console.log(response);
				if (response.data.error) {
					console.log("read error", response.data.message);	
					self.errorMessage = response.data.message;	
				} else {
					console.log("read success", response.data.message);	
					self.successMessage = response.data.message;	
					self.tasks = response.data.tasks;
				}
				setTimeout(function() {self.clearMessage();}, 3000);
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
			this.taskitem.startDate = this.projtoDateFormat(this.taskitem.start);
			this.taskitem.endDate = this.projtoDateFormat(this.taskitem.end);
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
