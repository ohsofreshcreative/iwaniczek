import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';


const createYtModal = () => {
    const modal = document.createElement('div');
    modal.id = 'yt-modal';
    modal.className = 'fixed inset-0 z-[9999] bg-black/80 flex items-center justify-center hidden';
    modal.innerHTML = `
        <button type="button" id="yt-modal-close" class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-white text-3xl leading-none hover:text-gray-300" aria-label="Zamknij">&times;</button>
        <div class="w-full max-w-4xl aspect-video px-4">
            <iframe id="yt-modal-iframe" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    `;
    document.body.appendChild(modal);

    const iframe = modal.querySelector('#yt-modal-iframe');

    const close = () => {
        iframe.src = '';
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };

    modal.querySelector('#yt-modal-close').addEventListener('click', close);
    modal.addEventListener('click', (e) => { if (e.target === modal) close(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });

    return modal;
};

const initYtThumbs = () => {
    const triggers = document.querySelectorAll('.yt-thumb-trigger');
    if (!triggers.length) return;

    let modal = document.getElementById('yt-modal') ?? createYtModal();
    const iframe = modal.querySelector('#yt-modal-iframe');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            iframe.src = `https://www.youtube.com/embed/${trigger.dataset.ytId}?autoplay=1`;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    });
};

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
initYtThumbs();