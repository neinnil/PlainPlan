<template>
<div class="ttable">
	<div class="tbhead">
		<div class="tbrow" style="background-color:#CCCCFF; border:1px solid">
			<div class="tbcell solbox">
				Project Code
			</div>
			<div class="tbcell solbox">
				Project Name
			</div>
			<div class="tbcell solbox">
				Process Step
			</div>
			<div class="tbcell solbox">
				Status
			</div>
			<div class="tbcell solbox">
				Issues
			</div>
		</div>
	</div>
	<div class="tbbody">
		<ProjSumRow
			v-for="(proj, index) in projects" :key="index"
			v-bind:code="proj.code"
			v-bind:title="proj.name"
			v-bind:process-step="proj.step"
			v-bind:prjstate="proj.state"
			v-bind:issues="proj.issues"
		></ProjSumRow>
	</div>
</div>
</template>

<script>

import ProjSumRow  from './ProjSumRow.vue'

export default {
	name: 'ProjSummary',
	components: {
		ProjSumRow,
	},
	data () {
		return  {
					projects:[
						{ code: '19NO020', name:"WhoHow", step:"developing", state:"green" , issues:"" },
						{ code: '19NO120', name:"Hole", step:"planning", state:"red" , issues:"3,4" },
						{ code: '18NO050', name:"whatwhat", step:"AS", state:"yellow" , issues:"" } ],
		};
	}
}
</script>
<style>
@import '../styles/spms_base.css';
</style>
