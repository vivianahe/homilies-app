import { createRouter, createWebHistory } from "vue-router"
import IndexHome from "./components/Home.vue";
import HomilyView from "./components/views/HomilyView.vue";
import HomilyAll from "./components/views/HomilyAll.vue";
import DonateView from "./components/views/DonateView.vue";
import HomilyDetail from "./components/views/HomilyDetail.vue";
import HomilyAdd from "./components/views/admin/HomilyAdd.vue";
import HomilyDetailAdm from "./components/views/admin/HomilyDetail.vue";
import HomilyAllAdm from "./components/views/admin/HomilyAllAdm.vue";
import HomilyEditAdm from "./components/views/admin/HomilyEdit.vue";
import MorningPrayer from "./components/views/admin/MorningPrayer.vue";
import UsersAll from "./components/views/admin/UsersAll.vue";
const routes = [
    {
        path: '/',
        name: 'home',
        component: IndexHome
    },
    {
        path: '/pag',
        name: 'pag',
        component: HomilyView
    },
    {
        path: '/homilyAll',
        name: 'homilyAll',
        component: HomilyAll
    },
    {
        path: '/donateView',
        name: 'donateView',
        component: DonateView
    },
    {
        path: '/homilyDetail/:id',
        name: 'homilyDetail',
        component: HomilyDetail
    },
    {
        path: '/homilyAddView',
        name: 'homilyAddView',
        component: HomilyAdd
    },
    {
        path: '/homilyAllAdm',
        name: 'homilyAllAdm',
        component: HomilyAllAdm
    },
    {
        path: '/detailHomily/:id',
        name: 'detailHomily',
        component: HomilyDetailAdm
    },
    {
        path: '/editHomily/:id',
        name: 'editHomily',
        component: HomilyEditAdm
    },
    {
        path: '/prayerView',
        name: 'prayerView',
        component: MorningPrayer
    },
    {
        path: '/userView',
        name: 'userView',
        component: UsersAll
      },
];
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router;