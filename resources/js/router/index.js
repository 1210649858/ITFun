import Vue from 'vue'
import VueRouter from 'vue-router';
import Home from '../components/Home'
import SiteNode from '../components/site_nodes/Home'
import AdvertNode from '../components/advert_nodes/Home'
import Site from '../components/sites/Home'
import Advert from '../components/adverts/Home'
import SiteCreate from '../components/sites/siteCreate'
import SiteEdit from '../components/sites/siteEdit'

Vue.use(VueRouter);


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/site_nodes',
        name: 'site_nodes',
        component: SiteNode
    },
    {
        path: '/sites',
        name: 'sites',
        component: Site
    },
    {
        path: '/siteCreate',
        name: 'siteCreate',
        component: SiteCreate
    },
    {
        path: '/siteEdit/:id',
        name: 'siteEdit',
        component: SiteEdit
    },
    {
        path: '/advert_nodes',
        name: 'advert_nodes',
        component: AdvertNode
    },
    {
        path: '/adverts',
        name: 'adverts',
        component: Advert
    },
];

const router = new VueRouter({
    routes
});

export default router;