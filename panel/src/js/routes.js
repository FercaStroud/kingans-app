import NotFoundPage from '../pages/404.vue';

let routes = [
    {
        path: '/',
        name: 'welcome',
        component: () => import('../pages/panel/manager/welcome.vue')
    },
    {
        path: '(.*)',
        component: NotFoundPage,
    },
];

export default routes;
