@php
global $product;
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
@endphp

@if (!empty($product))
<li class="">

	@php do_action('woocommerce_before_shop_loop_item') @endphp

	<a href="{{ get_the_permalink() }}" class="woocommerce-LoopProduct-link flex flex-col gap-4">

		<div class="__thumb overflow-hidden aspect-square flex items-center justify-center bg-white">
			{!! get_the_post_thumbnail($product->get_id(), 'woocommerce_thumbnail', ['class' => 'w-full h-full object-cover object-center']) !!}
		</div>

		@php do_action('woocommerce_before_shop_loop_item_title') @endphp

		<h6 class="woocommerce-loop-product__title text-h7 line-clamp-2 text-white">{!! get_the_title() !!}</h6>

		@php do_action('woocommerce_after_shop_loop_item_title') @endphp

	</a>

	@php do_action('woocommerce_after_shop_loop_item') @endphp

</li>
@endif