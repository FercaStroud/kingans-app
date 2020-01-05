import HomePage from '../pages/home.vue';
import BranchOfficesPage from '../pages/branches.vue';
import PromotionsPage from '../pages/promotions.vue';
import ProfilePage from '../pages/profile.vue';
import SurveyPage from '../pages/survey.vue';
import NotFoundPage from '../pages/404.vue';

var routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage,
  },{
    path: '/branches',
    name: 'branchOffices',
    component: BranchOfficesPage
  },{
    path: '/promotions',
    name: 'promotions',
    component: PromotionsPage
  },{
    path: '/profile',
    name: 'profile',
    component: ProfilePage
  },{
    path: '/survey',
    name: 'survey',
    component: SurveyPage
  },
  {
    path: '(.*)',
    component: NotFoundPage,
  },
];

export default routes;
