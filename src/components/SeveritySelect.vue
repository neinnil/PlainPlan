<template>
	<div id="severityview" v-if="mode==='view'">
			{{toLevelString(level)}}
	</div>
	<div id="severityselect" v-else>
			<select v-model="selOpt">
				<option v-for="opt in options" :key="opt.value" :value="opt">
					{{opt.str}}
				</option>
			</select>
	</div>
</template>

<script>
export default {
	name: 'SeveritySelect',
	props: {
		mode: {
				type: String,
				default: 'select',
		},
		level: [Number, String],
	},
	data () {
		return {
			selOpt: {},
			options: [
				{value:4, str:"Critical"},
				{value:3, str:"Major"},
				{value:2, str:"Minor"},
				{value:1, str:"Trivial"}
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
			this.$emit('selecting', this.selOpt);
		}
	}
};
</script>
