<!-- header.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta charset="utf-8" />
    <meta name="Description" content="entertainment and Art" />
    <title>Accueil - M.F.C MMA Tournament</title>
    <link rel="stylesheet" href="/style/header.css"> <!-- Fichier de surcharge CSS pour l'en-tête -->
    <link rel="stylesheet" href="https://unpkg.com/feather-icons/dist/feather.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
<nav>
    <div class="menu">
        <input type="checkbox" id="check">
        <div class="logo"><a href="#"><img src="/img/logo.png" alt="MFC Logo" class="logo-img"></a></div>
        <ul>
            <label class="btn cancel" for="check"><i class="fas fa-times"></i></label>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="combattants.php">Combattants</a></li>
            <li><a href="evenements.php">Événements</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Se Connecter</a></li>
        </ul>
        <label for="check" class="btn bars"><i class="fas fa-bars"></i></label>
    </div>
</nav>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
</body>

</html>
