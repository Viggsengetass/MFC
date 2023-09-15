// Fonction pour activer l'animation des icônes de réseaux sociaux
function activateSocialIcons() {
    const socialIcons = document.querySelectorAll('.social-icon');
    socialIcons.forEach((icon, index) => {
        setTimeout(() => {
            icon.classList.add('social-icon-show');
        }, 200 * (index + 1));
    });
}

// Attendez que le document soit chargé avant d'activer les animations
document.addEventListener('DOMContentLoaded', () => {
    // Activez l'animation des icônes de réseaux sociaux
    activateSocialIcons();
});
