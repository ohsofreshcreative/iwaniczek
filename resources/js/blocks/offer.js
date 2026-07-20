import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';

const initOfferSlider = () => {
    const sliders = document.querySelectorAll('.offer-standard');

    if (!sliders.length) {
        return;
    }

    sliders.forEach((slider) => {
        const wrapper = slider.closest('.c-main');

        new Swiper(slider, {
            modules: [Navigation],
            loop: true,
            grabCursor: true,
            slidesPerView: 1,
            spaceBetween: 24,

            navigation: {
                nextEl: wrapper.querySelector('.offer-next'),
                prevEl: wrapper.querySelector('.offer-prev'),
            },

            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                580: {
                    slidesPerView: 2,
                },
                767: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 3.5,
                },
                1200: {
                    slidesPerView: 3.5,
                },
                1400: {
                    slidesPerView: 3.5,
                },
            },
        });
    });
};

initOfferSlider();