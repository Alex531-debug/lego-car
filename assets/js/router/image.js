import ImageList from "../components/image/List.vue";
import ImageCreate from "../components/image/Create.vue";
import ImageUpdate from "../components/image/Update.vue";
import ImageShow from "../components/image/Show.vue";

export default [
  { name: "ImageList", path: "/images/", component: ImageList },
  { name: "ImageCreate", path: "/images/create", component: ImageCreate },
  { name: "ImageUpdate", path: "/images/edit/:id", component: ImageUpdate },
  { name: "ImageShow", path: "/images/show/:id", component: ImageShow },
];
