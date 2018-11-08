<template>  
<div id="issue_view">
	<div class="modal" v-if="errorMessage || successMessage">
		<p class="errorMessage" v-if="errorMessage">
			{{errorMessage}}
		</p>
		<p class="successMessage" v-if="successMessage">
			{{successMessage}}
		</p>
	</div>
	<button @click="mode='list'">List</button>
	<button @click="mode='create'">Create</button>
	<button @click="mode='view'">View</button>
	<button @click="mode='edit'">edit</button>
	<div id="IssueItem_list" v-if="mode==='list'">
		<div>List</div>
		<div class="ttable">
			<div class="tbrow head">
				<div class="tbcell"></div>	
				<div class="tbcell">Issue No</div>	
				<div class="tbcell">프로젝트 코드</div>	
				<div class="tbcell">상태</div>	
				<div class="tbcell">제목</div>
				<div class="tbcell">담당자</div>
				<div class="tbcell">위험도</div>
				<div class="tbcell">시급성</div>
				<div class="tbcell">Created Date</div>
				<div class="tbcell"> </div>
			</div>
			<div class="tbbody">
				<IssueItem v-for="issue in issues" 
					:key="issue.id"
					:mode="mode" 
					:issue="issue"
					:user="writer"
				></IssueItem>
			</div>
		</div>
	</div>
	<div id="IssueItem_new" v-else-if="mode==='create'">
		<div>New Issue</div>
		<IssueItem :mode="mode"
			:project="project"
			:user="writer"
			v-on:updateresult="updateResult($event)"
		></IssueItem>
	</div>
	<div id="IssueItem_detail" v-else-if="mode==='view'">
		<div>Detail View</div>
		<IssueItem :mode="mode"></IssueItem>
	</div>
	<div id="IssueItem_edit" v-else-if="mode==='edit'">
		<div>Edit an Issue</div>
		<IssueItem :mode="mode"></IssueItem>
	</div>
	<div id="IssueItem_other" v-else >
		<div> Opppps</div>
		<IssueItem></IssueItem>
	</div>
</div>
</template>

<script>

import IssueItem from './IssueItem.vue'

export default {
	name: 'IssueView',
  components: {
		IssueItem,
		vuejsDatepicker,
  },
	props: {
		writer: {},
		project: {},
	},
	data () { 
		return  {
			successMessage: '',
			errorMessage: '',
			mode: 'list',
			selissueitem: {},
			issues: [],
		}
	},
	computed: {
	},
	watch: {
	},
	mounted: function (){
		console.log("Mounted");
		if (this.mode == 'list') {
			this.getlistofissue();
		}
	},
  methods: {
		getlistofissue: function () {
			var self = this;
			var apiuri = String.prototype.concat(location.origin, baseURL, '/api/issue.php', '?action=read');
			axios.get(apiuri)
				.then( function (response) {
					if (response.data.error) {
					} else {
						self.issues = response.data.issues;	
					}
				} );
		},
		updateIssueItem: function (obj) {
			console.log("updateWorkNote... ");
			console.log(obj);
			this.mode='update';
			this.selissueitem = obj;
		},
		updateResult: function (obj) {
			this.mode = 'list';
			var self = this;
			if (obj.error) {
				this.errorMessage = obj.message;
			} else {
				this.successMessage = obj.message;
				//this.getlistofissue();
			}
			setTimeout(function (){self.clearMessage();self.getlistofissue();},1000);
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
});
</script>

<style>
@import '../styles/spms_base.css';
</style>
