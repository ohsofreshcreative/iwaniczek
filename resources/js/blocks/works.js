import Swiper from 'swiper';
import { FreeMode } from 'swiper/modules';

import 'swiper/css';


const worksFilters = () => {

	const sliders = document.querySelectorAll('.portfolio-filters-slider');

	sliders.forEach((slider) => {
		let swiper = null;
		const initSlider = () => {
			if (!swiper) {
				swiper = new Swiper(slider, {

					modules: [
						FreeMode
					],
					slidesPerView: 'auto',
					spaceBetween: 24,
					freeMode: {
						enabled: true,
					},
					grabCursor: true,
					touchRatio: 1,
					speed: 500,
					observer: true,
					observeParents: true,
					watchOverflow: false,
				});
			}
		};
		initSlider();
		setTimeout(() => {

			if (swiper) {
				swiper.update();
			}

		}, 300);
		window.addEventListener(
			'resize',
			() => {

				if (swiper) {
					swiper.update();
				}

			}
		);
	});

	const buttons = document.querySelectorAll(
		'.portfolio-filter'
	);

	const items = document.querySelectorAll(
		'.portfolio-item'
	);
	if (!buttons.length || !items.length) {
		return;
	}
	buttons.forEach((button) => {
		button.addEventListener('click', () => {
			const filter = button.dataset.filter;
			buttons.forEach((btn) => {
				btn.classList.remove('active');
			});
			button.classList.add('active');
			items.forEach((item) => {
				const categories = (
					item.dataset.category || ''
				).split(',')
					.filter(Boolean);
				if (
					filter === 'all'
					||
					categories.includes(filter)
				) {
					item.classList.remove('hidden');
				} else {
					item.classList.add('hidden');
				}
			});
		});
	});
};

if (document.readyState === 'loading') {
	document.addEventListener(
		'DOMContentLoaded',
		worksFilters
	);
} else {
	worksFilters();
}