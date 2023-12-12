document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.card');

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
        cards.forEach((card, index) => {
            if (index === currentIndex) {
                card.style.marginRight = '10px';
            } else {
                card.style.marginRight = '0';
            }
        });
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
