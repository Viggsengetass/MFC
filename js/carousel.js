document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.container');
    const cards = document.querySelectorAll('.card');

    cards.forEach((card) => {
        card.addEventListener('mouseenter', function () {
            cards.forEach((c) => {
                if (c === card) {
                    c.classList.add('expanded');
                } else {
                    c.classList.remove('expanded');
                }
            });
        });

        card.addEventListener('mouseleave', function () {
            card.classList.remove('expanded');
        });
    });

    const arrowLeft = document.querySelector('.arrow-left');
    const arrowRight = document.querySelector('.arrow-right');
    let currentIndex = 0;

    arrowLeft.addEventListener('click', function () {
        currentIndex = Math.max(currentIndex - 1, 0);
        showCard(currentIndex);
    });

    arrowRight.addEventListener('click', function () {
        currentIndex = Math.min(currentIndex + 1, cards.length - 1);
        showCard(currentIndex);
    });

    function showCard(index) {
        container.style.transform = `translateX(-${index * (200 + 10)}px)`;
    }
});
