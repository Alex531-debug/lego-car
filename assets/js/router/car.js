import CarList from "../components/car/List.vue";
import CarCreate from "../components/car/Create.vue";
import CarUpdate from "../components/car/Update.vue";
import CarShow from "../components/car/Show.vue";

export default [
  { name: "CarList", path: "/cars/", component: CarList },
  { name: "CarCreate", path: "/cars/create", component: CarCreate },
  { name: "CarUpdate", path: "/cars/edit/:id", component: CarUpdate },
  { name: "CarShow", path: "/cars/show/:id", component: CarShow },
];
