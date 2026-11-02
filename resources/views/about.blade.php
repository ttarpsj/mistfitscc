<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="About MISTFITS Cycling Club.">
    <title>MISTFITS CC</title>
    @include('partials.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="about-page">
    <main id="top">
        <section class="hero about-hero">
            <header class="site-header" data-header>
                <a class="wordmark" href="{{ url('/') }}" aria-label="MISTFITS CC home"><img class="brand-logo" src="{{ asset('images/mistfits-boldwhite-logo.png') }}" alt="MISTFITS CC"></a>
                <nav class="desktop-nav" aria-label="Primary navigation"></nav>
                <button class="menu-toggle" aria-label="Open menu" aria-expanded="false" data-menu-toggle><span></span><span></span></button>
            </header><div class="mobile-nav" data-mobile-nav><a href="{{ url('/shop/') }}">SHOP</a><a href="{{ url('/about/') }}">ABOUT</a><a href="{{ url('/rides/') }}">RIDES</a><a href="{{ url('/#racing') }}">RACING</a><a href="{{ url('/gallery/') }}">GALLERY</a></div>
            <img src="{{ asset('images/DSC08954-5.png') }}" alt="Road cyclists riding together" class="hero-image">
            <div class="hero-wash"></div>
        </section>
        <section class="about-ethos">
            <h1>ETHOS</h1>
            <p>A Midwest-born community for cycling enthusiasts looking for people to connect, ride, and compete with. MCC is an organic cycling collective rooted in the Driftless Region. These products were created to celebrate the roads we ride and the people who come together on them every week.</p>
        </section>
        <section class="about-social-banner" aria-label="MISTFISTS Cycling Club social links">
            <a href="https://www.strava.com/login" target="_blank" rel="noopener noreferrer" aria-label="Strava"><img src="{{ asset('icons/strava.svg') }}" alt=""></a>
            <span>MISTFISTS CYCLING CLUB</span>
            <a href="{{ config('social.instagram') }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="{{ asset('icons/instagram-alt.svg') }}" alt=""></a>
        </section>
    </main>
    <footer>
        <div class="footer-top"><img class="footer-logo" src="{{ asset('images/mistfits-boldwhite-logo.png') }}" alt="MISTFITS CC"><p>INDEPENDENT BY NATURE.<br>TOGETHER ON THE ROAD.</p></div>
        <div class="footer-bottom"><span>© {{ date('Y') }} MISTFITS CC</span><span>MADE FOR THE LONG WAY</span><div class="footer-socials" data-footer-socials aria-label="Social links"></div></div>
    </footer>
</body>
</html>
