<template>
	<div id="userselect">
			<input type="text" v-model="searchtext" @keyup="search();" 
						@keydown.enter.prevent=""
						@keyup.enter.prevent="enterItem"
			/><br/>
			<select v-if="showselect" v-model="obj" :size="optleng">
				<option v-for="opt in options" :key="opt.id" :value="opt">
					{{opt.name}}
				</option>
			</select>
	</div>
</template>
<script>
export default {
	name: 'UserSearch',
	data () {
		return {
			user: null,
			searchtext: '',
			showselect: false,
			options: [],
			optleng: 0,
			obj: {},
		}
	},
	watch: {
		obj: function () {
			console.log("watching obj");
			this.showselect = false;
			this.user = this.obj;
			this.options = [];
			this.optleng = 0;
			this.$emit('input',this.user);
			this.$emit('select',this.user);
			console.log("this.options.length: ", this.options.length);
		},
	},
	methods: {
		enterItem () {
			this.search();
			if( this.options.length > 1) {
				this.showselect = true;
			} else if (this.options.length == 1) {
				this.obj = this.options[0];
			} else {
				
			}
		},
		search: function() {
			console.log(this.searchtext);
			if(this.searchtext.length > 0){
			var self = this;
			var name = this.searchtext;
			var apiuri = String.prototype.concat(location.origin,baseURL, '/api/user.php','?action=read&name=',name);
			this.axios.get(apiuri)
				.then (function (response) {
					console.log("response data message: ", response.data.message);
					if (response.data.error) {
						self.showselect = false;
						self.options = [];
					} else if(response.data.count==1){ 
						self.obj = response.data.users[0];
						self.showselect = false;
					} else {
						self.showselect = true;
						self.options = response.data.users;
						self.optleng = self.options.length;
					}
				});
			}
		}
	},

};
</script>
