import { gsap } from "gsap";

// document.addEventListener("DOMContentLoaded", () => {

//     const animateIn = () => {
//         const main = document.querySelector("main");
//         if (!main) return;

//         gsap.fromTo(main,
//             { opacity: 0, scale: 1.04 },
//             { opacity: 1, scale: 1, duration: 0.25, ease: "power3.out" }
//         );
//     };

//     const animateOut = () => {
//         const main = document.querySelector("main");
//         if (!main) return;

//         return gsap.to(main, {
//             opacity: 0,
//             scale: 0.98,
//             duration: 0.20,
//             ease: "power2.in"
//         });
//     };

//     animateIn();

//     document.addEventListener("livewire:navigating", (event) => {
//         const resume = event.detail?.resume;
//         if (resume) {
//             event.preventDefault();
//             animateOut().then(resume);
//         }
//     });

//     document.addEventListener("livewire:navigated", animateIn);
// });