<template>
	<div id="selectOption" v-if="mode==='view'">
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
	name: 'SelectOption',
	props: {
		options: {
				type: Array,
				required: true,
		},
		mode: {
				type: String,
				default: 'select',
		},
		level: [Number, String],
	},
	data () {
		return {
			selOpt: {},
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
