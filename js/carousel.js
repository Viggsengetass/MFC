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
        // Défilement automatique toutes les 4 secondes
        clearInterval(intervalId);
        intervalId = setInterval(autoScroll, 4000);
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

    // Afficher la première carte
    showCard(currentIndex);
});
