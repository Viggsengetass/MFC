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
    <form method="post" action="register-process.php" class="space-y-4">
        <div class="form_front">
            <div class="form_details">Register</div>
            <input placeholder="Nom d'utilisateur" class="input" type="text" name="username">
            <input placeholder="Mot de passe" class="input" type="password" name="password">
            <input placeholder="Email" class="input" type="email" name="email">

            <button class="btn" type="submit">Register</button>
            <span class="switch">Vous n'avez pas de compte?
                <label class="signup_tog" for="signup_toggle">
                    S'inscrire
                </label>
            </span>
        </div>
        <div class="form_back">
            <div class="form_details">SignUp</div>
            <input placeholder="Prénom" class="input" type="text">
            <input placeholder="Nom d'utilisateur" class="input" type="text">
            <input placeholder="Email" class="input" type="email">
            <input placeholder="Mot de passe" class="input" type="password">
            <input placeholder="Confirmez le mot de passe" class="input" type="password">
            <button class="btn">Signup</button>
            <span class="switch">Vous avez déjà un compte?
                <label class="signup_tog" for="signup_toggle">
                    Se connecter
                </label>
            </span>
        </div>
    </form>
</div>
</body>
</html>
