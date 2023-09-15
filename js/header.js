// Fonction pour activer l'animation des liens de navigation
function activateNavLinks() {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach((link, index) => {
        setTimeout(() => {
            link.classList.add('nav-link-show');
        }, 200 * (index + 1));
    });
}

// Attendez que le document soit chargé avant d'activer les animations
document.addEventListener('DOMContentLoaded', () => {
    // Activez l'animation du titre
    const title = document.querySelector('.text-2xl');
    title.classList.add('slideIn');

    // Activez l'animation des liens de navigation après un léger délai
    setTimeout(() => {
        activateNavLinks();
    }, 1000); // Attendre 1 seconde avant d'activer les liens
});
