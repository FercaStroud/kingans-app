import NotFoundPage from '../pages/404.vue';

let routes = [
    {
        path: '/',
        name: 'welcome',
        component: () => import('../pages/welcome.vue')
    },
    {
        path: '(.*)',
        component: NotFoundPage,
    },
];

export default routes;
