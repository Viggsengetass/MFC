document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.container');
    const cards = document.querySelectorAll('.card');
    const cardWidth = 250; // Largeur d'une carte en pixels
    const cardMargin = 10; // Marge entre les cartes en pixels
    const animationDuration = 0.5; // Durée de l'animation en secondes

    cards.forEach((card) => {
        card.addEventListener('mouseenter', function () {
            card.classList.add('expanded');
        });

        card.addEventListener('mouseleave', function () {
            card.classList.remove('expanded');
        });
    });

    const arrowLeft = document.querySelector('.arrow-left');
    const arrowRight = document.querySelector('.arrow-right');
    let currentIndex = 0;

    arrowLeft.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
            slideCarousel();
        }
    });

    arrowRight.addEventListener('click', function () {
        if (currentIndex < cards.length - 1) {
            currentIndex++;
            slideCarousel();
        }
    });

    function slideCarousel() {
        const offset = -currentIndex * (cardWidth + cardMargin);
        container.style.transition = `transform ${animationDuration}s ease-in-out`;
        container.style.transform = `translateX(${offset}px)`;
    }

    // Défilement automatique toutes les 4 secondes
    setInterval(() => {
        if (currentIndex < cards.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        slideCarousel();
    }, 4000);
});
