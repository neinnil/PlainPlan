<template>
	<div id="statusview" v-if="mode==='view'">
			{{toLevelString(level)}}
	</div>
	<div id="statusselect" v-else>
			<select v-model="selOpt">
				<option v-for="opt in options" :key="opt.value" :value="opt">{{opt.str}}</option>
			</select>
	</div>
</template>
<script>
export default {
	name: 'StatusSelect',
	props: {
		mode: {
				type: String,
				default: 'select',
		},
		level: [Number, String],
	},
	data () {
		return {
			selobj: {},
			selOpt: {},
			options: [
					{value:1, str:"Opened"},
					{value:2, str:"Assigned"},
					{value:3, str:"In Progress"},
					{value:4, str:"Resolved"},
					{value:5, str:"Closed"}, 
				],
		}
	},
	methods: {
		toLevelString: function (val) {
			var idx = this.options.findIndex( (e)=> {
				return (e.value == val);
			});
			if (idx<0) return "";
			return this.options[idx].str;	
		},
	},
	watch: {
		selOpt: function () {
			this.selobj = this.selOpt;
			console.log(this.selOpt);
			this.$emit('selecting', this.selOpt);
		}
	}
};
</script>
