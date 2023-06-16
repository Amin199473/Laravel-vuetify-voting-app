import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/register",
            name: "register",
            component: () => import("./pages/Auth/TheRegister.vue"),
        },
        {
            path: "/login",
            name: "login",
            component: () => import("./pages/Auth/TheLogin.vue"),
        },
        {
            path: "/",
            name: "ideas",
            component: () => import("./pages/ideas/index.vue"),
        },
        {
            path: "/ideas/:slug",
            name: "ideaShow",
            component: () => import("./pages/idea/show.vue"),
        },
    ],
});

export default router;
