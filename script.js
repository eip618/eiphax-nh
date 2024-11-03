function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('show');
}

// Select all the toggle buttons
const toggles = document.querySelectorAll('.section-toggle');

toggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
        // Use querySelector to find the section content by class name
        const content = toggle.parentElement.querySelector('.section-content');

        // Toggle expanded class and set max-height for smooth transition
        content.classList.toggle('expanded');
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
        }
    });
});
