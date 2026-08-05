@php
use App\Walkers\DropdownWalker;
use App\Walkers\MobileDropdownWalker;
@endphp

<script>
	document.addEventListener('alpine:init', () => {
		const _sc = @json(['ajaxUrl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('live_search')]);
		Alpine.data('headerData', () => ({
			mobileOpen: false,
			searchOpen: false,
			searchQuery: '',
			searchResults: [],
			searchLoading: false,
			openSearch() {
				this.searchOpen = true;
				this.$nextTick(() => this.$refs.searchInput?.focus());
			},
			closeSearch() {
				this.searchOpen = false;
				this.searchQuery = '';
				this.searchResults = [];
			},
			async performSearch() {
				if (this.searchQuery.length < 2) {
					this.searchResults = [];
					return;
				}
				this.searchLoading = true;
				try {
					const r = await fetch(_sc.ajaxUrl + '?action=live_search_products&q=' + encodeURIComponent(this.searchQuery) + '&nonce=' + _sc.nonce);
					this.searchResults = await r.json();
				} catch (e) {
					this.searchResults = [];
				} finally {
					this.searchLoading = false;
				}
			}
		}));
	});
</script>

<header x-data="headerData()" @keydown.escape.window="closeSearch()" class="fixed top-0 left-0 right-0 z-50 masthead fixed-top bg-transparent">

	<!-- Desktop Header -->
	<div class=" items-center justify-between hidden h-full py-4 px-12 mx-auto lg:flex border-b  border-dashed border-secondary-400">
		<a class="brand shrink-0" href="{{ home_url('/') }}">
			@if ($logo)
			<img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto !h-8 md:!h-10">
			@else
			<span class="text-xl font-bold">{{ $siteName }}</span>
			@endif
		</a>
		@if (has_nav_menu('primary_navigation'))
		<nav class="ml-6 lg:ml-15 nav-primary w-full" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
			{!! wp_nav_menu([
			'theme_location' => 'primary_navigation',
			'menu_class' => 'nav flex gap-x-3 lg:gap-x-6 text-lg font-medium justify-center items-center',
			'container' => false,
			'echo' => false,
			'walker' => new DropdownWalker(),
			]) !!}
		</nav>
		@endif

		<div class="__action flex items-center gap-4">
			<div class="relative">
				<button @click="searchOpen ? closeSearch() : openSearch()" class="hover:opacity-80 transition-opacity block" aria-label="Szukaj">
					<img class="!w-8 !h-8" src="{{ get_template_directory_uri() }}/resources/images/search.svg" alt="Szukaj" />
				</button>
				<!-- Search dropdown -->
				<div
					x-show="searchOpen"
					x-transition:enter="transition ease-out duration-200"
					x-transition:enter-start="opacity-0 scale-95"
					x-transition:enter-end="opacity-100 scale-100"
					x-transition:leave="transition ease-in duration-150"
					x-transition:leave-start="opacity-100 scale-100"
					x-transition:leave-end="opacity-0 scale-95"
					class="absolute top-full right-0 mt-3 w-96 bg-secondary-800 rounded-lg shadow-2xl z-50 p-4"
					style="display:none;">
					<div class="relative">
						<input
							x-ref="searchInput"
							x-model="searchQuery"
							@input.debounce.300ms="performSearch()"
							type="search"
							placeholder="Szukaj produktów..."
							class="w-full bg-white text-secondary rounded px-4 py-2.5 pr-9 text-base !font-medium focus:outline-none" />
						<div x-show="searchLoading" class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" style="display:none;">
							<svg class="w-4 h-4 animate-spin text-secondary-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
								<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
								<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
							</svg>
						</div>
					</div>
					<div x-show="searchResults.length > 0" class="mt-3" style="display:none;">
						<template x-for="product in searchResults" :key="product.id">
							<a :href="product.url" @click="closeSearch()" class="flex items-center gap-3 px-2 py-2.5 hover:bg-white/10 transition-colors rounded border-b border-white/10 last:border-0">
								<img x-show="product.thumbnail" :src="product.thumbnail" :alt="product.title" class="w-10 h-10 object-cover rounded shrink-0" />
								<div class="min-w-0">
									<div class="!font-medium text-white truncate" x-text="product.title"></div>
									<div class="text-primary !font-medium mt-0.5" x-show="product.price" x-text="product.price"></div>
								</div>
							</a>
						</template>
						<a :href="'/?s=' + encodeURIComponent(searchQuery) + '&post_type=product'" @click="closeSearch()" class="block mt-2 py-2 text-xs text-center text-white/60 hover:text-white transition-colors">
							Zobacz wszystkie wyniki →
						</a>
					</div>
					<div x-show="searchQuery.length >= 2 && !searchLoading && searchResults.length === 0" class="mt-3 text-sm text-white/60 text-center py-2" style="display:none;">
						Brak wyników dla „<span x-text="searchQuery"></span>“
					</div>
				</div>
			</div>
			@if (function_exists('wc_get_page_id'))
			<a href="{{ get_permalink(wc_get_page_id('myaccount')) }}" class="hover:opacity-80 transition-opacity !w-8 !h-8">
				<img class="!w-8 !h-8" src="{{ get_template_directory_uri() }}/resources/images/user.svg" alt="Moje konto" />
			</a>
			@else
			<img class="w-8 h-8" src="{{ get_template_directory_uri() }}/resources/images/user.svg" alt="Użytkownik" />
			@endif

			@if (function_exists('WC'))
			<a href="{{ wc_get_cart_url() }}" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="__cart relative hover:opacity-80 transition-opacity cart-custom-location-desktop">
				<img class="!w-8 !h-8" src="{{ get_template_directory_uri() }}/resources/images/cart.svg" alt="Koszyk" />
				@if (WC()->cart && WC()->cart->get_cart_contents_count() > 0)
            <span class="absolute -top-2 -right-2 bg-primary text-white text-[12px] !font-bold w-5 h-5 flex items-center justify-center rounded-full cart-count">
					{{ WC()->cart->get_cart_contents_count() }}
				</span>
				@endif
			</a>
			@else
			<img class="!w-8 !h-8" src="{{ get_template_directory_uri() }}/resources/images/cart.svg" alt="Koszyk" />
			@endif
		</div>
	</div>

	<!-- Mobile Header Bar -->
	<div class="flex items-center justify-between p-4 mobile-menu fixed-top lg:hidden">
		<a class="brand shrink-0" href="{{ home_url('/') }}">
			@if ($logo)
			<img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto !h-8 md:!h-10">
			@else
			<span class="text-lg font-bold">{{ $siteName }}</span>
			@endif
		</a>
		<div class="flex items-center gap-3">
			@if (function_exists('wc_get_page_id'))
			<a href="{{ get_permalink(wc_get_page_id('myaccount')) }}" class="hover:opacity-80 transition-opacity">
				<img class="!w-7 !h-7" src="{{ get_template_directory_uri() }}/resources/images/user.svg" alt="Moje konto" />
			</a>
			@endif

			{{-- Mobilna ikonka koszyka ze zdarzeniem otwarcia Drawera --}}
			@if (function_exists('WC'))
			<a href="{{ wc_get_cart_url() }}" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative hover:opacity-80 transition-opacity cart-custom-location-mobile">
				<img src="{{ get_template_directory_uri() }}/resources/images/cart.svg" class="!w-7 !h-7" alt="Koszyk" />
				@if (WC()->cart && WC()->cart->get_cart_contents_count() > 0)
            <span class="absolute -top-2 -right-2 bg-primary text-white text-[12px] !font-bold w-5 h-5 flex items-center justify-center rounded-full cart-count">
					{{ WC()->cart->get_cart_contents_count() }}
				</span>
				@endif
			</a>
			@endif

			<button @click="searchOpen ? closeSearch() : openSearch()" class="hover:opacity-80 transition-opacity" aria-label="Szukaj">
				<img class="!w-7 !h-7" src="{{ get_template_directory_uri() }}/resources/images/search.svg" alt="Szukaj" />
			</button>

			<button
				@click.stop="mobileOpen = !mobileOpen"
				class="p-2 primary bg-white rounded-md text-primary"
				aria-expanded="mobileOpen"
				aria-controls="mobile-menu-panel">
				<span class="sr-only">Otwórz menu główne</span>
				<svg x-show="!mobileOpen" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
				</svg>
				<svg x-show="mobileOpen" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" style="display: none;">
					<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
				</svg>
			</button>
		</div>
	</div>

	<!-- Mobile Search Panel -->
	<div
		x-show="searchOpen"
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 -translate-y-2"
		x-transition:enter-end="opacity-100 translate-y-0"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 translate-y-0"
		x-transition:leave-end="opacity-0 -translate-y-2"
		class="lg:hidden absolute top-full left-0 right-0 bg-secondary shadow-xl z-50 p-4"
		style="display:none;">
		<div class="relative">
			<input
				x-model="searchQuery"
				@input.debounce.300ms="performSearch()"
				type="search"
				placeholder="Szukaj produktów..."
				class="w-full bg-white text-secondary rounded px-4 py-2.5 pr-9 text-sm focus:outline-none"
			/>
			<div x-show="searchLoading" class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" style="display:none;">
				<svg class="w-4 h-4 animate-spin text-secondary-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
			</div>
		</div>
		<div x-show="searchResults.length > 0" class="mt-3" style="display:none;">
			<template x-for="product in searchResults" :key="product.id">
				<a :href="product.url" @click="closeSearch()" class="flex items-center gap-3 px-2 py-2.5 hover:bg-white/10 transition-colors rounded border-b border-white/10 last:border-0">
					<img x-show="product.thumbnail" :src="product.thumbnail" :alt="product.title" class="w-10 h-10 object-cover rounded shrink-0" />
					<div class="min-w-0">
						<div class="font-medium text-white text-sm truncate" x-text="product.title"></div>
						<div class="text-xs text-primary font-semibold mt-0.5" x-show="product.price" x-text="product.price"></div>
					</div>
				</a>
			</template>
			<a :href="'/?s=' + encodeURIComponent(searchQuery) + '&post_type=product'" @click="closeSearch()" class="block mt-2 py-2 text-base text-center text-white/80 hover:text-white transition-colors">
				Zobacz wszystkie wyniki →
			</a>
		</div>
		<div x-show="searchQuery.length >= 2 && !searchLoading && searchResults.length === 0" class="mt-3 text-sm text-white/60 text-center py-2" style="display:none;">
			Brak wyników dla „<span x-text="searchQuery"></span>"
		</div>
	</div>

	<!-- Mobile Menu Panel -->
	<div
		id="mobile-menu-panel"
		x-show="mobileOpen"
		@click.away="mobileOpen = false"
		@keydown.escape.window="mobileOpen = false"
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 transform translate-x-full"
		x-transition:enter-end="opacity-100 transform translate-x-0"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 transform translate-x-0"
		x-transition:leave-end="opacity-0 transform translate-x-full"
		class="mobile-menu fixed top-0 right-0 bottom-0 w-full h-full bg-secondary shadow-xl z-[51] overflow-y-auto lg:hidden"
		aria-label="Menu mobilne">
		<div class="p-4 relative z-10">
			<div class="flex items-center justify-between mb-6">
				<span class=""><a class="brand shrink-0" href="{{ home_url('/') }}"><img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto h-12"></a></span>
				<button
					@click="mobileOpen = false"
					class="p-2 text-white rounded-md">
					<span class="sr-only">Zamknij menu</span>
					<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			@if (has_nav_menu('primary_navigation'))
			<nav class="flex flex-col space-y-1 mt-20">
				{!! wp_nav_menu([
				'theme_location' => 'primary_navigation',
				'menu_class' => 'nav-mobile flex flex-col space-y-2',
				'container' => false,
				'echo' => false,
				'walker' => new MobileDropdownWalker(),
				]) !!}
			</nav>
			@endif


		</div>

	</div>

	<!-- Backdrop closes search on outside click; teleported to body to escape header's z-50 stacking context -->
	<template x-teleport="body">
		<div x-show="searchOpen" @click="closeSearch()" class="fixed inset-0 z-40" style="display:none;"></div>
	</template>

</header>