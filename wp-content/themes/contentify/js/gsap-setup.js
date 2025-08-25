import { gsap } from "gsap";
// import {SplitText} from "gsap/SplitText";
import { ScrollSmoother } from "gsap/dist/ScrollSmoother";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { CustomEase } from "gsap/CustomEase";

// Créez une instance unique de GSAP
const GSAP = gsap;
const Scroll = ScrollTrigger
// const Split = SplitText

gsap.registerPlugin(ScrollTrigger);
// gsap.registerPlugin(SplitText);
gsap.registerPlugin(ScrollSmoother);
gsap.registerPlugin(CustomEase);

CustomEase.create("CustomEase", "0.65, 0, 0.35, 1");

// Rendez l'instance disponible globalement
window.gsap = GSAP;
window.ScrollTrigger = Scroll;
// window.SplitText = Split;

// ScrollSmoother.create({
//     smooth: 1,
//     effects: true,
// });
