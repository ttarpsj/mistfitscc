import './bootstrap';

const instagramUrl = 'https://www.instagram.com/mistfits.cc/';

document.querySelector('.desktop-nav a[href="#kit"]')?.setAttribute('href', window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/shop/' : '/shop/');
document.querySelectorAll('.desktop-nav a[href="#rides"], .shop-header nav a[href$="#rides"]').forEach((link) => link.setAttribute('href', window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/rides/' : '/rides/'));
const primaryNav = document.querySelector('.desktop-nav');
if (primaryNav) {
    const rootPath = window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/' : '/';
    const iconRoot = `${rootPath}icons/`;
    primaryNav.innerHTML = `<a href="${rootPath}shop/">SHOP</a><a href="${rootPath}about/">ABOUT</a><a href="${rootPath}rides/">RIDES</a><a href="${rootPath}#racing">RACING</a><a href="${rootPath}gallery/">GALLERY</a><span class="nav-social-icons"><a class="nav-icon" href="https://www.strava.com/login" target="_blank" rel="noopener noreferrer" aria-label="Strava"><img src="${iconRoot}strava.svg" alt=""></a><a class="nav-icon" href="${instagramUrl}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="${iconRoot}instagram-alt.svg" alt=""></a><a class="nav-icon" href="https://open.spotify.com/track/6WUeQiXtr5KQB4RT4fbr63" target="_blank" rel="noopener noreferrer" aria-label="Spotify"><img src="${iconRoot}spotify-fill.svg" alt=""></a></span>`;
}

document.querySelectorAll('footer').forEach((footer) => {
    const socials = footer.querySelector('.footer-socials');
    if (!socials) return;
    const iconRoot = `${window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/' : '/'}icons/`;
    socials.innerHTML = `<a href="https://www.strava.com/login" target="_blank" rel="noopener noreferrer" aria-label="Strava"><img src="${iconRoot}strava.svg" alt=""></a><a href="${instagramUrl}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="${iconRoot}instagram-alt.svg" alt=""></a><a href="https://open.spotify.com/track/6WUeQiXtr5KQB4RT4fbr63" target="_blank" rel="noopener noreferrer" aria-label="Spotify"><img src="${iconRoot}spotify-fill.svg" alt=""></a>`;
});

const toggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
toggle?.addEventListener('click', () => {
    const isOpen = mobileNav.classList.toggle('open');
    toggle.classList.toggle('open', isOpen);
    toggle.setAttribute('aria-expanded', String(isOpen));
    document.body.style.overflow = isOpen ? 'hidden' : '';
});
mobileNav?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => toggle?.click()));

const newsBanner = document.querySelector('.news-banner');
const newsTargets = ['#rides', '#racing', '#kit'];
const dismissNews = document.createElement('button');
dismissNews.className = 'news-dismiss';
dismissNews.type = 'button';
dismissNews.setAttribute('aria-label', 'Dismiss club updates');
dismissNews.textContent = '×';
newsBanner?.append(dismissNews);
newsBanner?.querySelectorAll('.news-rotator p').forEach((message, index) => {
    message.setAttribute('role', 'link');
    message.setAttribute('tabindex', '0');
    const followUpdate = () => document.querySelector(newsTargets[index])?.scrollIntoView({ behavior: 'smooth' });
    message.addEventListener('click', followUpdate);
    message.addEventListener('keydown', (event) => { if (event.key === 'Enter' || event.key === ' ') followUpdate(); });
});
dismissNews.addEventListener('click', () => newsBanner?.classList.add('is-dismissed'));

const track = document.querySelector('[data-kit-track]');
const amount = () => Math.min(track?.clientWidth * .82 || 0, 436);
document.querySelector('[data-kit-prev]')?.addEventListener('click', () => track?.scrollBy({ left: -amount(), behavior: 'smooth' }));
document.querySelector('[data-kit-next]')?.addEventListener('click', () => track?.scrollBy({ left: amount(), behavior: 'smooth' }));

const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
    if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
}), { threshold: .08 });
document.querySelectorAll('.reveal').forEach((section) => observer.observe(section));

const brandTrack = document.querySelector('[data-brand-track]');
const brandControls = document.querySelector('[data-brand-controls]');
const brandPrevious = document.querySelector('[data-brand-prev]');
const brandNext = document.querySelector('[data-brand-next]');
if (brandTrack && brandControls && brandPrevious && brandNext) {
    const updateBrandControls = () => {
        const overflows = brandTrack.scrollWidth > brandTrack.clientWidth + 1;
        brandControls.hidden = !overflows;
        brandPrevious.disabled = !overflows || brandTrack.scrollLeft <= 1;
        brandNext.disabled = !overflows || brandTrack.scrollLeft + brandTrack.clientWidth >= brandTrack.scrollWidth - 1;
    };
    const scrollBrands = (direction) => {
        const card = brandTrack.querySelector('.brand-partner');
        const gap = Number.parseFloat(getComputedStyle(brandTrack).gap) || 0;
        brandTrack.scrollBy({ left: direction * ((card?.getBoundingClientRect().width || 0) + gap), behavior: 'smooth' });
    };
    brandPrevious.addEventListener('click', () => scrollBrands(-1));
    brandNext.addEventListener('click', () => scrollBrands(1));
    brandTrack.addEventListener('scroll', updateBrandControls, { passive: true });
    new ResizeObserver(updateBrandControls).observe(brandTrack);
    updateBrandControls();
}

document.querySelectorAll('[data-copy-code]').forEach((button) => {
    const code = button.dataset.copyCode;
    const status = button.parentElement?.querySelector('.brand-copy-status');
    button.addEventListener('click', async () => {
        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(code);
            } else {
                const temporaryInput = document.createElement('textarea');
                temporaryInput.value = code;
                temporaryInput.setAttribute('readonly', '');
                temporaryInput.style.position = 'fixed';
                temporaryInput.style.opacity = '0';
                document.body.append(temporaryInput);
                temporaryInput.select();
                document.execCommand('copy');
                temporaryInput.remove();
            }
            if (status) status.textContent = 'COPIED';
        } catch {
            if (status) status.textContent = 'COPY FAILED';
        }
        window.setTimeout(() => { if (status) status.textContent = ''; }, 1800);
    });
});

const productImageStrip = document.querySelector('[data-product-image-strip]');
if (productImageStrip) {
    const productImages = JSON.parse(productImageStrip.dataset.productImages || '[]');
    const tiles = [...productImageStrip.querySelectorAll('[data-product-image]')];
    const rootPath = window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/' : '/';
    const chooseImage = (current) => {
        const alternatives = productImages.filter((image) => image !== current);
        return alternatives[Math.floor(Math.random() * alternatives.length)] || current;
    };
    const setTileImage = (tile) => {
        const next = chooseImage(tile.dataset.currentImage);
        if (!next || next === tile.dataset.currentImage) return;
        tile.classList.add('is-changing');
        window.setTimeout(() => {
            tile.src = `${rootPath}${next}`;
            tile.dataset.currentImage = next;
            tile.classList.remove('is-changing');
        }, 180);
    };
    tiles.forEach(setTileImage);
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const productImageTimer = window.setInterval(() => setTileImage(tiles[Math.floor(Math.random() * tiles.length)]), 2400);
        window.addEventListener('pagehide', () => window.clearInterval(productImageTimer), { once: true });
    }
}

document.querySelectorAll('[data-product-gallery]').forEach((gallery) => {
    const images = JSON.parse(gallery.dataset.galleryImages || '[]');
    const primaryImage = gallery.querySelector('[data-gallery-image]');
    const previous = gallery.querySelector('[data-gallery-previous]');
    const next = gallery.querySelector('[data-gallery-next]');
    const pagination = gallery.querySelector('[data-gallery-pagination]');
    const dots = [...gallery.querySelectorAll('[data-gallery-dot]')];
    const rootPath = window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/' : '/';
    let currentIndex = 0;
    const selectImage = (index) => {
        if (!images.length || !primaryImage) return;
        currentIndex = (index + images.length) % images.length;
        primaryImage.classList.add('is-changing');
        window.setTimeout(() => {
            primaryImage.src = `${rootPath}${images[currentIndex]}`;
            primaryImage.alt = `${gallery.getAttribute('aria-label')?.replace(' image gallery', '') || 'Product'}, image ${currentIndex + 1}`;
            primaryImage.classList.remove('is-changing');
        }, 110);
        dots.forEach((dot, dotIndex) => dot.toggleAttribute('aria-current', dotIndex === currentIndex));
    };
    if (images.length < 2) {
        previous?.setAttribute('hidden', '');
        next?.setAttribute('hidden', '');
        pagination?.setAttribute('hidden', '');
        return;
    }
    previous?.addEventListener('click', () => selectImage(currentIndex - 1));
    next?.addEventListener('click', () => selectImage(currentIndex + 1));
    dots.forEach((dot) => dot.addEventListener('click', () => selectImage(Number(dot.dataset.galleryIndex))));
    gallery.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') { event.preventDefault(); selectImage(currentIndex - 1); }
        if (event.key === 'ArrowRight') { event.preventDefault(); selectImage(currentIndex + 1); }
    });
});

const galleryRotator = document.querySelector('[data-gallery-rotator]');
if (galleryRotator) {
    const images = JSON.parse(galleryRotator.dataset.galleryImages || '[]');
    const photos = [...galleryRotator.querySelectorAll('[data-gallery-photo]')];
    const previous = galleryRotator.querySelector('[data-gallery-previous]');
    const next = galleryRotator.querySelector('[data-gallery-next]');
    const rootPath = window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/' : '/';
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let startIndex = 0;
    let rotationTimer;

    const preloadNextSet = () => {
        if (images.length < 2) return;
        const nextStart = (startIndex + photos.length) % images.length || 1;
        photos.forEach((_, index) => {
            const image = new Image();
            image.src = `${rootPath}${images[(nextStart + index) % images.length]}`;
        });
    };

    const render = (nextStart, animate = true) => {
        if (!images.length) return;
        startIndex = (nextStart + images.length) % images.length;
        photos.forEach((photo, index) => {
            const imageIndex = (startIndex + index) % images.length;
            if (Number(photo.dataset.galleryIndex) === imageIndex) return;
            if (animate && !reducedMotion) photo.classList.add('is-changing');
            window.setTimeout(() => {
                photo.src = `${rootPath}${images[imageIndex]}`;
                photo.alt = `MISTFITS cycling photography ${imageIndex + 1}`;
                photo.dataset.galleryIndex = String(imageIndex);
                photo.classList.remove('is-changing');
            }, animate && !reducedMotion ? 200 : 0);
        });
        preloadNextSet();
    };

    const advance = (direction = 1) => render(startIndex + (direction * (photos.length % images.length || 1)));
    const stopRotation = () => window.clearInterval(rotationTimer);
    const startRotation = () => {
        stopRotation();
        if (!reducedMotion && images.length > 1 && !document.hidden) rotationTimer = window.setInterval(() => advance(1), 5000);
    };

    previous?.addEventListener('click', () => { advance(-1); startRotation(); });
    next?.addEventListener('click', () => { advance(1); startRotation(); });
    document.addEventListener('visibilitychange', () => document.hidden ? stopRotation() : startRotation());
    window.addEventListener('pagehide', stopRotation, { once: true });
    preloadNextSet();
    startRotation();
}
