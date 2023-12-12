// carousel.js
document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.carousel');
    const cards = document.querySelectorAll('.card');
    const arrowLeft = document.querySelector('.arrow-left');
    const arrowRight = document.querySelector('.arrow-right');

    let currentIndex = 0;

    function showCard(index) {
        cards.forEach((card, i) => {
            card.style.transform = `translateX(${(i - index) * 100}%)`;
            card.style.height = '400px'; /* Expansion en hauteur */
        });
    }

    arrowLeft.addEventListener('click', function () {
        currentIndex = Math.max(currentIndex - 1, 0);
        showCard(currentIndex);
    });

    arrowRight.addEventListener('click', function () {
        currentIndex = Math.min(currentIndex + 1, cards.length - 1);
        showCard(currentIndex);
    });

    function autoScroll() {
        currentIndex = (currentIndex + 1) % cards.length;
        showCard(currentIndex);
    }

    setInterval(autoScroll, 4000); // Défilement automatique toutes les 4 secondes

    // Afficher la première carte
    showCard(currentIndex);
});
