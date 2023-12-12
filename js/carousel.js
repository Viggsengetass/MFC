document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.container');
    const cards = document.querySelectorAll('.card');

    cards.forEach((card) => {
        card.addEventListener('mouseenter', function () {
            cards.forEach((c) => c.classList.remove('expanded'));
            card.classList.add('expanded');
        });
    });
});
