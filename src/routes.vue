<script>
import User from './components/User.vue'
import ProjSummary from './components/ProjSummary.vue'
import Issue from './components/Issue.vue'
import WorkNote from './components/WorkNote.vue'
import ProjectList from './components/ProjectList.vue'
import ProjectNew from './components/ProjectNew.vue'
import TaskList from './components/TaskList.vue'
import TaskNew from './components/TaskNew.vue'

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
		path:'/ProjectList',
		component: ProjectList
	},
	{
		path:'/ProjectNew',
		component: ProjectNew
	},
	{
		path:'/TaskList',
		component: TaskList
	},
	{
		path:'/TaskNew',
		component: TaskNew
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
