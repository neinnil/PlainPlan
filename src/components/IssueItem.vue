
<template>
	<div id="issuecreate" v-if="mode==='create'" style="width:100%;">
	<div> <button @click="createIssue()"> 저장 </button> <button> 취소 </button> </div>
	<div class="ttable" style="width:90%">
		<div class="tbrow">
			<div class="tbcell"> 프로젝트 코드:</div>
			<div class="tbcell"> {{project.code}} </div>
			<div class="tbcell"> 프로젝트: </div>
			<div class="tbcell"> {{project.name}} </div>
		</div>
		<div class="tbrow">
			<div class="tbcell">위험도</div>
			<div class="tbcell">
				<SeveritySelect v-model="severity" :selOpt="severity"
					v-on:selecting="severity=$event;"
				></SeveritySelect>
			</div>
			<div class="tbcell">시급성</div>
			<div class="tbcell">
				<PrioritySelect v-model="priority" :selobj="priority" 
					v-on:selecting="priority=$event;"
				></PrioritySelect>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">담당자</div>
			<div class="tbcell">
				<UserSearch v-model="assignee" :user="assignee"></UserSearch>
			</div>
			<div class="tbcell">부서</div>
			<div class="tbcell" v-if="assignee">{{assignee.departmentName}}</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">보고자</div>
			<div class="tbcell">{{user.name}}</div>
			<div class="tbcell">보고 일자</div>
			<div class="tbcell">{{dateString(reportDate)}}</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">완료기한</div>
			<div class="tbcell noneB" style="max-width:150px;">
				<vuejs-datepicker v-model="duedate" style="max-width:150px;"></vuejs-datepicker>
			</div>
			<div class="tbcell">종료일</div>
			<div class="tbcell noneB" style="max-width:150px;">
				<vuejs-datepicker v-model="closeddate" style="max-width:150px;"></vuejs-datepicker>
			</div>
		</div>
	</div>
	<div class="ttable" style="width:90%">
		<div class="tbrow">
			<div class="tbcell" style="width: 15%;">상태</div>
			<div class="tbcell">
				<StatusSelect v-model="status" :selobj="status"
					v-on:selecting="status=$event;"
				></StatusSelect>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">제목</div>
			<div class="tbcell"><input type="text" name="title" v-model="title" placeholder="Issue title" style="width:100%"/></div>
		</div>
		<div class="tbrow">
			<div class="tbcell topalign">이슈내용</div>
			<div class="tbcell"><textarea name="description" v-model="description" value="" rows="10" style="width:100%"></textarea></div>
		</div>
		<div class="tbrow">
			<div class="tbcell">추가 내용</div>
			<div class="tbcell"><input type="text" name="comment" v-model="comment" placeholder="Commnet" style="width:100%"/></div>
		</div>

		<div class="tbrow">
			<div class="tbcell topalign">재발방지대책</div>
			<div class="tbcell"><textarea name="prevent" v-model="prevent" value="" rows="10" style="width:100%"></textarea></div>
		</div>
		<div class="tbrow">
			<div class="tbcell topalign">첨부파일</div>
			<div class="tbcell">추후 구현 예정</div>
		</div>
	</div>
	<div> <button @click="createIssue()"> 저장 </button> <button> 취소 </button> </div>
</div>
<div id="issueview" v-else-if="mode==='view'">
	<div class="ttable" style="width:100%">
		<div class="tbrow">
			<div class="tbcell"> 프로젝트 코드:</div>
			<div class="tbcell"> 프로젝트 코드 Value </div>
			<div class="tbcell"> 프로젝트: </div>
			<div class="tbcell"> 프로젝트 Str</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">위험도</div>
			<div class="tbcell">
				<select>
					<option>Critical</option>
					<option>Major</option>
					<option>Minor</option>
					<option>Trivial</option>
				</select>
			</div>
			<div class="tbcell">시급성</div>
			<div class="tbcell">
				<select>
					<option>Urgent</option>
					<option>High</option>
					<option>Medium</option>
					<option>Low</option>
				</select>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">담당자</div>
			<div class="tbcell">None</div>
			<div class="tbcell">부서</div>
			<div class="tbcell">None</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">보고자</div>
			<div class="tbcell">{{user.name}}</div>
			<div class="tbcell">보고 일자</div>
			<div class="tbcell">{{reportDate}} </div>
		</div>
		<div class="tbrow">
			<div class="tbcell">완료기한</div>
			<div class="tbcell noneB" style="max-width:150px;">
				<vuejs-datepicker v-model="duedate" style="max-width:150px;"></vuejs-datepicker>
			</div>
			<div class="tbcell">종료일</div>
			<div class="tbcell noneB" style="max-width:150px;">
				<vuejs-datepicker v-model="closeddate" style="max-width:150px;"></vuejs-datepicker>
			</div>
		</div>
	</div>
	<div class="ttable" style="width:100%">
		<div class="tbrow">
			<div class="tbcell" style="width: 15%;">상태</div>
			<div class="tbcell">
				<select>
					<option> Opened</option>
					<option> Assigned</option>
					<option> In progress</option>
					<option> Resolved</option>
					<option> Closed</option>
				</select>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">제목</div>
			<div class="tbcell"><input type="text" name="title" value="Issue title" style="width:100%"/></div>
		</div>
		<div class="tbrow">
			<div class="tbcell topalign">이슈내용</div>
			<div class="tbcell"><textarea name="description" value="" rows="10" style="width:100%"></textarea></div>
		</div>
		<div class="tbrow">
			<div class="tbcell">추가 내용</div>
			<div class="tbcell"><input type="text" name="comment" value="Commnet" style="width:100%"/></div>
		</div>
		<div class="tbrow">
			<div class="tbcell topalign">재발방지대책</div>
			<div class="tbcell"><textarea name="prevent" value="" rows="10" style="width:100%"></textarea></div>
		</div>
		<div class="tbrow">
			<div class="tbcell topalign">첨부파일</div>
			<div class="tbcell">추후 구현 예정</div>
		</div>
	</div>
</div>
<div id="issueedit" v-else-if="mode==='edit'">
	<div class="ttable" style="width:100%">
		<div class="tbrow">
			<div class="tbcell"> 프로젝트 코드:</div>
			<div class="tbcell"> 프로젝트 코드 Value </div>
			<div class="tbcell"> 프로젝트: </div>
			<div class="tbcell"> 프로젝트 Str</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">위험도</div>
			<div class="tbcell">
				<select>
					<option>Critical</option>
					<option>Major</option>
					<option>Minor</option>
					<option>Trivial</option>
				</select>
			</div>
			<div class="tbcell">시급성</div>
			<div class="tbcell">
				<select>
					<option>Urgent</option>
					<option>High</option>
					<option>Medium</option>
					<option>Low</option>
				</select>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">담당자</div>
			<div class="tbcell">None</div>
			<div class="tbcell">부서</div>
			<div class="tbcell">None</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">보고자</div>
			<div class="tbcell">{{user.name}}</div>
			<div class="tbcell">보고 일자</div>
			<div class="tbcell">{{reportDate}} </div>
		</div>
	</div>
	<div class="ttable" style="width:100%">
		<div class="tbrow">
			<div class="tbcell" style="width: 15%;">상태</div>
			<div class="tbcell">
				<select>
					<option> Opened</option>
					<option> Assigned</option>
					<option> In progress</option>
					<option> Resolved</option>
					<option> Closed</option>
				</select>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell">제목</div>
			<div class="tbcell"><input type="text" name="title" value="Issue title" style="width:100%"/></div>
		</div>
		<div class="tbrow">
			<div class="tbcell topalign">이슈내용</div>
			<div class="tbcell"><textarea name="description" value="" rows="10" style="width:100%"></textarea></div>
		</div>
		<div class="tbrow">
			<div class="tbcell">추가 내용</div>
			<div class="tbcell"><input type="text" name="comment" value="Commnet" style="width:100%"/></div>
		</div>
		<div class="tbrow">
			<div class="tbcell">종료일</div>
			<div class="tbcell noneB" style="max-width:150px;">
				<vuejs-datepicker v-model="closeddate" style="max-width:150px;"></vuejs-datepicker>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell topalign">재발방지대책</div>
			<div class="tbcell"><textarea name="prevent" value="" rows="10" style="width:100%"></textarea></div>
		</div>
		<div class="tbrow">
			<div class="tbcell topalign">첨부파일</div>
			<div class="tbcell">추후 구현 예정</div>
		</div>
	</div>
</div>
<div id="issuelist" class="tbrow" v-else-if="mode==='list'">
		<div class="tbcell"></div>	
		<div class="tbcell">{{issue.id}}</div>	
		<div class="tbcell">{{projectData.code}}</div>	
		<div class="tbcell">
				<StatusSelect :mode="'view'" :level="issue.status"></StatusSelect>
		</div>
		<div class="tbcell">{{issue.title}}</div>
		<div class="tbcell">{{assignee?assignee.name:""}}</div>
		<div class="tbcell">
			<SeveritySelect :mode="'view'" :level="issue.severity"></SeveritySelect>		
		</div>
		<div class="tbcell">
			<PrioritySelect :mode="'view'" :level="issue.priority"></PrioritySelect>		
		</div>
		<div class="tbcell">{{issue.createdDate}}</div>
		<div class="tbcell">	
					<button>Edit</button>
		</div>
</div>
<div id="issueblank" v-else>
<h1>Blank</h1>
</div>
</template>
<script>
import SeveritySelect from './SeveritySelect.vue'
import PrioritySelect from './PrioritySelect.vue'
import StatusSelect from './StatusSelect.vue'
import UserSearch from './UserSearch.vue'
import Datepicker from 'vuejs-datepicker'

export default {
	name : 'IssueItem',

	props: {
				user: {
					type: Object,
					default: null,
				},
				project: {
					type: Object,
					default: null,
				},
				mode: {
					type: String,
					default: 'list',
				},
				issue: {
					type: Object,
					default: null,
				},	
			},
		data () {
			return {
					issueno: '',
					projectData: {id: '', name:'', code:'',},
					status: {},
					title: '',
					assignee: {},
					severity: {},
					priority: {},
					createdDate: '',
					closeddate: '',
					reportDate: '',
					rootCause: '',
					department: '',
					description: '',
					comment: '',
					duedate: '',
					prevent: '',
					task: {id:'', name:'', },
					issuer: {},
				};
		},
		components: {
			'vuejs-datepicker': Datepicker,
			UserSearch,
			StatusSelect,
			SeveritySelect,
			PrioritySelect,
		},
		computed: {
		},
		watch: {
			assignee: function (){
				this.department = "Meta TNB";
			},
			priority: function () {
				console.log("priority changed: ", this.priority);
			},
			severity: function () {
				console.log("severity changed: ", this.severity);
			},
		},
		mounted: function () {
			if (this.mode == 'list'){
				console.log("mounted: list");
				this.issueno = this.issue.id;
				this.projectData.id = this.issue.projectId;
				this.title = this.issue.title;
				//this.status = {value: issue.status, str:
				//this.severity = issue.severity
				//issue.createdDate
				this.getProjectShortInfo(this.issue.projectId);
				this.getUserInfo(this.issue.assigneeId, this.assignee);
			} else if (this.mode == 'edit') {
			} else if (this.mode == 'create') {
				this.reportDate = new Date();
			} else if (this.mode == 'view') {
			} else {
			}
		},
		methods: {
			getProjectShortInfo: function(prjid) {
				var self = this;
				var apiuri = String.prototype.concat(location.origin, baseURL, '/api/project.php', '?action=read&id=', prjid);
				this.axios.get(apiuri)
					.then (function (response) {
							if(!response.data.error && response.data.count > 0){
								self.projectData.code = response.data.projects[0].code;
								self.projectData.name = response.data.projects[0].name;
							}
						});
			},
			getUserInfo: function(uid, obj) {
				var self = this;
				var apiuri = String.prototype.concat(location.origin, baseURL, '/api/user.php', '?action=read&id=', uid);
				this.axios.get(apiuri)
					.then (function (response) {
							if(!response.data.error && response.data.count > 0 ){
								if (obj === self.assignee) {
									self.assignee = response.data.users[0];
								} else if (obj === self.issuer) {
									self.user = response.data.users[0];
								}
							}
						});
			},
			createIssue: function () {
			var self = this;
			var apiuri = String.prototype.concat(location.origin, baseURL, '/api/issue.php', '?action=create');
			console.log(this.severity);
			console.log(this.proirty);
			var data = {
				'userId': this.user.id,
				'projectId': this.project.id,
				'taskId': this.task.id,
				'assigneeId': this.assignee.id,
				'title': this.title,
				'status': this.status.value,
				'severity': this.severity.value,
				'priority': this.priority.value,
				'reportedDate': this.reportedDate,
				'rootCause': this.rootCause,
				'description': this.description,
				'comment': this.comment,
				'duedate': this.dateTimeString(this.duedate),
				'prevent': this.prevent,
				'closeddate': this.dateTimeString(this.closeddate),
				}
				var formData = this.toFormData(data);
				console.log(formData);
				this.axios.post (apiuri, formData)
					.then (function (response) {
							self.$emit('updateresult',{'error':response.data.error,'message':response.data.message});
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
			dateString(d) {
				/* check object type is Date. */
				if ( d instanceof Date) {
					var year = d.getFullYear();
					var month = d.getMonth() + 1;
					var days = d.getDate();
					return year+'-'+month+'-'+days;
				} else {
					return '';
				}
			},
			dateTimeString(d) {
				if( d instanceof Date) {
					var year = d.getFullYear();
					var month = d.getMonth() + 1;
					var days = d.getDate();
					var hour = d.getHours();
					var min = d.getMinutes();
					var sec = d.getSeconds();
					return year+'-'+month+'-'+days+' '+hour+":"+min+":"+sec ;	
				} else {
					return "";
				}
			},
		},
};
</script>
<style>
@import '../styles/spms_base.css';
</style>
