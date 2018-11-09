<template>
<div id="resultView">
	<span>Result: {{resultCount}} </span>
</div>
</template>

<script>

export default {
	name: 'SearchResultView',
	data () {
		return {
			resultCount: 0,
		}
	},
}
</script>

<style>
@import "../style/spms_base.css"
</style>
