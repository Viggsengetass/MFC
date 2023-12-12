document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.carousel');
    const cards = document.querySelectorAll('.card');

    cards.forEach((card, index) => {
        card.addEventListener('mouseover', function () {
            card.classList.add('hovered');
        });

        card.addEventListener('mouseout', function () {
            card.classList.remove('hovered');
        });
    });
});
