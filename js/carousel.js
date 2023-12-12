document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.card');

    cards.forEach((card, index) => {
        card.addEventListener('mouseover', function () {
            // Réinitialise toutes les cartes pour qu'elles ne soient pas étendues
            cards.forEach((c) => c.classList.remove('expanded'));
            card.classList.add('expanded');
        });

        card.addEventListener('mouseout', function () {
            card.classList.remove('expanded');
        });
    });
});
