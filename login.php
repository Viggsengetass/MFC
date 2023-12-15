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
    if (isset($_SESSION['user']) && isset($_SESSION['user']['username'])) {
        // Affiche le message de bienvenue si l'utilisateur est connecté
        echo '<p>Bienvenue, ' . htmlspecialchars($_SESSION['user']['username']) . '!</p>';
        echo '<p>Vous êtes connecté en tant que ' . htmlspecialchars($_SESSION['user']['role']) . '.</p>';
        echo '<p><a href="logout.php">Déconnexion</a></p>';
    } else {
        // Affiche le formulaire de connexion si l'utilisateur n'est pas connecté
        ?>
        <form class="form" method="post" action="login-process.php">
            <div class="form_front">
                <div class="form_details">Login</div>
                <input placeholder="Username" name="username" class="input" type="text" required>
                <input placeholder="Password" name="password" class="input" type="password" required>
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
<script>
    window.onload = function() {
        // Affiche un message flash s'il y en a en session
        <?php if (isset($_SESSION['message'])) { ?>
        alert("<?php echo $_SESSION['message']; ?>");
        <?php unset($_SESSION['message']); ?>
        <?php } ?>

        <?php if (isset($_SESSION['error'])) { ?>
        alert("<?php echo $_SESSION['error']; ?>");
        <?php unset($_SESSION['error']); ?>
        <?php } ?>
    };
</script>
</body>

</html>
