<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - M.F.C MMA Tournament</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/register.css">
</head>
<body class="bg-gray-100">
<div class="container">
    <input type="checkbox" id="signup_toggle">
    <form class="form" method="post" action="register-process.php" class="space-y-4">
        <div class="form_front">
            <div class="form_details">Inscription</div>
            <input placeholder="Nom d'utilisateur" name="username" class="input" type="text">
            <input placeholder="Mot de passe" name="password" class="input" type="password">
            <input placeholder="Email" name="email" class="input" type="email">
            <button class="btn" type="submit">S'inscrire</button>
            <span class="switch">Vous avez déjà un compte?
                <label class="signup_tog" for="signup_toggle">
                    Connexion
                </label>
            </span>
        </div>
        <div class="form_back">
            <div class="form_details">Connexion</div>
            <input placeholder="Nom d'utilisateur" class="input" type="text">
            <input placeholder="Mot de passe" class="input" type="password">
            <button class="btn">Connexion</button>
            <span class="switch">Vous n'avez pas de compte?
                <label class="signup_tog" for="signup_toggle">
                    Inscription
                </label>
            </span>
        </div>
    </form>
</div>
</body>
</html>
