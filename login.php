<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - M.F.C MMA Tournament</title>
    <link rel="stylesheet" href="/style/login.css">
    <?php include 'common.php'; ?>

</head>
<body class="bg-gray-100">
<?php include 'header.php'; ?> <!-- Inclure le header -->
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded shadow-lg">
        <h1 class="text-3xl font-semibold mb-6">Connexion</h1>
        <form method="post" action="login-process.php">
            <div class="mb-4">
                <label for="username" class="block text-gray-600">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" class="form-input" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-600">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Se connecter</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php'; // Inclure le fichier de configuration de la base de données

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Utilisez la fonction de traitement pour vérifier les informations de connexion
    if (verifyLogin($username, $password)) {
        // Rediriger vers la page appropriée (par exemple, l'espace client)
        header('Location: client-dashboard.php');
    } else {
        // Rediriger vers la page de connexion avec un message d'erreur
        $_SESSION['login_error'] = 'Identifiants incorrects';
        header('Location: login.php');
    }
}

// Fonction pour vérifier les informations de connexion
function verifyLogin($username, $password) {
    global $conn;
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    return ($result->num_rows == 1);
}
?>
