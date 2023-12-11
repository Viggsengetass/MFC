<?php
// ... (Votre code PHP existant)

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combattants</title>
    <link rel="stylesheet" href="/style/dark-neumorphic.css">
    <link rel="stylesheet" href="/style/carousel.css"> <!-- Ajout du lien vers le nouveau fichier CSS -->
    <style>
        .carte-combattant {
            display: none; /* Cacher les cartes individuelles */
        }

        #content {
            display: none; /* Cacher la liste de combattants */
        }

        /* Ajout du style pour cacher les combattants dans le carrousel */
        .carousel-item {
            flex: 0 0 250px;
            border-radius: 0.5rem;
            transition: 0.5s ease-in-out;
            cursor: pointer;
            box-shadow: 1px 5px 15px #1e0e3e;
            position: relative;
            overflow: hidden;
            margin: 0 10px;
        }

        .carousel-item img {
            width: 100%;
            height: auto;
        }

        .carousel-item .content {
            font-size: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            padding: 15px;
            opacity: 0;
            flex-direction: column;
            height: 100%;
            justify-content: flex-end;
            background: #02022e;
            background: linear-gradient(0deg, rgba(2, 2, 46, 0.6755077031) 0%, rgba(255, 255, 255, 0) 100%);
            transform: translateY(100%);
            transition: opacity 0.5s ease-in-out, transform 0.5s 0.2s;
            visibility: hidden;
        }

        .carousel-item:hover {
            flex: 0 0 300px;
            box-shadow: 1px 3px 15px #7645d8;
            transform: translateY(-30px);
        }

        .carousel-item:hover .content {
            opacity: 1;
            transform: translateY(0%);
            visibility: visible;
        }

        .carousel-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
        }

        .carousel-wrapper {
            display: flex;
            width: max-content;
        }
    </style>
</head>
<body>
<div class="carousel-container">
    <div class="carousel-wrapper">
        <?php foreach ($combattants as $combattant) : ?>
            <div class="carousel-item">
                <img src="<?= $combattant['image'] ?>" alt="<?= $combattant['nom'] . ' ' . $combattant['prenom'] ?>">
                <div class="content">
                    <h2><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></h2>
                    <span>Surnom: <?= $combattant['surnom'] ?></span>
                    <span>Description: <?= $combattant['description'] ?></span>
                    <span>Catégorie: <?= isset($categories[$combattant['categorie_id']]) ? $categories[$combattant['categorie_id']] : 'Inconnue' ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // JavaScript pour le carrousel
    const carouselWrapper = document.querySelector('.carousel-wrapper');
    let currentIndex = 0;

    setInterval(() => {
        currentIndex = (currentIndex + 1) % <?= count($combattants) ?>; // Nombre total de combattants
        const translateValue = -currentIndex * 300; // 300 est la largeur d'un élément plus la marge
        carouselWrapper.style.transform = `translateX(${translateValue}px)`;
    }, 3000); // Changement toutes les 3 secondes, ajustez selon vos besoins
</script>

</body>
</html>
