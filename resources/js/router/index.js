import Vue from 'vue'
import VueRouter from 'vue-router';
import Home from '../components/Home'
import SiteNode from '../components/site_nodes/Home'
import AdvertNode from '../components/advert_nodes/Home'
import NoticeNode from '../components/notice_nodes/Home'
import CourseNode from '../components/course_nodes/Home'
import Site from '../components/sites/Home'
import Advert from '../components/adverts/Home'
import SiteCreate from '../components/sites/siteCreate'
import SiteEdit from '../components/sites/siteEdit'
import AdvertCreate from '../components/adverts/advertCreate'
import AdvertEdit from '../components/adverts/advertEdit'
import Notice from '../components/notices/Home'
import NoticeCreate from '../components/notices/noticeCreate'
import NoticeEdit from '../components/notices/noticeEdit'
import Tag from '../components/tags/Home'
import TagCreate from '../components/tags/tagCreate'
import TagEdit from '../components/tags/tagEdit'
import OverView from '../components/overviews/overView'
import Course from '../components/courses/Home'
import CourseCreate from '../components/courses/courseCreate'
import CourseEdit from '../components/courses/courseEdit'
import Chapters from '../components/chapters/Home'
import ChaptersCreate from '../components/chapters/chaptersCreate'
import ChaptersEdit from '../components/chapters/chaptersEdit'



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
    {
        path: '/advertCreate',
        name: 'advertCreate',
        component: AdvertCreate
    },
    {
        path: '/advertEdit/:id',
        name: 'advertEdit',
        component: AdvertEdit
    },
    {
        path: '/notice_nodes',
        name: 'notice_nodes',
        component: NoticeNode
    },
    {
        path: '/notices',
        name: 'notices',
        component: Notice
    },
    {
        path: '/noticeCreate',
        name: 'noticeCreate',
        component: NoticeCreate
    },
    {
        path: '/noticeEdit/:id',
        name: 'noticeEdit',
        component: NoticeEdit
    },
    {
        path: '/course_nodes',
        name: 'course_nodes',
        component: CourseNode
    },
    {
        path: '/tags',
        name: 'tags',
        component:Tag
    },
    {
        path: '/tagCreate',
        name: 'tagCreate',
        component: TagCreate
    },
    {
        path: '/tagEdit/:id',
        name: 'tagEdit',
        component: TagEdit
    },
    {
        path: '/overviews',
        name: 'overviews',
        component: OverView
    },
    {
        path: '/courses',
        name: 'courses',
        component: Course
    },
    {
        path: '/courseCreate',
        name: 'courseCreate',
        component: CourseCreate
    },
    {
        path: '/courseEdit/:id',
        name: 'courseEdit',
        component: CourseEdit
    },
    {
        path: '/courses/:course_id/chapters',
        name: 'chapters',
        component: Chapters
    },
    {
        path: '/courses/:course_id/chapters/create',
        name: 'chapters_create',
        component: ChaptersCreate
    },
    {
        path: '/courses/:course_id/chapters/edit/:id',
        name: 'chapters_edit',
        component: ChaptersEdit
    },
];

const router = new VueRouter({
    routes
});

export default router;