<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include 'header.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - M.F.C MMA Tournament</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/register.css">
</head>

<body class="bg-gray-100">
<div class="container">
    <?php
    if (isset($_SESSION['user'])) {
        echo '<p>Bienvenue, ' . $_SESSION['user']['username'] . '!</p>';
        echo '<p>Vous êtes connecté en tant que ' . $_SESSION['user']['role'] . '.</p>';
        echo '<p><a href="logout.php">Déconnexion</a></p>';
    } else {
        ?>
        <input type="checkbox" id="login_toggle">
        <form class="form" method="post" action="login-process.php" class="space-y-4">
            <?php
            if (isset($_SESSION['login_error'])) {
                echo '<p class="error">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']);
            }
            ?>
            <div class="form_front">
                <div class="form_details">Login</div>
                <input placeholder="Username" name="username" class="input" type="text">
                <input placeholder="Password" name="password" class="input" type="password">
                <button class="btn" type="submit">Login</button>
                <span class="switch">Don't have an account?
                        <a href="register.php">Sign Up</a>
                    </span>
            </div>
            <div class="form_back">
                <div class="form_details">Sign Up</div>
                <input placeholder="Firstname" class="input" type="text">
                <input placeholder="Username" class="input" type="text">
                <input placeholder="Email" class="input" type="text">
                <input placeholder="Password" class="input" type="password">
                <input placeholder="Confirm Password" class="input" type="password">
                <button class="btn">Signup</button>
                <span class="switch">Already have an account?
                        <label class="login_tog" for="login_toggle">
                            Sign In
                        </label>
                    </span>
            </div>
        </form>
        <?php
    }
    ?>
</div>
</body>

</html>
