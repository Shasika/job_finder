import Vue from 'vue';
import VueRouter from 'vue-router';
import UserDashboard from "./components/dashboards/UserDashboard";
import Home from "./components/Home";
import JobPost from "./components/Jobs/JobPost";
import CreateJob from "./components/Jobs/CreateJob";
import ManageJobs from "./components/Jobs/ManageJobs";
import ManageUsers from "./components/user/ManageUsers";
import viewJob from "./components/Jobs/ViewJob";

Vue.use(VueRouter);

export default new VueRouter({
    routes :[
        {
            name: 'UserDashboard',
            path:'/user-dashboard' ,
            component : UserDashboard
        },
        {
            name: 'Home',
            path:'/' ,
            component : Home,
        },
        {
            name: 'job',
            path:'/job/:id' ,
            component : JobPost,
        },
        {
            name: 'create-job',
            path:'/create-job' ,
            component : CreateJob,
        },
        {
            name: 'edit-job',
            path:'/edit-job/:id' ,
            component : CreateJob,
        },
        {
            name: 'view-job',
            path:'/view-job/:id' ,
            component : viewJob,
        },
        {
            name: 'manage-jobs',
            path:'/manage-jobs' ,
            component : ManageJobs,
        },
        {
            name: 'manage-users',
            path:'/manage-users' ,
            component : ManageUsers,
        },

    ],

    mode:'history'
});
