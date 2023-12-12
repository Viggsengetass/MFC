<!-- combattants.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combattants</title>
    <link rel="stylesheet" href="/style/carousel.css">
    <script src="/js/carousel.js"></script>
</head>
<body>

<div class="container">
    <div class="carousel">
        <?php foreach ($combattants as $combattant) : ?>
            <div class="card">
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
    <div class="arrow arrow-left">&lt;</div>
    <div class="arrow arrow-right">&gt;</div>
</div>

</body>
</html>
