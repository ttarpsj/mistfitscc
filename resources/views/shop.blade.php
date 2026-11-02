@php
    $products = \App\Support\Merchandise::all();
@endphp
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="MISTFITS CC collection catalogue."><title>MISTFITS CC</title>@include('partials.favicon')@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="shop-page">
    <header class="standard-header page-header"><a href="{{ url('/') }}" class="wordmark"><img class="brand-logo" src="{{ asset('images/mistfits-boldwhite-logo.png') }}" alt="MISTFITS CC"></a><nav class="desktop-nav" aria-label="Primary navigation"></nav><button class="menu-toggle" aria-label="Open menu" aria-expanded="false" data-menu-toggle><span></span><span></span></button></header><div class="mobile-nav" data-mobile-nav><a href="{{ url('/shop/') }}">SHOP</a><a href="{{ url('/about/') }}">ABOUT</a><a href="{{ url('/rides/') }}">RIDES</a><a href="{{ url('/#racing') }}">RACING</a><a href="{{ url('/gallery/') }}">GALLERY</a></div>
    <main class="shop-main">
        <div class="shop-crumb"><a href="{{ url('/') }}">HOME</a><span>/</span><span>SHOP</span><span>/</span><b>ALL APPAREL</b></div>
        <section class="collection-intro"><div><h1 class="collection-title">2026 MISTFITS KIT</h1></div><p>As seen around the Driftless region area</p></section>
        <section class="product-grid" aria-label="MISTFITS CC collection">
            @foreach ($products as $index => $product)
                <article class="product-card {{ strtolower(str_replace(' ', '-', $product['availability'])) }}"><a class="product-image-link" href="{{ route('product.show', $product['slug']) }}" aria-label="View {{ $product['name'] }}">@if ($product['images'])<img src="{{ asset($product['images'][0]) }}" alt="{{ $product['name'] }}" loading="lazy">@if (isset($product['images'][1]))<img class="product-image-secondary" src="{{ asset($product['images'][1]) }}" alt="" loading="lazy">@endif @else<div class="product-art {{ $product['tone'] }}"><span>{{ sprintf('%02d', $index + 1) }}</span><div class="product-form form-{{ ($index % 4) + 1 }}"></div><em>MISTFITS CC</em></div>@endif</a><div class="product-meta"><div class="product-name-price"><h2><a href="{{ route('product.show', $product['slug']) }}">{{ $product['name'] }}</a></h2><strong>{{ $product['price'] }}</strong></div><div class="product-status-row"><span class="availability">{{ strtoupper($product['availability']) }}</span></div>@if ($product['variants'] && strtolower($product['availability']) !== 'sold out')<label class="variant-select"><span class="sr-only">Choose an option for {{ $product['name'] }}</span><select aria-label="Choose an option for {{ $product['name'] }}"><option>Choose an option</option></select></label>@endif<div class="product-actions">@if (strtolower($product['availability']) === 'sold out')<span class="card-action is-disabled">SOLD OUT</span>@elseif ($product['variants'])<a class="card-action card-action-button" href="{{ route('product.show', $product['slug']) }}">VIEW OPTIONS</a>@else<a class="card-action card-action-button" href="{{ route('product.show', $product['slug']) }}">VIEW ITEM</a>@endif</div></div></article>
            @endforeach
        </section>
        <section class="shop-note"><p>NO CHECKOUT. NO NOISE.</p><h2>BUILT FOR THE<br>RIDES AHEAD.</h2><a href="{{ url('/#join') }}">ASK ABOUT THE CLUB <i>↗</i></a></section>
    </main>
    <footer class="shop-footer"><img class="shop-footer-logo" src="{{ asset('images/mistfits-boldwhite-logo.png') }}" alt="MISTFITS CC"><span>INDEPENDENT BY NATURE / TOGETHER ON THE ROAD</span><a href="{{ url('/') }}">BACK TO CLUB ↗</a></footer>
</body>
</html>
