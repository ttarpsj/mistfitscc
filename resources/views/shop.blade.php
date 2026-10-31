@php
    $products = [];
    foreach (glob(base_path('merchandise/*.json')) ?: [] as $itemFile) {
        $item = json_decode(file_get_contents($itemFile), true);
        if (is_array($item) && isset($item['name'], $item['type'], $item['tone'])) $products[] = $item;
    }
    usort($products, fn ($a, $b) => ($a['order'] ?? 999) <=> ($b['order'] ?? 999));
@endphp
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="MISTFITS CC collection catalogue."><title>Shop — MISTFITS CC</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="shop-page">
    <div class="shop-announcement"><a href="{{ url('/') }}">MISTFITS CC / INDEPENDENT CYCLING CLUB</a><span>COLLECTION 01 — PROPOSED</span></div>
    <header class="shop-header"><a href="{{ url('/') }}" class="shop-mark">MISTFITS<br>CC</a><nav><a href="{{ url('/shop/') }}" class="active">SHOP</a><a href="{{ url('/#rides') }}">RIDES</a><a href="{{ url('/#racing') }}">RACING</a></nav><div class="shop-tools"><button type="button" aria-label="Search the catalogue">SEARCH</button><button type="button" aria-label="Open catalogue bag">BAG (0)</button></div></header>
    <main class="shop-main">
        <div class="shop-crumb"><a href="{{ url('/') }}">HOME</a><span>/</span><span>SHOP</span><span>/</span><b>ALL APPAREL</b></div>
        <section class="collection-intro"><div><p class="shop-kicker">MISTFITS CC / COLLECTION 01</p><h1>THE CLUB<br>WARDROBE.</h1></div><p>A study in riding kit for long miles, hard weather and the part of the day after the ride. A proposed collection, not a live store.</p></section>
        <div class="collection-toolbar"><button type="button">FILTER <span>+</span></button><span>ALL APPAREL / {{ count($products) }} OBJECTS</span><button type="button">SORT: FEATURED <span>↓</span></button></div>
        <section class="product-grid" aria-label="MISTFITS CC collection">
            @foreach ($products as $index => $product)
                <article class="product-card"><div class="product-art {{ $product['tone'] }}"><span>{{ sprintf('%02d', $index + 1) }}</span><div class="product-form form-{{ ($index % 4) + 1 }}"></div><em>MISTFITS CC</em></div><div class="product-meta"><p>{{ $product['type'] }}</p><h2>{{ $product['name'] }}</h2><span>CONCEPT / TBA</span></div></article>
            @endforeach
        </section>
        <section class="shop-note"><p>NO CHECKOUT. NO NOISE.</p><h2>BUILT FOR THE<br>RIDES AHEAD.</h2><a href="{{ url('/#join') }}">ASK ABOUT THE CLUB <i>↗</i></a></section>
    </main>
    <footer class="shop-footer"><span>MISTFITS CC</span><span>INDEPENDENT BY NATURE / TOGETHER ON THE ROAD</span><a href="{{ url('/') }}">BACK TO CLUB ↗</a></footer>
</body>
</html>
