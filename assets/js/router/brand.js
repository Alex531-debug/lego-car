import BrandList from "../components/brand/List.vue";
import BrandCreate from "../components/brand/Create.vue";
import BrandUpdate from "../components/brand/Update.vue";
import BrandShow from "../components/brand/Show.vue";

export default [
  { name: "BrandList", path: "/brands/", component: BrandList },
  { name: "BrandCreate", path: "/brands/create", component: BrandCreate },
  { name: "BrandUpdate", path: "/brands/edit/:id", component: BrandUpdate },
  { name: "BrandShow", path: "/brands/show/:id", component: BrandShow },
];
