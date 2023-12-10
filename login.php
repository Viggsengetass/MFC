<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
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
        echo '<p>Bienvenue, ' . (isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : 'Utilisateur') . '!</p>';
        echo '<p>Vous êtes connecté en tant que ' . (isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'utilisateur') . '.</p>';
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
        </form>
        <?php
    }
    ?>
</div>
</body>

</html>
