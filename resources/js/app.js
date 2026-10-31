import './bootstrap';

document.querySelector('.desktop-nav a[href="#kit"]')?.setAttribute('href', window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/shop/' : '/shop/');
document.querySelectorAll('.desktop-nav a[href="#rides"], .shop-header nav a[href$="#rides"]').forEach((link) => link.setAttribute('href', window.location.pathname.startsWith('/mistfitscc') ? '/mistfitscc/rides/' : '/rides/'));

document.querySelectorAll('footer').forEach((footer) => {
    if (footer.querySelector('.footer-socials')) return;
    const socials = document.createElement('div');
    socials.className = 'footer-socials';
    socials.innerHTML = '<a href="#" aria-label="Strava">S</a><a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4"></rect><circle cx="12" cy="12" r="3.5"></circle><circle cx="17.2" cy="6.9" r=".8" class="fill-dot"></circle></svg></a><a href="#" aria-label="Spotify"><svg viewBox="0 0 24 24"><path d="M4 9.7c5.5-1.6 10.7-1.1 15.5 1.2M5.4 13.2c4.8-1.3 9.1-.8 13.1 1M6.7 16.5c3.7-1 6.9-.6 9.8.7"></path></svg></a>';
    footer.append(socials);
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

const clubSlides = [...document.querySelectorAll('.club-slide')];
const clubDots = [...document.querySelectorAll('[data-club-dot]')];
let clubSlideIndex = 0;
let clubCarouselTimer;
const showClubSlide = (index) => {
    clubSlideIndex = (index + clubSlides.length) % clubSlides.length;
    clubSlides.forEach((slide, slideIndex) => slide.classList.toggle('active', slideIndex === clubSlideIndex));
    clubDots.forEach((dot, dotIndex) => {
        const active = dotIndex === clubSlideIndex;
        dot.classList.toggle('active', active);
        dot.setAttribute('aria-selected', String(active));
    });
};
const restartClubCarousel = () => {
    clearInterval(clubCarouselTimer);
    clubCarouselTimer = setInterval(() => showClubSlide(clubSlideIndex + 1), 5000);
};
clubDots.forEach((dot, index) => dot.addEventListener('click', () => { showClubSlide(index); restartClubCarousel(); }));
if (clubSlides.length) restartClubCarousel();

const brandTrack = document.querySelector('.brand-track');
let brandCarouselTimer;
const advanceBrands = () => {
    if (!brandTrack) return;
    const card = brandTrack.querySelector('.brand-card');
    const step = card?.getBoundingClientRect().width + 8 || 0;
    if (brandTrack.scrollLeft + brandTrack.clientWidth >= brandTrack.scrollWidth - 3) brandTrack.scrollTo({ left: 0, behavior: 'smooth' });
    else brandTrack.scrollBy({ left: step, behavior: 'smooth' });
};
if (brandTrack) {
    brandCarouselTimer = setInterval(advanceBrands, 3500);
    brandTrack.addEventListener('pointerenter', () => clearInterval(brandCarouselTimer));
    brandTrack.addEventListener('pointerleave', () => { clearInterval(brandCarouselTimer); brandCarouselTimer = setInterval(advanceBrands, 3500); });
}
