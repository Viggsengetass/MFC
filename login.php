<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - M.F.C MMA Tournament</title>
    <link rel="stylesheet" href="/style/register.css">
    <style>
        .popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
        }
        .success { border-color: green; }
        .error { border-color: red; }
    </style>
</head>

<body class="bg-gray-100">
<div class="container">
    <?php
    session_start();
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
        setTimeout(function() { msgDiv.remove(); }, 3000);
        <?php unset($_SESSION['message']); ?>
        <?php } ?>

        <?php if (isset($_SESSION['error'])) { ?>
        var errorDiv = document.createElement("div");
        errorDiv.classList.add("popup", "error");
        errorDiv.textContent = "<?php echo $_SESSION['error']; ?>";
        document.body.appendChild(errorDiv);
        setTimeout(function() { errorDiv.remove(); }, 3000);
        <?php unset($_SESSION['error']); ?>
        <?php } ?>
    };
</script>

</body>

</html>
