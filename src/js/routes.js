import HomePage from '../pages/home.vue';
import BranchOfficesPage from '../pages/branches.vue';
import PromotionsPage from '../pages/promotions.vue';
import NotFoundPage from '../pages/404.vue';

var routes = [
  {
    path: '/',
    component: HomePage,
  },{
    path: '/branches',
    name: 'branchOffices',
    component: BranchOfficesPage
  },{
    path: '/promotions',
    name: 'promotions',
    component: PromotionsPage
  },
  {
    path: '(.*)',
    component: NotFoundPage,
  },
];

export default routes;
