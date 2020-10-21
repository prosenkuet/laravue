import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import firstPage from './components/pages/myFirstPageComponent'
import hook from './components/pages/basic/hook'
import logsheetEntity from './components/pages/logsheetEntity'
import vuex from './vuex/usercom'
import sampleForm from './components/pages/sampleForm'

//admin pages
import tags from './admin/pages/tags'
import category from './admin/pages/category'
import adminusers from './admin/pages/adminusers'

//login
import login from './admin/pages/login'

//role managment
import role from './admin/pages/role'
import assignRole from './admin/pages/assignRole'
import sysRoutePermission from "./admin/pages/sysRoutePermission";
//services
import ldcservices from "./admin/pages/ldcservices";
import itemcode from "./admin/pages/itemcode";

//blog pages
import eloquentORM from "./blog/pages/eloquentORM";

const routes = [
    {
        path: '/new-vue-route',
        component:firstPage,
        name:'firstPage'
    },
    //vuex route
    {
        path: '/testvuex',
        component:vuex,
        name:'vuex'
    },
    // hook vue
    {
        path: '/hooks',
        component:hook,
        name:'hook'
    },
    // logsheet create entity
    {
        path: '/logsheet',
        component: logsheetEntity,
        name:'logsheetEntity'
    },
    // sample form
    {
        path: '/sampleform',
        component: sampleForm,
        name:'sampleForm'
    },
    // tag page
    {
        path: '/tags',
        component: tags,
        name:'tags'
    },
    // category page
    {
        path: '/category',
        component: category,
        name:'category'
    },
    // admin user page
    {
        path: '/adminusers',
        component: adminusers,
        name:'adminusers'
    },
    // login page
    {
        path: '/login',
        component: login,
        name:'login'
    },
    // role page
    {
        path: '/role',
        component: role,
        name:'role'
    },
    //assign role
    {
        path:'/assignrole',
        component: assignRole,
        name:'assignrole'
    },
    //assign role
    {
        path:'/sysroutepermission',
        component: sysRoutePermission,
        name:'sysroutepermission'
    },
    //ldc services
    {
        path:'/ldcservices',
        component: ldcservices,
        name:'ldcservices'
    },
    //itemcode
    {
        path:'/itemcode',
        component: itemcode,
        name:'itemcode'
    },
    //eloquentORM
    {
        path:'/eloquentorm',
        component: eloquentORM,
        name:'eloquentorm'
    }
]

export default new Router({
    mode: 'history',
    routes
})
