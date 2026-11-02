<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MISTFITS CC cycling gallery.">
    <title>MISTFITS CC</title>
    @include('partials.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="gallery-page">
    <header class="standard-header page-header">
        <a href="{{ url('/') }}" class="wordmark"><img class="brand-logo" src="{{ asset('images/mistfits-boldwhite-logo.png') }}" alt="MISTFITS CC"></a>
        <nav class="desktop-nav" aria-label="Primary navigation"></nav>
        <button class="menu-toggle" aria-label="Open menu" aria-expanded="false" data-menu-toggle><span></span><span></span></button>
    </header><div class="mobile-nav" data-mobile-nav><a href="{{ url('/shop/') }}">SHOP</a><a href="{{ url('/about/') }}">ABOUT</a><a href="{{ url('/rides/') }}">RIDES</a><a href="{{ url('/#racing') }}">RACING</a><a href="{{ url('/gallery/') }}">GALLERY</a></div>
    @php($galleryImages = \App\Support\Gallery::images())
    <main class="gallery-main" aria-label="MISTFITS cycling gallery">
        <section class="gallery-hero" aria-label="MISTFITS cycling film">
            <video autoplay muted loop playsinline preload="metadata" @if ($galleryImages !== []) poster="{{ asset($galleryImages[0]) }}" @endif>
                <source src="{{ asset('images/gallery-hero.mp4') }}" type="video/mp4">
            </video>
        </section>

        @if ($galleryImages !== [])
            <section class="gallery-collection" data-gallery-rotator data-gallery-images='@json($galleryImages)' aria-label="MISTFITS cycling photography">
                <div class="gallery-photo-grid">
                    @foreach (array_slice($galleryImages, 0, min(6, count($galleryImages))) as $index => $image)
                        <figure class="gallery-photo">
                            <img src="{{ asset($image) }}" alt="MISTFITS cycling photography {{ $index + 1 }}" data-gallery-photo data-gallery-index="{{ $index }}" @if ($index > 2) loading="lazy" @else fetchpriority="high" @endif>
                        </figure>
                    @endforeach
                </div>
                @if (count($galleryImages) > 1)
                    <div class="gallery-collection-controls" aria-label="Gallery controls">
                        <button type="button" data-gallery-previous aria-label="Previous photographs">←</button>
                        <button type="button" data-gallery-next aria-label="Next photographs">→</button>
                    </div>
                @endif
            </section>
        @endif
    </main>
    <footer>
        <div class="footer-top"><img class="footer-logo" src="{{ asset('images/mistfits-boldwhite-logo.png') }}" alt="MISTFITS CC"><p>INDEPENDENT BY NATURE.<br>TOGETHER ON THE ROAD.</p></div>
        <div class="footer-bottom"><span>© {{ date('Y') }} MISTFITS CC</span><span>MADE FOR THE LONG WAY</span><div class="footer-socials" data-footer-socials aria-label="Social links"></div></div>
    </footer>
</body>
</html>
