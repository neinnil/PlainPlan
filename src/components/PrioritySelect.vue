<template>
	<div id="priorityview" v-if="mode==='view'">
			{{toLevelString(level)}}
	</div>
	<div id="priorityselect" v-else>
			<select v-model="selOpt">
				<option v-for="opt in options" :key="opt.value" :value="opt">
					{{opt.str}}
				</option>
			</select>
	</div>
</template>

<script>
export default {
	name: 'PrioritySelect',
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
					{value:4, str:"Urgent"},
					{value:3, str:"High"},
					{value:2, str:"Medium"},
					{value:1, str:"Low"} 
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
