import carRouter from './car';
import brandRouter from './brand';
import imageRouter from './image';
import Home from "../components/home/Home.vue";

export default [
    { path:'/', component: Home },
    ...brandRouter,
    ...imageRouter,
    ...carRouter
]