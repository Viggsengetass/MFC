<?php
// combattants.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'common.php';
include 'admin-functions.php';

$combattants = getAllCombattants($conn);

$combattantsParPage = 6;
$nombrePages = ceil(count($combattants) / $combattantsParPage);
$pageActuelle = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$indiceDebut = ($pageActuelle - 1) * $combattantsParPage;
$combattantsPageActuelle = array_slice($combattants, $indiceDebut, $combattantsParPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combattants</title>
    <link rel="stylesheet" href="/style/dark-neumorphic.css">
    <style>
        body {
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #100721;
            font-family: "Ubuntu Mono", monospace;
            font-weight: 400;
            margin: 0;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            height: 500px;
            gap: 10px;
            margin-top: 20%;
        }

        .container > div {
            flex: 0 0 250px;
            border-radius: 0.5rem;
            transition: 0.5s ease-in-out;
            cursor: pointer;
            box-shadow: 1px 5px 15px #1e0e3e;
            position: relative;
            overflow: hidden;
        }

        .container > div .content {
            font-size: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            flex-direction: column;
            height: 100%;
            justify-content: flex-end;
            background: #02022e;
            background: linear-gradient(0deg, rgba(2, 2, 46, 0.6755077031) 0%, rgba(255, 255, 255, 0) 100%);
            transition: transform 0.5s ease-in-out;
            transform: translateY(100%);
        }

        .container > div .content span {
            display: block;
            margin-top: 5px;
            font-size: 1.2rem;
        }

        .container > div:hover {
            flex: 0 0 250px;
            box-shadow: 1px 3px 15px #7645d8;
            transform: translateY(-30px);
        }

        .container > div:hover .content {
            transform: translateY(0%);
        }
    </style>
</head>
<body>

<div class="container">
    <?php foreach ($combattants as $combattant) : ?>
        <div>
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

</body>
</html>
