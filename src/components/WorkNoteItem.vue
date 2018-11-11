<template>
		<div id="work-note-new" v-if="mode==='input'">
			<h3>Work Note: {{projectName}}</h3>
			<div class="ttable">
				<div class="tbrow head">
					<div class="tbcell">&nbsp;</div>
					<div class="tbcell"> Project Code </div>
					<div class="tbcell"> Task </div>
					<div class="tbcell"> Working Hours </div>
					<div class="tbcell" style="min-width:20em;"> Today </div>
					<div class="tbcell" style="min-width:20em;"> Next Day </div>
					<div class="tbcell">
					</div>
				</div>
				<!-- start of table body //-->
				<div class="tbbody">
					<div class="tbrow" > 
						<div class="tbcell"> </div> 
						<div class="tbcell"> 
							<select v-model="projectId">
								<option disabled value="">Please select one</option>
								<option v-for="proj in projects" v-bind:value="proj.id">{{proj.name}}</option>
							</select>
						</div> 
						<div class="tbcell">
							<select v-if="projectId" v-model="taskId">
								<option disabled value="">Please select one</option>
								<option v-for="task in tasks" v-bind:value="task.id"> {{task.name}}</option>
							 </select>
							<span v-else></span>
						</div> 
						<div class="tbcell"><input type="text" v-model="workingtime"></input></div>
						<div class="tbcell"><textarea v-model="today" cols="30"></textarea></div>
						<div class="tbcell"><textarea v-model="nextday" cols="30"></textarea></div>
						<div class="tbcell">
							<button type="button" @click="saveWorkNoteItem();">
								SAVE
							</button>
						</div>
					</div>
				</div> <!-- end of table body //-->
			</div> <!-- end of table //-->
		</div> <!-- end of work-note-input //-->

		<div id="work-note-update" v-else-if="mode==='update'">
			<h3>Work Note: {{projectName}}</h3>
			<div class="ttable">
				<div class="tbrow">
					<div class="tbcell head"> Project Code </div>
					<div class="tbcell"> 
						<select v-model="worknote.projectId">
							<option v-for="proj in projects" 
											:value="proj.id">{{proj.name}}</option>
						</select>
					</div> 
				</div>
				<div class="tbrow">
					<div class="tbcell"> Task </div>
					<div class="tbcell"> 
						<select v-if="worknote.projectId" v-model="worknote.taskId">
							<option v-for="task in tasks" :value="task.id">{{task.name}}</option>
						 </select>
						<span v-else></span>
					</div> 
				</div>
				<div class="tbrow">
					<div class="tbcell"> Working Hours </div>
					<div class="tbcell">
						<input type="text" v-model="worknote.workingtime"/>
					</div>
				</div>
				<div class="tbrow">
					<div class="tbcell"> Today </div>
					<div class="tbcell">
						<textarea v-model="worknote.today" cols="30"></textarea>
					</div>
				</div>
				<div class="tbrow">
					<div class="tbcell"> Next Day </div>
					<div class="tbcell">
							<textarea v-model="worknote.nextday" cols="30"></textarea>
					</div>
				</div>
				<div class="tbrow">
					<div class="tbcell"> </div>
					<div class="tbcell">
						<button type="button" @click="updateWorkNoteItem(worknote);">
							UPDATE
						</button>
					</div>
				</div>
				</div>
				<!-- start of table body //-->
			</div> <!-- end of table //-->
			
		</div>
		<div id="work-note-update" v-else-if="mode==='delete'">
			<div class="ttable">
				<div class="tbrow">
					<div class="tbcell head"> Project Code </div>
					<div class="tbcell"> {{worknote.projectId}}</div>
				</div>
				<div class="tbrow">
					<div class="tbcell"> Task </div>
					<div class="tbcell"> {{worknote.taskId}}</div>
				</div>
				<div class="tbrow">
					<div class="tbcell"> Working Hours </div>
					<div class="tbcell">{{worknote.workingtime}}</div>
				</div>
				<div class="tbrow">
					<div class="tbcell"> Today </div>
					<div class="tbcell">{{worknote.today}}</div>
				</div>
				<div class="tbrow">
					<div class="tbcell"> Next Day </div>
					<div class="tbcell">{{worknote.nextday}}</div>
				</div>
				<div class="tbrow">
					<div class="tbcell"> </div>
					<div class="tbcell">
						<button type="button" @click="deleteWorkNoteItem(worknote);">
							Delete
						</button>
					</div>
				</div>
				</div>
				<!-- start of table body //-->
			</div> <!-- end of table //-->
			
		</div>
		
		<div class="tbrow" id="work-note-list" v-else-if="mode==='list'">
				<div class="tbcell"> {{worknote.id}} </div>
				<div class="tbcell"> {{worknote.writername}} </div>
				<div class="tbcell"> {{worknote.projectname}} </div>
				<div class="tbcell"> {{worknote.taskname}} </div>
				<div class="tbcell"> {{worknote.workingtime}} </div>
				<div class="tbcell" style="min-width:20em;"> {{worknote.today}} </div>
				<div class="tbcell" style="min-width:20em;"> {{worknote.nextday}} </div>
				<div class="tbcell">
					<button @click="$emit('updateworknote',worknote);">Modify</button>
					<button @click="$emit('deleteworknote',worknote);">Delete</button>
				</div>
		</div> <!-- end of work-note-list //-->
		<div id="_work-note-blank" v-else>
			<p>Specify mode: "list" or "input"</p>
		</div>
	<!-- end of work-note //-->
</template>
<script>

export default {
	name: 'WorkNoteItem',

	props: {
		writer: {
			type: Object,
			default: loginUser,
		},
		projects: Array,
		mode: {
			type: String,
			default: 'list'
		},
		worknote: {
				type: Object, 
				default: null,
		},
	},
	data () {
		return {
			id: '',
			userId: '',
			projectId: '',
			taskId: '',
			today: '',
			nextday: '',
			workingtime: 8,
			writername: '',
			projectnae: '',
			taskname: '',
			tasks: [],
			project: {},
		}
	},
	computed: {
		projectName: function () {
			return 'Dummy Project';
		}
	},
	watch: {
		projectId: function (pid) {
			var pidx = this.projects.findIndex( (el)=> {
					return (el.id == this.pid);
				});
			this.project = this.projects[pidx];
			this.getTasks();
		},
		taskId: function (tid) {
			var pidx = this.projects.findIndex( (el)=> {
				return (el.id == this.projectId);
			} );
			var tidx = this.tasks.findIndex( (el)=> {
				return (el.id == tid);
			});
			this.name = String.prototype.concat(this.projects[pidx].name,'_',this.tasks[tidx].name,'_note');
		}
	},
	mounted: function (){
		console.log('Mounted');
		if((this.mode == 'delete' || this.mode == 'update') && this.worknote) {
			console.log('worknote exist');
			this.id = this.worknote.id;
			this.userId = this.worknote.userId;
			this.projectId = this.worknote.projectId;
			this.taskId = this.worknote.taskId;
			this.today = this.worknote.today;
			this.nextday = this.worknote.nextday;
			this.workingtime = this.worknote.workingtime;
			this.writername= this.worknote.writername;
			this.projectname = this.worknote.projectname;
			this.taskname = this.worknote.taskname;
			this.getTasks();
		}
  },
	methods: {
		getTasks: function () {
			var self = this;
			var apiuri = String.prototype.concat(location.origin,baseURL, '/api/tasks.php','?action=read&projectId=',this.projectId);
			this.axios.get(apiuri)
				.then(function (response) {
						if(response.data.error) {
							self.errorMessage = response.data.message;
							setTimeout(function(){self.clearMessage();},1000);
						} else {
							self.tasks = response.data.tasks;
						}
				});
		},
		saveWorkNoteItem: function () {
			var self = this;
			var apiuri = String.prototype.concat(location.origin, baseURL, '/api/worknote.php', '?action=create');
			if (this.userId === '') this.userId = this.writer.id;
			var data = {
					'writer': this.writer.id,
					'userId': this.userId,
					'projectId': this.projectId,
					'taskId': this.taskId,
					'name': this.name,
					'today': this.today,
					'nextday': this.nextday,
					'workingtime': this.workingtime * 10000,
					};
			var formData = this.toFormData(data);
			console.log(formData);
			this.axios.post (apiuri, formData)
				.then (function (response) {
						self.$emit('updateresult',{'error':response.data.error,'message':response.data.message});
				} );
		},
		deleteWorkNoteItem: function (obj) {
			var self = this;
			var apiuri = String.prototype.concat(location.origin, baseURL, '/api/worknote.php', '?action=delete');
			var data = {
					'id': obj.id,
					'writer': obj.writer,
					'userId': obj.userId,
					'projectId': obj.projectId,
					'taskId': obj.taskId,
					'name': obj.name,
					'today': obj.today,
					'nextday': obj.nextday,
					'workingtime': obj.workingtime,
					};
					console.log(data);
			var formData = this.toFormData(data);
			this.axios.post (apiuri, formData)
				.then (function (response) {
						self.$emit('updateresult',{'error':response.data.error,'message':response.data.message});
					} );
		},
		updateWorkNoteItem: function (obj) {
			var self = this;
			var apiuri = String.prototype.concat(location.origin, baseURL, '/api/worknote.php', '?action=update');
			var data = {
					'id' : obj.id,
					'writer': obj.writer,
					'userId': obj.userId,
					'projectId': obj.projectId,
					'taskId': obj.taskId,
					'name': obj.name,
					'today': obj.today,
					'nextday': obj.nextday,
					'workingtime': obj.workingtime,
					};
					console.log("updateWorkNoteItem..");
					console.log(data);
					var formData = this.toFormData(data);
					this.axios.post (apiuri, formData)
						.then (function (response) {
								self.$emit('updateresult',{'error':response.data.error,'message':response.data.message});
							} 
					);
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
		sendParent: function (evtname, obj) {
			console.log(evtname);
			console.log(obj);
			this.$emit(evtname, obj);
		},
	}
};
</script>

<style>
@import '../styles/spms_base.css';
</style>
