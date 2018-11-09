<script>
import User from './components/User.vue'
import ProjSummary from './components/ProjSummary.vue'
import Issue from './components/Issue.vue'
import WorkNote from './components/WorkNote.vue'

var NotFoundPage = {
	template: `<div> Page is not found.</div>`
};
export  default  [
	{
		path:'/index.html', 
		component: ProjSummary
	},
	{
		path:'/', 
		component: ProjSummary
	},
	{
		path:'/User', 
		component: User
	},
	{	
		path:'/Issue',
		component: Issue
	},
	{
		path:'/WorkNote',
		component: WorkNote
	},
	{
		path: '*', 
		component: NotFoundPage
	},
];
</script>
