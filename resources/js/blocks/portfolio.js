import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';
const portfolioSlider = () => {
	const sliders = document.querySelectorAll('.portfolio-slider');
	if (!sliders.length) {
		return;
	}
	sliders.forEach((slider) => {
		new Swiper(slider, {
			modules: [
				Navigation
			],
			loop: true,
			grabCursor: true,
			slidesPerView: 1.15,
			spaceBetween: 24,
			navigation: {
				nextEl: '.portfolio-next',
				prevEl: '.portfolio-prev',
			},
			breakpoints: {
				768: {
					slidesPerView: 1.5,
				},
				1024: {
					slidesPerView: 1.6,
				},
				1280: {
					slidesPerView: 1.5,
				},
			},
		});
	});
};
portfolioSlider();