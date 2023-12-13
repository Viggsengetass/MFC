<?php
// Inclut les fichiers nécessaires
include 'common.php';
include 'admin-functions.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - M.F.C MMA Tournament</title>
    <link rel="stylesheet" href="/style/dark-neumorphic.css">

    <link rel="stylesheet" href="/style/contact.css">

</head>
<body>
<div class="min-h-screen flex items-center justify-center">
    <div class="neumorphism p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4">Contactez-nous</h2>
        <form action="#" method="post">
            <div class="mb-4">
                <label for="name" class="block text-gray-600 text-sm font-semibold mb-2">Nom</label>
                <input type="text" id="name" name="name" placeholder="Votre nom" class="w-full p-2 neumorphism-input rounded">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-600 text-sm font-semibold mb-2">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Votre e-mail" class="w-full p-2 neumorphism-input rounded">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-gray-600 text-sm font-semibold mb-2">Message</label>
                <textarea id="message" name="message" rows="4" placeholder="Votre message" class="w-full p-2 neumorphism-input rounded"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="neumorphism-button text-white px-4 py-2 rounded hover:bg-blue-600">Envoyer</button>
            </div>
        </form>
<!--        --><?php
//        // Inclure le contenu de social.php
//        include 'social.php';
//        ?>
    </div>
</div>
</body>
</html>