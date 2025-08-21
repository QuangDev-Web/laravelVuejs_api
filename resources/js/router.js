import { createRouter, createWebHistory } from "vue-router";
import Categories from "./Pages/Categories/index.vue";
import Brands from "./Pages/Brands/index.vue";
import Products from "./Pages/Products/index.vue";

const routes = [
    {
        path: "/categories",
        component: Categories,
    },
    {
        path: "/brands",
        component: Brands,
    },
    {
        path: "/products",
        component: Products,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
