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
    <style>
        /* Styles for the popup messages */
        .popup {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            z-index: 1000;
            display: none;
        }

        .success {
            background-color: green;
        }

        .error {
            background-color: red;
        }
    </style>
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
        <form class="form" method="post" action="login-process.php">
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
<script>
    window.onload = function() {
        <?php if (isset($_SESSION['message'])) { ?>
        var msgDiv = document.createElement("div");
        msgDiv.classList.add("popup", "success");
        msgDiv.textContent = "<?php echo $_SESSION['message']; ?>";
        document.body.appendChild(msgDiv);
        setTimeout(function() { msgDiv.style.display = 'none'; }, 3000);
        <?php unset($_SESSION['message']); ?>
        <?php } ?>

        <?php if (isset($_SESSION['error'])) { ?>
        var errorDiv = document.createElement("div");
        errorDiv.classList.add("popup", "error");
        errorDiv.textContent = "<?php echo $_SESSION['error']; ?>";
        document.body.appendChild(errorDiv);
        setTimeout(function() { errorDiv.style.display = 'none'; }, 3000);
        <?php unset($_SESSION['error']); ?>
        <?php } ?>
    };
</script>
</body>

</html>
