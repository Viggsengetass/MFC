document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('.carousel');
    const cards = document.querySelectorAll('.card');
    const arrowLeft = document.querySelector('.arrow-left');
    const arrowRight = document.querySelector('.arrow-right');

    let currentIndex = 0;
    let intervalId;

    function showCard(index) {
        cards.forEach((card, i) => {
            card.classList.remove('expanded');
            if (i === index) {
                card.classList.add('expanded');
            }
        });
    }

    arrowLeft.addEventListener('click', function () {
        currentIndex = (currentIndex - 1 + cards.length) % cards.length;
        showCard(currentIndex);
    });

    arrowRight.addEventListener('click', function () {
        currentIndex = (currentIndex + 1) % cards.length;
        showCard(currentIndex);
    });

    function autoScroll() {
        currentIndex = (currentIndex + 1) % cards.length;
        showCard(currentIndex);
    }

    // Défilement automatique toutes les 4 secondes
    intervalId = setInterval(autoScroll, 4000);

    // Arrête le défilement automatique au survol d'une carte
    cards.forEach((card) => {
        card.addEventListener('mouseenter', function () {
            clearInterval(intervalId);
        });

        card.addEventListener('mouseleave', function () {
            intervalId = setInterval(autoScroll, 4000);
        });
    });

    // Afficher la première carte
    showCard(currentIndex);
});
