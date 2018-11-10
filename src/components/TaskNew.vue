<template>
  <div id="task-new" class="center" style="width:100%;margin-top:1em;">
	  <h3>New Task: {{projectId}}</h3>
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
				<div class="tbcell">WBS</div>
				<div class="tbcell">
					<input type="text" v-model="taskitem.wbs" placeholder="Input WBS">
				</div>
			</div>
			<div class="tbrow">
				<div class="tbcell">Task</div>
				<div class="tbcell">
					<input type="text" v-model="taskitem.name" placeholder="Input New Task">
				</div>
			</div>
			<div class="tbrow">
				<div class="tbcell">Duration</div>
				<div class="tbcell"><input type="text" v-model="taskitem.duration"/></div>
			</div>
			<div class="tbrow">
				<div class="tbcell">Start Date </div>
				<div class="tbcell"><vuejs-datepicker name="start" v-model="taskitem.start"></vuejs-datepicker></div>
			</div>
			<div class="tbrow">
				<div class="tbcell">End Date</div>
				<div class="tbcell"><vuejs-datepicker name="end" v-model="taskitem.end"></vuejs-datepicker></div>
			</div>
			<div class="tbrow">
				<div class="tbcell">Assignee</div>
				<div class="tbcell"><input type="text" v-model="taskitem.assignee"/></div>
			</div>
			<div class="tbrow">
				<div class="tbcell">Precedence</div>
				<div class="tbcell"><input type="text" v-model="taskitem.precedence"/></div>
			</div>
			<div class="tbrow">
				<div class="tbcell">Successor</div>
				<div class="tbcell"><input type="text" v-model="taskitem.successor"/></div>
			</div>
			<div class="tbrow">
				<div class="tbcell">Milestone</div>
				<div class="tbcell">
					<select v-model="taskitem.isMilestone">
						<option value="false" selected>No</option>
						<option value="true">Yes</option>
					</select>
				</div>
			</div>
		</div>
		<div class="ttable">
			<div class="tbrow">
				<div class="tbcell midalign">Note</div>
				<div class="tbcell"><textarea v-model="taskitem.note" rows=5 cols=100></textarea></div>
			</div>
		</div>
		<div class="ttable">
			<div class="tbrow">
				<div class="tbcell" v-if="taskitem.isNewTask">
					<button @click="taskitemSave();"> Save </button>
				</div>
			</div>
		</div>
	</div>
</template>
 
<script>
import Datepicker from 'vuejs-datepicker'

export default {
	name: 'TaskNew',
  components: {
		'vuejs-datepicker': Datepicker,
  },
	props: {
		projectId: {
			type: [Number, String],
			default: 1,
		},
		project: Object,
	},
  data () {
		return {
			taskitem : {
					id: '',
					projectId: '',
					name: '',
					parentId: '',
					taskId: '',
					wbs: '',
					parentTaskId: '',
					upTaskId: '',
					downTaskId: '',
					start: new Date(),
					end: new Date(),
					duration: '',
					startDate: '',
					endDate: '',
					assigneeId: [],
					successor: [],
					precedence: [],
					note: '',
					isMilestone: false,
					isNewTask: true,
				},
				errorMessage: "",
				successMessage: "",
				ganttChart: {},
			}
	},
	computed: {
		projname: function () {
			return "Dummy Project"
		},
		duration: function() {
			return Math.round((this.taskitem.end - this.taskitem.start)/(24*60*60*1000) + 1.0);
		},
	},
	watch: {
			duration: function () {
				var day = this.duration;
				var durInSec = (this.taskitem.end - this.taskitem.start)/1000;
				var dHour = Math.floor(durInSec/3600);
				var dMin = Math.floor( (durInSec % 3600) / 60);
				var dSec = durInSec%60;
				this.taskitem.duration = "PT"+dHour+"H"+dMin+"M"+dSec+"S";
			},
	},
  methods: {
		taskitemSave: function() {
			this.taskitem.startDate = this.toDateString(this.taskitem.start);
			this.taskitem.endDate = this.toDateString(this.taskitem.end);
			this.taskitem.projectId = this.projectId;
//			this.taskitem.duration = (this.taskitem.end - this.taskitem.start);
			var formData = this.toFormData(this.taskitem);
			console.log("form Data: ",formData);
			var apiuri = String.prototype.concat(location.origin,baseURL, '/api/tasks.php','?action=create');
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
				self.$emit('updateResult', response.data);
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
		toDateString: function (obj) {
			if (obj instanceof Date) {
				var year = obj.getFullYear();
				var month = obj.getMonth() + 1;
				var days = obj.getDate();
				return  year+'-'+month+'-'+days;
			} else {
				return obj;
			}
		},
  },
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
