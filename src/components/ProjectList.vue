<template>
  <div id="project-list" class="center" style="width:100%;">
	  <h3>List of Projects</h3>
		<div class="modal" v-if="errorMessage || successMessage">
			<p class="errorMessage" v-if="errorMessage">
				{{errorMessage}}
			</p>
			<p class="successMessage" v-if="successMessage">
				{{successMessage}}
			</p>
		</div>
			
		<div class="ttable" v-if="projects" >
			<div class="tbrow head"> 
				<div class="tbcell">Name</div>
				<div class="tbcell">Code</div>
				<div class="tbcell">Start</div>
				<div class="tbcell">End</div>
				<div class="tbcell">Status</div>
				<div class="tbcell">Description</div>
				<div class="tbcell"> </div>
				<div class="tbcell"> </div>
			</div>
			<div class="tbbody" v-if="projects.length>0">
				<div class="tbrow" v-for="proj in projects" :key="proj.id">
					<div class="tbcell">
						<router-link :to="{name: 'ProjectView', params: {projid: proj.id }}">
						{{proj.name}}
						</router>
					</div>
					<div class="tbcell">{{proj.code}}</div>
					<div class="tbcell">{{toDateString(proj.start)}}</div>
					<div class="tbcell">{{toDateString(proj.end)}}</div>
					<div class="tbcell">{{proj.status}}</div>
					<div class="tbcell">{{proj.description}}</div>
					<div class="tbcell">
							<button type="button" @click="selProj=proj; convertDate(selProj); showUpdateModal=true;" >Modify</button>
					</div>
					<div class="tbcell">
							<button type="button" @click="selProj=proj;convertDate(selProj); showDelModal=true;" >Delete</button>
					</div>
				</div>
			</div>
			<div class="tbrow" v-else>
				<div class="tbcell colspan">
					There is no proejct.
				</div>
			</div>
		</div>

		<div class="modal" id="delProjModal" v-if="showDelModal">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft"> Delete {{selProj.name}}</p>
					<button class="fright close" @click="showDelModal=false;">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<p> Are you sure to delete  project {{selProj.name}} ? </p>
					<button @click="deleteProject();showDelModal=false; ">YES</button>
					<button @click="showDelModal=false; ">No</button>
				</div>
			</div>
		</div>

		<div class="modal" id="updateProject" v-if="showUpdateModal">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft"> Update {{selProj.name}}</p>
					<button class="fright close" @click="showUpdateModal=false;">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<div class="ttable">
						<div class="tbrow"> 
							<div class="tbcell">Name</div>
							<div class="tbcell">
								<input type="text" v-model="selProj.name" placeholder="Input New Project Name">
							</div>
							<div class="tbcell"> Code</div>
							<div class="tbcell">
								<input type="text" v-model="selProj.code" placeholder="Input Project Code">
							</div>
						</div>
						<div class="tbrow">
						<div class="tbcell">Start Date </div>
							<div class="tbcell"><vuejs-datepicker name="start" v-model="selProj.start"></vuejs-datepicker></div>
						<div class="tbcell">End Date</div>
							<div class="tbcell"><vuejs-datepicker name="end" v-model="selProj.end"></vuejs-datepicker></div>
						</div>
				
						<div class="tbrow">
							<div class="tbcell">Project Manager: </div>
							<div class="tbcell">
								<input type=text placeholder='Input Project Manager' v-model='selProj.projManager'>
							</div>
						</div>
				
					</div>
					<div class="ttable">
						<div class="tbrow">
							<div class="tbcell midalign">Description</div>
							<div class="tbcell"><textarea v-model="selProj.description" rows=5 cols=50></textarea></div>
						</div>
					</div>
					<button @click="updateProject();showUpdateModal=false; ">Update</button>
					<button @click="showUpdateModal=false; ">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</template>
 
<script>

import Datepicker from 'vuejs-datepicker'
import ProjectView from './ProjectView.vue'

export default {
	name: 'ProjectList',

  components: {
		'vuejs-datepicker': Datepicker,
		ProjectView,
  },

  data () {
		return {
			projects: [],
			errorMessage: "",
			successMessage: "",
			showDelModal: false,
			showUpdateModal: false,
			selProj: {},
		}
	},
	computed: {
	},
	watch: {
	},
	mounted: function() {
		console.log("Mounted");
		if (this.$router) {
			console.log("Router object is not null\n");
		}
		this.getAllProjects();
	},
  methods: {
		convertDate: function (obj) {
			if ( obj === this.selProj ) {
				var sdstr = this.selProj.start;
				var edstr = this.selProj.end;
				this.selProj.start = new Date(sdstr);
				this.selProj.end = new Date(edstr);
			}	
		},
		toDateString: function (obj) {
			if (obj instanceof Date){
				var y = obj.getFullYear();
				var m = obj.getMonth() + 1;
				var d = obj.getDate();
				return y+'-'+m+'-'+d;
			} else {
				return obj;
			}
		},
		getAllProjects: function() {
			var apiuri = String.prototype.concat(location.origin, baseURL, '/api/project.php','?action=read');
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
					self.projects = response.data.projects;
					console.log("Count: ", response.data.count);
				}
			});
		},
		updateProject: function () {
			var self=this;
			var apiuri= String.prototype.concat(location.origin,baseURL, '/api/project.php','?action=update');
			console.log(apiuri);
			var formData = this.toFormData(this.selProj);
			this.axios.post(apiuri, formData)
				.then( function (response) {
					console.log(response);
					if(response.data.error) {
						self.errorMessage = response.data.message;
					} else {
						self.successMessage = response.data.message;
						self.getAllProjects();
					}
					setTimeout(function (){self.clearMessage();},1000);
				}
			);
		},
		deleteProject: function () {
			var self=this;
			var apiuri= String.prototype.concat(location.origin,baseURL,'/api/project.php','?action=delete');
			console.log(apiuri);
			var formData = this.toFormData(this.selProj);
			this.axios.post(apiuri, formData)
				.then( function (response) {
					console.log(response);
					if(response.data.error) {
						self.errorMessage = response.data.message;
					} else {
						self.successMessage = response.data.message;
						self.getAllProjects();
					}
					setTimeout(function (){self.clearMessage();},1000);
				}
			);
		},
		toFormData: function (obj) {
			var formData = new FormData();
			for (var key in obj) {
				console.log(key);
				console.log(obj[key]);
				if (obj[key] instanceof Date) {
					var dayStr = this.toDateString(obj[key]);
					formData.append(key, dayStr);
				} else {
					formData.append(key, obj[key]);
				}
			}
			return formData;
		},
		clearMessage: function () {
			this.errorMessage = "";
			this.successMessage = "";
		},
  }
}
</script>
  
<style>
@import '../styles/spms_base.css';
</style>
  
