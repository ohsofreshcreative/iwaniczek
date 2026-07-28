function initHero() {
	const playBtn = document.getElementById('heroPlayBtn');
	const modal = document.getElementById('heroVideoModal');
	const closeBtn = document.getElementById('heroVideoClose');
	const video = document.getElementById('heroModalVideo');

	if (!playBtn || !modal || !video) return;

	playBtn.addEventListener('click', () => {
		modal.classList.remove('hidden');
		modal.classList.add('flex');

		video.currentTime = 0;
		video.play();

		document.body.classList.add('overflow-hidden');
		document.documentElement.classList.add('overflow-hidden');
	});

	function closeModal() {
		video.pause();
		video.currentTime = 0;

		modal.classList.remove('flex');
		modal.classList.add('hidden');

		document.body.classList.remove('overflow-hidden');
		document.documentElement.classList.remove('overflow-hidden');
	}

	closeBtn.addEventListener('click', closeModal);

	modal.addEventListener('click', (e) => {
		if (e.target === modal) {
			closeModal();
		}
	});

	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') {
			closeModal();
		}
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initHero);
} else {
	initHero();
}