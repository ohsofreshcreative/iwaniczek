import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';


const initReviewPopup = (scope = document) => {
	const reviewCards = scope.querySelectorAll('.swiper-slide .__card');
	const popup = document.getElementById('review-popup');
	const popupText = document.getElementById('review-popup-text');
	const popupAuthor = document.getElementById('review-popup-author');
	const closeButton = popup?.querySelector('.review-popup__close');

	if (!popup || !reviewCards.length) return;


	reviewCards.forEach(card => {
		const textElement = card.querySelector('.__txt');
		const moreButton = card.querySelector('.btn-more');
		const authorElement = card.querySelector('.font-header');

		if (!textElement || !moreButton || !authorElement) return;


		// sprawdzanie czy tekst jest obcięty
		setTimeout(() => {
			if (textElement.scrollHeight > textElement.clientHeight) {
				moreButton.classList.remove('hidden');
			}
		}, 200);


		moreButton.addEventListener('click', () => {
			popupText.innerHTML = textElement.innerHTML;
			popupAuthor.textContent = authorElement.textContent.trim();

			popup.classList.remove('hidden');

			setTimeout(() => {
				popup.classList.add('is-visible');
			}, 10);

			document.body.style.overflow = 'hidden';
		});
	});


	const closePopup = () => {
		popup.classList.remove('is-visible');

		document.body.style.overflow = '';

		setTimeout(() => {
			popup.classList.add('hidden');
		}, 300);
	};


	closeButton?.addEventListener('click', closePopup);


	popup.addEventListener('click', (e) => {
		if (e.target === popup) {
			closePopup();
		}
	});


	document.addEventListener('keydown', (e) => {
		if (
			e.key === 'Escape' &&
			popup.classList.contains('is-visible')
		) {
			closePopup();
		}
	});
};



const initReviewsSwiper = (scope = document) => {

	const swiperElements = scope.querySelectorAll(
		'.reviews-swiper:not(.swiper-initialized)'
	);

	if (!swiperElements.length) return;


	swiperElements.forEach((swiperEl) => {

		const section = swiperEl.closest('.b-reviews');

		if (!section) return;


		new Swiper(swiperEl, {

			modules: [
				Navigation,
				Pagination
			],

			slidesPerView: 1.2,
			spaceBetween: 24,
			autoHeight: false,
			loop: true,


			navigation: {
				nextEl: section.querySelector('.__next'),
				prevEl: section.querySelector('.__prev'),
			},


			pagination: {
				el: section.querySelector('.swiper-pagination'),
				clickable: true,
			},


			breakpoints: {
				768: {
					slidesPerView: 2.5,
					spaceBetween: 24,
				},

				1024: {
					slidesPerView: 3.2,
					spaceBetween: 24,
				},
			},


			on: {
				init: () => {
					initReviewPopup(section);
				},

				slideChange: () => {
					initReviewPopup(section);
				},
			},
		});
	});
};



// start
initReviewsSwiper();
initReviewPopup();



// ACF block render
if (window.acf) {

	window.acf.addAction('render_block', (el) => {

		const node = el?.[0] ?? el;

		if (node) {
			initReviewsSwiper(node);
			initReviewPopup(node);
		}

	});
}


export default initReviewsSwiper;