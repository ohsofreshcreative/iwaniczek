/**
 * Zwijana treść — obsługuje dowolną liczbę instancji [data-expandable] na stronie.
 * Markup: resources/views/woocommerce/partials/expandable-content.blade.php
 */

const TOLERANCE = 24; // px — nie pokazuj przycisku dla treści ledwo przekraczającej próg

function setup(el) {
	const content = el.querySelector('[data-expandable-content]');
	const toggle = el.querySelector('[data-expandable-toggle]');
	const label = el.querySelector('[data-expandable-label]');
	const fade = el.querySelector('[data-expandable-fade]');
	const arrow = toggle?.querySelector('svg');

	if (!content || !toggle) return;

	const collapsed = parseInt(el.dataset.collapsedHeight || '200', 10);

	// Treść krótsza niż próg — pokaż w całości, schowaj przycisk i gradient.
	const measure = () => {
		if (el.dataset.expanded === 'true') return;

		if (content.scrollHeight <= collapsed + TOLERANCE) {
			content.style.maxHeight = 'none';
			toggle.closest('div').hidden = true;
			if (fade) fade.hidden = true;
			el.dataset.expandable = 'static';
		} else {
			content.style.maxHeight = `${collapsed}px`;
			toggle.closest('div').hidden = false;
			if (fade) fade.hidden = false;
			el.dataset.expandable = 'collapsible';
		}
	};

	measure();

	// Obrazki w WYSIWYG dociągają się po DOMContentLoaded i zmieniają wysokość.
	window.addEventListener('load', measure, { once: true });

	toggle.addEventListener('click', () => {
		const isExpanded = el.dataset.expanded === 'true';

		if (isExpanded) {
			content.style.maxHeight = `${content.scrollHeight}px`; // z 'none' na konkret, żeby transition zadziałało
			requestAnimationFrame(() => {
				content.style.maxHeight = `${collapsed}px`;
			});
			el.dataset.expanded = 'false';
			if (fade) fade.classList.remove('opacity-0');
			arrow?.classList.remove('rotate-180');
			if (label) label.textContent = toggle.dataset.labelMore || 'Rozwiń';
		} else {
			content.style.maxHeight = `${content.scrollHeight}px`;
			el.dataset.expanded = 'true';
			if (fade) fade.classList.add('opacity-0');
			arrow?.classList.add('rotate-180');
			if (label) label.textContent = toggle.dataset.labelLess || 'Zwiń';

			// Po animacji zdejmij limit, żeby treść mogła urosnąć (np. lazy obrazki).
			content.addEventListener(
				'transitionend',
				() => {
					if (el.dataset.expanded === 'true') content.style.maxHeight = 'none';
				},
				{ once: true }
			);
		}

		toggle.setAttribute('aria-expanded', String(!isExpanded));
	});
}

document.querySelectorAll('[data-expandable]').forEach(setup);
