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

        <!-- Popup de Bienvenue -->
        <div id="popupBienvenue" class="popup">
            <div class="popup-contenu">
                <span id="messageBienvenue"></span>
                <button id="fermerBienvenue">Fermer</button>
            </div>
        </div>

        <!-- Popup d'Échec -->
        <div id="popupEchec" class="popup">
            <div class="popup-contenu">
                <span id="messageEchec"></span>
                <button id="fermerEchec">Fermer</button>
            </div>
        </div>

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

    document.addEventListener("DOMContentLoaded", function () {
        // Bouton de Connexion
        const connexionBtn = document.getElementById("connexionBtn");

        // Popups
        const popupBienvenue = document.getElementById("popupBienvenue");
        const popupEchec = document.getElementById("popupEchec");

        // Messages
        const messageBienvenue = document.getElementById("messageBienvenue");
        const messageEchec = document.getElementById("messageEchec");

        // Boutons Fermer
        const fermerBienvenue = document.getElementById("fermerBienvenue");
        const fermerEchec = document.getElementById("fermerEchec");

        // Gestion de l'événement de clic sur le bouton de connexion
        connexionBtn.addEventListener("click", function () {
            // Vous pouvez remplacer cette condition par votre logique de vérification de connexion
            const connexionReussie = true;

            if (connexionReussie) {
                const nomUtilisateur = "John"; // Remplacez par le nom de l'utilisateur réel
                messageBienvenue.textContent = "Bienvenue, " + nomUtilisateur + " !";
                popupBienvenue.style.display = "block";
            } else {
                messageEchec.textContent = "La connexion n'a pas fonctionné. Veuillez réessayer.";
                popupEchec.style.display = "block";
            }
        });

        // Gestion de l'événement de clic sur les boutons Fermer
        fermerBienvenue.addEventListener("click", function () {
            popupBienvenue.style.display = "none";
        });

        fermerEchec.addEventListener("click", function () {
            popupEchec.style.display = "none";
        });
    });
</script>
</body>

</html>
