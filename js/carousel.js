document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.container');
    const cards = document.querySelectorAll('.card');
    let expandedCard = null;

    cards.forEach((card) => {
        card.addEventListener('mouseenter', function () {
            if (expandedCard !== null) {
                expandedCard.classList.remove('expanded');
            }
            card.classList.add('expanded');
            expandedCard = card;
        });

        card.addEventListener('mouseleave', function () {
            card.classList.remove('expanded');
            expandedCard = null;
        });
    });
});
