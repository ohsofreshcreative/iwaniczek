import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';


const showroomSlider = () => {

    const sliders = document.querySelectorAll('.showroom-standard');

    if (!sliders.length) {
        return;
    }


    sliders.forEach((slider) => {

        const wrapper = slider.closest('.showroom-slider-wrapper');

        new Swiper(slider, {

            modules: [Navigation],

            slidesPerView: 'auto',
            spaceBetween: 28,

            grabCursor: true,
            speed: 600,

            observer: true,
            observeParents: true,

            navigation: {
                nextEl: wrapper.querySelector('.showroom-next'),
                prevEl: wrapper.querySelector('.showroom-prev'),
            },


            breakpoints: {

                0: {
                    spaceBetween: 16,
                },

                768: {
                    spaceBetween: 24,
                },

                1200: {
                    spaceBetween: 28,
                },

            },

        });

    });

};


showroomSlider();