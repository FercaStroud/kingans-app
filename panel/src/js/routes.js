import HomePage from '../pages/welcome.vue';
import DashboardPage from '../components/dashboard.vue';

//coupons
import CouponsExchange from '../components/coupons/exchange.vue';
import CouponsAdd from '../components/coupons/add.vue';

//Visits
import VisitsAdd from '../components/visits/add.vue';
import VisitsList from '../components/visits/list.vue';

//Surveys
import SurveysAdd from '../components/surveys/add.vue';
import SurveysList from '../components/surveys/list.vue';

//Panel Users
import PanelUsersAdd from '../components/panel.users/add.vue';
import PanelUsersList from '../components/panel.users/list.vue';

//Application Users
import AppUsersAdd from '../components/app.users/add.vue';
import AppUsersList from '../components/app.users/list.vue';

//Branches
import BranchesAdd from '../components/branches/add.vue';
import BranchesList from '../components/branches/list.vue';

//Others
import NotFoundPage from '../pages/404.vue';

let routes = [
    {
        path: '/',
        name: 'welcome',
        component: HomePage
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component:  DashboardPage
    },
    {
        path: '/visits/add',
        name: 'visitAdd',
        component:  VisitsAdd
    },
    {
        path: '/visits/list',
        name: 'visitsList',
        component:  VisitsList
    },
    {
        path: '/coupons/exchange',
        name: 'couponExchange',
        component:  CouponsExchange
    },
    {
        path: '/coupons/add',
        name: 'couponsAdd',
        component:  CouponsAdd
    },
    {
        path: '/users/panel/add',
        name: 'panelUsersAdd',
        component: PanelUsersAdd
    },
    {
        path: '/users/panel/list',
        name: 'panelUsersList',
        component: PanelUsersList
    },
    {
        path: '/users/app/add',
        name: 'panelUsersAdd',
        component: AppUsersAdd
    },
    {
        path: '/users/app/list',
        name: 'panelUsersList',
        component: AppUsersList
    },
    {
        path: '/surveys/add',
        name: 'surveysAdd',
        component:  SurveysAdd
    },
    {
        path: '/surveys/list',
        name: 'surveysList',
        component:  SurveysList
    },
    {
        path: '/branches/add',
        name: 'branchesAdd',
        component:  BranchesAdd
    },
    {
        path: '/branches/list',
        name: 'branchesList',
        component:  BranchesList
    },
    {
        path: '(.*)',
        component: NotFoundPage,
    },
];

export default routes;
