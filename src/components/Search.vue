<template>
<div id="searching-form-layout">
<!-- Search field //-->
<div class="ttable">

	<div class="tbody">
		<div class="tbrow">
			<div class="tbcell"><label>Project Code</label></div>
			<div class="tbcell">
				<input type="text" name="prjcode" value=""/>
			</div>
			<div class="tbcell"><label>Department </label></div>
			<div class="tbcell">
				<input type="text" name="deptname" value="" />
			</div>
			<div class="tbcell"> <label>Process Step</label></div>
			<div class="tbcell">
				<input type="text" name="prosstep" value=""/>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell"> <label>Project Name</label></div>
			<div class="tbcell">
				<input type="text" name="prjname" value=""/>
			</div>
			<div class="tbcell"> <label>Assignee </label></div>
			<div class="tbcell">
				<input type="text" name="assignee" value=""/>
			</div>
			<div class="tbcell"><label>State</label></div>
			<div class="tbcell">
				<input type="text" name="state" value=""/>
			</div>
		</div>
		<div class="tbrow">
			<div class="tbcell"> <label>Issue</label></div>
			<div class="tbcell">
				<input type="text" name="issue" value=""/>
			</div>
			<div class="tbcell"> <label>Duration </label></div>
			<div class="tbcell">
				<input type="text" name="deptname" value=""/>
			</div>
			<div class="tbcell"> <label>Process Step</label></div>
			<div class="tbcell">
				<input type="text" name="prosstep" value=""/>
			</div>
		</div>
	</div>
</div> <!-- table -->
<div v-if="isSearching">Waiting.... </div>
<div v-else>
<search-results></search-results>
</div>
</div>
</template>
<script>
import SearchResult from "./SearchResult.vue"

export default {
	name: 'SearchForm',
	components: {
		'search-results': SearchResult,
	},
	data () {
		return {
			isSearching: false,
		}
	},
}
</script>
<style>
@import "../style/spms_base.css"
</style>
