import './bootstrap';

const toggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
toggle?.addEventListener('click', () => {
    const isOpen = mobileNav.classList.toggle('open');
    toggle.classList.toggle('open', isOpen);
    toggle.setAttribute('aria-expanded', String(isOpen));
    document.body.style.overflow = isOpen ? 'hidden' : '';
});
mobileNav?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => toggle?.click()));

const track = document.querySelector('[data-kit-track]');
const amount = () => Math.min(track?.clientWidth * .82 || 0, 436);
document.querySelector('[data-kit-prev]')?.addEventListener('click', () => track?.scrollBy({ left: -amount(), behavior: 'smooth' }));
document.querySelector('[data-kit-next]')?.addEventListener('click', () => track?.scrollBy({ left: amount(), behavior: 'smooth' }));

const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
    if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
}), { threshold: .08 });
document.querySelectorAll('.reveal').forEach((section) => observer.observe(section));
