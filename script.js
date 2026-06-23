const menuButton = document.querySelector('.menu-icon');
const navLinks = document.querySelector('.nav-links');
const navCloseButton = document.querySelector('.nav-close');

function setMenuOpen(isOpen) {
    if (!navLinks) {
        return;
    }

    navLinks.classList.toggle('show', isOpen);

    if (menuButton) {
        menuButton.setAttribute('aria-expanded', String(isOpen));
        menuButton.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
    }
}

function toggleMenu() {
    if (!navLinks) {
        return;
    }

    setMenuOpen(!navLinks.classList.contains('show'));
}

function closeMenu() {
    setMenuOpen(false);
}

if (menuButton) {
    menuButton.addEventListener('click', toggleMenu);
}

if (navCloseButton) {
    navCloseButton.addEventListener('click', closeMenu);
}

document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', closeMenu);
});

document.addEventListener('click', event => {
    if (!navLinks || !menuButton || !navLinks.classList.contains('show')) {
        return;
    }

    if (navLinks.contains(event.target) || menuButton.contains(event.target)) {
        return;
    }

    closeMenu();
});

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        closeMenu();
    }
});

document.querySelectorAll('.section-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const content = toggle.parentElement.querySelector('.section-content');

        content.classList.toggle('expanded');
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
        }
    });
});
