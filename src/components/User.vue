<template>
	<div id="user-list-view" class="container">
		<h3 class="fleft"> User List </h3>
		<button class="fright addNew" @click="showAddModal = true;"> Add New User</button>
		<div class="clear"></div>
		<hr>
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
				<div class="tbcell">&nbsp;</div>
				<div class="tbcell">ID</div>
				<div class="tbcell">Name</div>
				<div class="tbcell">email</div>
				<div class="tbcell">role</div>
				<div class="tbcell">Dept.</div>
				<div class="tbcell">Company</div>
				<div class="tbcell">Edit</div>
				<div class="tbcell">Delete</div>
			</div> <!-- end of tbrow -->
			<div class="tbrow" v-for="(user, index) in users" :key="user.id">
				<div class="tbcell">{{index}}</div>
				<div class="tbcell">{{user.id}}</div>
				<div class="tbcell">{{user.name}}</div>
				<div class="tbcell">{{user.email}}</div>
				<div class="tbcell">{{user.role}}</div>
				<div class="tbcell">{{user.departmentName}}</div>
				<div class="tbcell">{{user.companyName}}</div>
				<!--div class="tbcell">{{user.departmentId}}</div //-->
				<!--div class="tbcell">{{user.companyId}}</div //-->
				<div class="tbcell">
					<button @click="selUser=user;showEditModal=true;"> Edit </button></div>
				<div class="tbcell">
					<button @click="selUser=user;showDelModal=true;"> Delete </button></div>
			</div>
		</div> <!-- end of table -->
		<div class="modal" id="addUserModal" v-if="showAddModal">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft">Add New User</p>
					<button class="fright close" @click="showAddModal=false;resetNewUser();">X</button>
					<div class="clear"></div>
				</div> <!-- modalHeading -->
				<div class="modalContent">
					<div class="tbrow">
						<div class="tbcell">Name</div>
						<div class="tbcell">
						<input type="text" name="" v-model="newUser.name" />
						</div>
					</div>
					<div class="tbrow">
						<div class="tbcell">email</div>
						<div class="tbcell">
						<input type="text" name="" v-model="newUser.email"/>
						</div>
					</div>
					<div class="tbrow">
						<div class="tbcell">password</div>
						<div class="tbcell">
						<input type="text" name="" v-model="newUser.password"/>
						</div>
					</div>
					<div class="tbrow">
						<div class="tbcell">role</div>
						<div class="tbcell">
						<select v-model="newUser.role" style="padding: 2px 5px;">
							<option disabled value="">Please select on</option>
							<option v-for="role in roles" v-bind:key="role.value" v-bind:value="role.value">
							{{ role.text }} </option>
						</select>
						</div>
					</div>
					<div class="tbrow">
						<div class="tbcell">Company</div>
						<div class="tbcell">
						<select v-model="newUser.companyId" style="padding: 2px 5px;">
							<option disabled value="">Please select on</option>
							<option v-for="company in companies" v-bind:key="company.id"  v-bind:value="company.id">
							{{ company.name }} </option>
						</select>
						</div>
					</div>
					<div class="tbrow">
						<div class="tbcell">Dept.</div>
						<div class="tbcell">
						<input type="text" name="" v-model="newUser.departmentId"/></div>
					</div>
					<button @click="showAddModal=false; addNewUser(); ">SAVE</button>
				</div> <!-- end of modal content -->
			</div> <!-- end of modal container -->
		</div> <!-- end of modal -->

		<div class="modal" id="editUserModal" v-if="showEditModal">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft">Edit User</p>
					<button class="fright close" @click="showEditModal=false;">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<div class="tbrow">
						<div class="tbcell">Name</div>
						<div class="tbcell">
						<input type="text" name="" v-model="selUser.name"/></div>
					</div>
					<div class="tbrow">
						<div class="tbcell">email</div>
						<div class="tbcell">
						<input type="text" name="" v-model="selUser.email"/></div>
					</div>
					<div class="tbrow">
						<div class="tbcell">password</div>
						<div class="tbcell">
						<input type="text" name="" v-model="selUser.password"/></div>
					</div>
					<div class="tbrow">
						<div class="tbcell">role</div>
						<div class="tbcell">
						<select v-model="selUser.role" style="padding: 2px 5px;">
							<option disabled value="">Please select on</option>
							<option v-for="role in roles" v-bind:key="role.value" v-bind:value="role.value">
							{{ role.text }} </option>
						</select>
						</div>
					</div>
					<div class="tbrow">
						<div class="tbcell">Dept.</div>
						<div class="tbcell">
						<input type="text" name="" v-model="selUser.departmentId"/></div>
					</div>
					<div class="tbrow">
						<div class="tbcell">Company</div>
						<div class="tbcell">
						<input type="text" name="" v-model="selUser.companyId"/></div>
					</div>
					<button @click="showEditModal=false; updateUser(); ">UPDATE</button>
				</div>
			</div>
		</div> <!-- end of modal -->
		<div class="modal" id="delUserModal" v-if="showDelModal">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft">Deleate</p>
					<button class="fright close" @click="showDelModal=false;">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<p>Are you sure to delete {{selUser.name}} ? </p>
					<button @click="showDelModal=false;delUser(); ">YES</button>
				</div>
			</div>
		</div> <!-- end of modal -->
	</div> <!-- end of user-list-view -->
</template>

<script>
/* eslint-disable */
export default {
	name: 'User',
	data ()	{
		return {
			showAddModal: false,
			showEditModal: false,
			showDelModal: false,
			errorMessage: "",
			successMessage: "",
			users: [],
			newUser: {name:'', email:'', password:'', role:'user',departmentId:'',companyId:''},
			selUser: {},
			companies: [],
			departs:[],
		}
	},

	computed:{
		apibaseuri: function () {
			return String.prototype.concat(location.origin,baseURL,'/api/user.php');
		},
		roles: function () {
			return [{text:'Admin', value: 'admin'}, {text:'User', value:'user'}, {text:'Guest', value:'guest'}];
		},
	},

	mounted: function() {
		this.getCompanies();
		this.getAllUsers();
	},

	methods: {
		resetNewUser: function () {
			this.newUser.name='', this.newUser.email='', this.newUser.password='';
			this.newUser.role='user', this.newUser.departmentId='', this.newUser.companyId='';
		},
		getAllUsers: function() {
			var self = this;
			var apiuri = String.prototype.concat(this.apibaseuri,'?action=read');
			console.log(apiuri);
			this.axios.get(apiuri)
			.then (function (response) {
				console.log(response);
				if (response.data.error) {
					self.errorMessage = response.data.message;
				} else {
					self.users = response.data.users;
				}
				setTimeout(function(){self.clearMessage();}, 3000);
			});
		},
		addNewUser: function() {
			var self = this;
			var formData = this.toFormData(this.newUser);
			var apiuri = String.prototype.concat(this.apibaseuri,'?action=create');
			this.axios.post(apiuri, formData).then (function (response) {
				if (response.data.error) {
					self.errorMessage = response.data.message;
				} else {
					self.successMessage = response.data.message;
					self.getAllUsers();
					self.resetNewUser();
				}
				setTimeout(function(){self.clearMessage();}, 3000);
			});
		},
		delUser: function () {
			var self = this;
			var formData = this.toFormData(this.selUser);
			var apiuri = this.apibaseuri.concat('','?action=delete');
			this.axios.post(apiuri, formData).then (function (response) {
				if (response.data.error) {
					self.errorMessage = response.data.message;
				} else {
					self.successMessage = response.data.message;
					self.getAllUsers();
				}
				setTimeout(function(){self.clearMessage();}, 3000);
			});
		},
		updateUser: function () {
			var self = this;
			var formData = this.toFormData(this.selUser);
			var apiuri = this.apibaseuri.concat('','?action=update');
			this.axios.post(apiuri, formData).then (function (response) {
				if (response.data.error) {
					self.errorMessage = response.data.message;
				} else {
					self.successMessage = response.data.message;
					self.getAllUsers();
				}
				self.selUser = {};	
				setTimeout(function(){self.clearMessage();}, 3000);
			});
		},
		toFormData: function (obj) {
			var formData = new FormData();
			for (var key in obj) {
				formData.append(key, obj[key]);
			}
			return formData;
		},
		clearMessage: function () {
			this.errorMessage = "";
			this.successMessage = "";
		},
		getCompanies: function() {
			var self = this;
			var apiuri =  String.prototype.concat(location.origin,baseURL,'/api/company.php');
			this.axios.get(apiuri)
			.then (function (response) {
				console.log(response);
				if (response.data.error) {
					self.errorMessage = response.data.message;
				} else {
					self.companies = response.data.companies;
				}
				setTimeout(function(){self.clearMessage();}, 3000);
			});
		},
	}
}

</script>

<style scoped>
*{ margin: 0; padding: 0; }
.container{ width: 960px; margin: auto; margin-top: 60px; padding: 0.5em}
.container.headContents { background: #0000EF; opacity: 1; color: #FFFFFF; padding: 0.5em 1em, 0.5em 1em;}
.fleft{float: left;}
.fright{float: right;}
.clear{clear: both;}
h3{ font-size: 18px; }
h4{ font-size: 14px; }
.addNew {padding: 2px 9px}
.center {margin:auto; width: 40%; border: 1px solid #bbbbdd; padding: 10px;}
.middle {margin-top: 10%}
.ttable{display: table; table-layout:fixed; padding:3px}
.tbrow{display: table-row;}
.tbrow.head{background-color: #dddddd;}
.tbcell{display: table-cell; padding: 5px; border: none;}
.solbox{border: 1px solid;}
.tbcell.colspan {display: none; }
.tbbody{display: table-row-group;}
.tbhead{display: table-header-group; backgroud-color: #dddddd; padding: 5px;}
.topalign{vertical-align: top;}
.midalign{vertical-align: middle;}
.botalign{vertical-align: bottom;}
.signin {margin-bottom: 0.5em; margin-top: 1em; padding: 5px 5px 5px 5px;}
.gray {background-color:#dddddd;}
.noneB { border: none; }
table { border-collapse: collapse; border: solid thin; }
colgroup, tbody { border: solid thin; }
td { border: solid thin; height: 1.4em; text-align: left; padding: 0; }

.modal{ position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0, 0.4); }
.modalContainer { width: 555px; background: #FFFFFF; margin: auto; margin-top: 44px; }

.modalHeading { padding: 9px; background: #36367C; color: #FFFFFF; }
.modalContent { min-height: 333px; padding: 44px; }

.addNew { padding: 2px 9px; }

.close { background: #D73131; padding: 3px 9px; border: none; color: #FFFFFF}

p.successMessage {
background: #D8EFC2;
color: #097133;
border-left: 5px solid #097133;
padding: 9px;
margin: 22px 0;
}
p.errorMessage {
background: #EFCBC2;
color: #D71517;
border-left: 5px solid #DA1527;
padding: 9px;
margin: 22px 0;
}

.loginBtn {
	width: 40%;
	margin: 1em 2em;
	padding: 5px 5px 5px 5px;
}

input {
	border:none;
}
input[type="text"] {
	background-color: aliceblue;
}
input[type="password"] {
	background-color: aliceblue;
}
</style>
