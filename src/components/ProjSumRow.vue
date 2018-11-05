<template>
	 <div class="tbrow"> 
			<div class="tbcell">{{code}} </div>
			<div class="tbcell">{{title}} </div>
			<div class="tbcell">{{processStep}} </div>
			<div class="tbcell" v-html="prjstateimg"> </div>
			<div class="tbcell">{{issues}}</div>
	</div>
</template>
<script>
export default {
	name: 'ProjSumRow',
	props: ['code', 'title', 'processStep','prjstate','issues' ],
	computed: {
		prjstateimg: function () {
			var imgpath='<img src="./resources';
			imgpath = imgpath.concat('/',this.prjstate);
			imgpath = imgpath.concat('.','png" ></img>');
			return imgpath
		}
	}
};

</script>
<style>
@import '../styles/spms_base.css';
</style>
