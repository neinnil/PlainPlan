<template>
  <div id="task-list" class="center" style="width:100%;">
		<div class="modal" v-if="errorMessage || successMessage">
			<p class="errorMessage" v-if="errorMessage">
				{{errorMessage}}
			</p>
			<p class="successMessage" v-if="successMessage">
				{{successMessage}}
			</p>
		</div>
		<div class="ttable">
			<div class="tbrow" style="display: flex;">
			<div class="tbcell" style="max-width:50%; overflow:auto;">
				<div v-if="showGanttChart">&nbsp;</div>
				<div class="ttable">
					<div class="tbrow head" style="height:50px"> 
						<div class="tbcell">ID</div>
						<div class="tbcell">WBS</div>
						<div class="tbcell" style="min-width:10em;">Task</div>
						<div class="tbcell"> Progress</div>
						<div class="tbcell">Duration</div>
						<div class="tbcell" style="min-width:8em;">Start</div>
						<div class="tbcell" style="min-width:8em;">End</div>
						<!--
						<div class="tbcell">Assignee</div>
						<div class="tbcell">Precedence</div>
						<div class="tbcell">Successor</div>
						<div class="tbcell">Milestone</div>
						<div class="tbcell">Notes</div>
						//-->
					</div>
					<div class="tbrow" v-for="task in tasks" :key="task.id">
						<div class="tbcell" > {{task.id}}</div>	
						<div class="tbcell" > {{task.wbs}}</div>	
						<div class="tbcell" > {{task.name}} </div>	
						<div class="tbcell" > 
								<input type="text" v-model="task.progress" v-on:change="updateTask(task)" />
						</div>
						<div class="tbcell" > {{toDurationString(task.duration)}}</div>	
						<div class="tbcell" > {{toDateString(task.start)}}</div>	
						<div class="tbcell" > {{toDateString(task.end)}}</div>	
						<!--
						<div class="tbcell" > {{task.assigneeId}}</div>	
						<div class="tbcell" > {{task.precedenceTasks}}</div>	
						<div class="tbcell" > {{task.successorTasks}}</div>	
						<div class="tbcell" > {{task.isMilestone==1?"Y":""}}</div>
						<div class="tbcell" > {{task.note}}</div>
						//-->
					</div>
				</div>
				</div>
				<div class="tbcell" style="max-width:50%; overflow:auto;" v-if="showGanttChart">
					<div class="fleft">
						<button style="padding-right:1em;" @click="changeViewMode('Day');">Day</button>
						<button style="padding-right:1em;" @click="changeViewMode('Week');">Week</button>
						<button style="padding-right:1em;" @click="changeViewMode('Month');">Month</button>
					</div><div class="clear"></div>
					<div class="gantt-target" id="ganttView" style="max-width:50%; overflow:auto;"></div>
				</div>
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
		showGanttChart: {
			ype: [Boolean, String],
			default: false,
		},
	},
  data () {
		return {
			tasks: [],
			errorMessage: "",
			successMessage: "",
			ganttChart: {},
			bInitGantt: false,
		}
	},
	computed: {
	},
	watch: {
	}, 
	mounted: function (){
		console.log("Mounted");
		this.getAllTasks();
	},
  methods: {
		getAllTasks: function() {
			var apiuri = String.prototype.concat(location.origin,baseURL, '/api/tasks.php','?action=read&projectId=',this.projectId);
			var self = this;

			this.axios.get(apiuri)
			.then(function (response) {
				console.log(response);
				if (response.data.error) {
					console.log("read error", response.data.message);	
					self.errorMessage = response.data.message;	
					setTimeout(function() {self.clearMessage();}, 1000);
				} else {
					console.log("read success", response.data.message);	
					//self.successMessage = response.data.message;	
					self.tasks = response.data.tasks;
					self.convertDate();
					self.updateGantt();
				}
			});
		},
		updateTask: function (task) {
			var self = this;
			if (this.showGanttChart && this.bInitGantt ) {
				this.updateGantt();
			}
			var apiuri = String.prototype.concat(location.origin,baseURL, '/api/tasks.php','?action=update');
			var data = {
				'id': task.id,
				'name' : task.name,
				'startDate': this.toDateString(task.start),
				'endDate': this.toDateString(task.end),
				'duration': this.durToDB(task.start, task.end),
				'progress': task.progress,
			};
			var formData = this.toFormData(data);
			this.axios.post (apiuri, formData)
				.then(function (response) {
						console.log(response);
						if (response.data.error) {
							self.errorMessage = response.data.message;
						} else {
							self.successMessage = response.data.message;
						}
						setTimeout(function(){self.clearMessage();}, 1000);
						self.$emit('updateResult', response.data);
				});
		},

		convertDate() {
			this.tasks.forEach (function (el) {
					var sa = el.start.split(' ');
					var ea = el.end.split(' ');
					el.start = new Date(sa[0]+'T'+sa[1]);
					el.end = new Date(ea[0]+'T'+ea[1]);
			});
		},

		durToDB: function (start, end) {
				var durInSec = Math.floor((end-start)/1000);
				var day = Math.floor(durInSec/(24*3600))+1;
				var dHour = Math.floor(durInSec/3600);
				var dMin = Math.floor( (durInSec % 3600) / 60);
				var dSec = durInSec%60;
				return "PT"+dHour+"H"+dMin+"M"+dSec+"S";
			},

		initGantt () {
			var self = this;
			this.ganttChart = new Gantt ("#ganttView", this.tasks, {
					on_click: function (task) {
						console.log(task);
					},
          on_date_change: function(task, start, end) {
            console.log(task, start, end);
          },
          on_progress_change: function (task, progress) {
            console.log(task, progress);
						self.updateTask(task);
          },
          on_view_change: function (mode) {
            console.log(mode);
          },
          view_mode: 'Day',
          header_height: 40,
          bar_height: 16,
          date_format: 'YYYY-MM-DD',
          language: 'ko',
          step: 24,
      });
			this.bInitGantt = true;
		},

		updateGantt() {
			if (this.showGanttChart) {
				if (!this.bInitGantt) {
					this.initGantt();
				}
				this.ganttChart.refresh(this.tasks);
			}
		},
		changeViewMode(mode) {
			this.ganttChart.change_view_mode(mode);
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
		toDurationString: function (obj) {
				var reg=/\D/;
				var arr = obj.split(reg);
				var days = Math.floor(arr[2]/24);
				var hour = Math.floor(arr[2]%24);
				return days+'일';
		},
  },
}
</script>
<style>
@import '../styles/spms_base.css';
</style>
