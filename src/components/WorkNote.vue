<template>
<div id="worknotes">
		<div class="modal" v-if="errorMessage || successMessage">
			<p class="errorMessage" v-if="errorMessage">
				{{errorMessage}}
			</p>
			<p class="successMessage" v-if="successMessage">
				{{successMessage}}
			</p>
		</div>
		<div>
				<button @click="mode='input';">+Worknotes</button>
				<button @click="mode='list';getWorkNoteItems();">show list</button>
		</div>
		<div id="inputworkitem" v-if="mode=='input'">
			<work-note-item 
				:writer="writer" 
				:projects="projects" 
				:mode="mode"
				v-on:updateresult="updateResult($event)"
			></work-note-item>
		</div>
		<div class="modal" id="updateWorknote" v-else-if="mode==='update'">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft"> Update </p>
					<button class="fright close" 
							@click="mode='list';">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<work-note-item 
						:mode="mode" 
						:worknote="selworknote" 
						:projects="projects" 
						:writer="writer"
						v-on:updateresult="updateResult($event)"
					></work-note-item>
				</div>
			</div>
		</div>
		<div class="modal" id="deleteWorknote" v-else-if="mode==='delete'">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft"> Delete </p>
					<button class="fright close" 
							@click="mode='list';">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<work-note-item 
						:mode="mode" 
						:worknote="selworknote" 
						:projects="projects" 
						:writer="writer"
						v-on:updateresult="updateResult($event)"
					></work-note-item>
				</div>
			</div>
		</div>
		<div id="listofworknoteitem" v-else>
			<h1> List of worknotes </h1>
			<div class="ttable">
				<div class="tbrow head">
					<div class="tbcell"> ID </div>
					<div class="tbcell"> Writer </div>
					<div class="tbcell"> Project Code </div>
					<div class="tbcell"> Task Id</div>
					<div class="tbcell"> Working Hours </div>
					<div class="tbcell" style="min-width:20em;"> Today </div>
					<div class="tbcell" style="min-width:20em;"> Next Day </div>
					<div class="tbcell"> </div>
				</div>
				<div class="tbbody">
				<work-note-item v-for="item in worknoteitems" :key="item.id" :mode="mode"
					:worknote="item" 
					v-on:updateworknote="updateWorkNote($event)"
					v-on:deleteworknote="deleteWorkNote($event)"
					> </work-note-item>
				</div>
			</div>
		</div>
</div>
</template>

<script>
import WorkNoteItem from './WorkNoteItem'

export default {
	name: 'WorkNote',
	props: {
		writer: {
			type: Object,
			default: loginUser,
		}
	},
	data () {
		return {
			worknoteitems:[],
			projects: [
					{id: 1, code: 'sn18xx0', name:'prj1', tasks: [ {id: 1, name: 'test 1',}, {id: 2, name: 'test 2'}] }, 
					{id: 2, code: 'sn18xx1', name:'prj2', tasks: [ {id: 1, name: 'projtest 1'}, {id: 2, name: 'projtest 2'}, {id: 3, name: 'submarine'}]}
				 ],
			successMessage: '',
			errorMessage: '',
			mode: 'list',
			selworknote: {},
		}
	},
  components: {
		'work-note-item': WorkNoteItem,
  },
	computed: {
	},
	watch: {
	},
	mounted: function (){
		console.log("Mounted");
		if (this.mode == 'list') {
			this.getWorkNoteItems();
		}
	},
  methods: {
		updateWorkNote: function (obj) {
			console.log("updateWorkNote... ");
			console.log(obj);

			this.mode='update';
			this.selworknote = obj;
		},
		deleteWorkNote: function (obj) {
			console.log("updateWorkNote... ");
			console.log(obj);

			this.mode='delete';
			this.selworknote = obj;
		},
		getWorkNoteItems: function () {
			var self = this;
			var apiuri = String.prototype.concat(location.origin, baseURL, '/api/worknote.php', '?action=read');
			this.axios.get(apiuri)
				.then (function (response) {
						console.log(response);
						if(response.data.error) {
							self.errorMessage = response.data.message;
							self.worknoteitems = [];
							setTimeout(function (){self.clearMessage();},2000);
						} else {
							//self.successMessage = response.data.message;
							self.worknoteitems = response.data.notes;
						}
					} );
		},
		updateResult: function (obj) {
			this.mode = 'list';
			var self = this;
			if (obj.error) {
				this.errorMessage = obj.message;
				setTimeout(function (){self.clearMessage();self.getWorkNoteItems();},1000);
			} else {
				//this.successMessage = obj.message;
				this.getWorkNoteItems();
			}
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
</script>
<style>
@import '../styles/spms_base.css';
</style>
