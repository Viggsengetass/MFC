<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/index.css">
    <script src="/js/index.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<div id="global">
    <p id="anim" aria-label="CodePen">
        <span data-text="M">M</span>
        <span data-text="O">O</span>
        <span data-text="N">N</span>
        <span data-text="S">S</span>
        <span data-text="T">T</span>
        <span data-text="R">R</span>
        <span data-text="E">E</span>
        <span data-text="-">-</span>
        <span data-text="F">F</span>
        <span data-text=".">.</span>
        <span data-text="C">C</span>
        <span data-text=".">.</span>
    </p>
    <div id="word-wraper">
        <div class="word"></div>
    </div>
    <div id="btn-rank">
        <a href="ranking.php" class="btn btn-primary btn-lg">Tuer nathael</a>
    </div>
</div>

<!-- Section des événements à venir -->
<section class="container mx-auto mt-8">
    <h2 class="text-3xl font-semibold">Événements à venir</h2>
    <!-- Liste des événements à venir -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        <!-- Événement 1 -->
        <div class="bg-white p-4 rounded-lg shadow">
            <img src="event1.jpg" alt="Événement 1" class="w-full h-40 object-cover rounded">
            <h3 class="text-xl font-semibold mt-2">Événement 1</h3>
            <p class="text-gray-500">Date : XX/XX/XXXX</p>
            <p class="mt-2">Description de l'événement.</p>
            <a href="#" class="text-blue-600 hover:underline mt-2">Réserver des billets</a>
        </div>

        <!-- Événement 2 -->
        <div class="bg-white p-4 rounded-lg shadow">
            <img src="event2.jpg" alt="Événement 2" class="w-full h-40 object-cover rounded">
            <h3 class="text-xl font-semibold mt-2">Événement 2</h3>
            <p class="text-gray-500">Date : XX/XX/XXXX</p>
            <p class="mt-2">Description de l'événement.</p>
            <a href="#" class="text-blue-600 hover:underline mt-2">Réserver des billets</a>
        </div>

        <!-- Événement 3 -->
        <div class="bg-white p-4 rounded-lg shadow">
            <img src="event3.jpg" alt="Événement 3" class="w-full h-40 object-cover rounded">
            <h3 class="text-xl font-semibold mt-2">Événement 3</h3>
            <p class="text-gray-500">Date : XX/XX/XXXX</p>
            <p class="mt-2">Description de l'événement.</p>
            <a href="#" class="text-blue-600 hover:underline mt-2">Réserver des billets</a>
        </div>
    </div>
</section>

<!-- Ajoutez d'autres sections et fonctionnalités ici selon vos besoins -->

<?php include 'footer.php'; ?>
</body>
</html>
