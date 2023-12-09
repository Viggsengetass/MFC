<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - M.F.C MMA Tournament</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/register.css">
</head>
<body class="bg-gray-100">
<div class="container">
    <input type="checkbox" id="login_toggle">
    <form class="form" method="post" action="login-process.php" class="space-y-4">
        <div class="form_front">
            <div class="form_details">Login</div>
            <?php
            // Affichez un message d'erreur s'il y en a un
            if (isset($_SESSION['login_error'])) {
                echo '<p class="error">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']); // Nettoyez la variable de session après l'affichage
            }

            // Affichez un message de succès pour l'inscription
            if (isset($_SESSION['registration_success'])) {
                echo '<p class="success">' . $_SESSION['registration_success'] . '</p>';
                unset($_SESSION['registration_success']);
            }
            ?>
            <input placeholder="Username" name="username" class="input" type="text">
            <input placeholder="Password" name="password" class="input" type="password">
            <button class="btn" type="submit">Login</button>
            <span class="switch">Don't have an account?
                    <label class="login_tog" for="login_toggle">
                        Sign Up
                    </label>
                </span>
        </div>
        <div class="form_back">
            <div class="form_details">Sign Up</div>
            <input placeholder="Firstname" name="firstname" class="input" type="text">
            <input placeholder="Username" name="register_username" class="input" type="text">
            <input placeholder="Email" name="register_email" class="input" type="email">
            <input placeholder="Password" name="register_password" class="input" type="password">
            <input placeholder="Confirm Password" name="confirm_password" class="input" type="password">
            <button class="btn" type="submit">Signup</button>
            <span class="switch">Already have an account?
                    <label class="login_tog" for="login_toggle">
                        Sign In
                    </label>
                </span>
        </div>
    </form>
</div>
</body>
</html>
