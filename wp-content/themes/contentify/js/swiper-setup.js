import Swiper from 'swiper';
import {Autoplay, Navigation, Pagination} from "swiper/modules";

Swiper.use([Autoplay, Navigation, Pagination])

import 'swiper/css';
import 'swiper/css/navigation';
// import 'swiper/css/pagination'; on ne les charge pas pour ne pas avoir à contredir le style initial

// Créez une instance unique de GSAP
const SWIPER = Swiper;

// Rendez l'instance disponible globalement
window.Swiper = SWIPER;

const ROOT_VARIABLES = getComputedStyle(document.documentElement);
const container_small = ROOT_VARIABLES.getPropertyValue('--container-small').replace('px', '');
const container_medium = ROOT_VARIABLES.getPropertyValue('--container-medium').replace('px', '');
window.ContainerMedium = container_medium;
window.ContainerSmall = container_small;
// window.RootVariablesSmall = RootVariables.getPropertyPriority('--container-small').replace('px', '');
