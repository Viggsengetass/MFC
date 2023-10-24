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
<?php include 'header.php'; ?> <!-- Inclure le header -->
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded shadow-lg">
        <h1 class="text-3xl font-semibold text-center mb-6">Inscription</h1>
        <form method="post" action="register-process.php" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-600">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" class="form-input" required>
            </div>
            <div>
                <label for="password" class="block text-gray-600">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>
            <div>
                <label for="email" class="block text-gray-600">Email</label>
                <input type="email" id="email" name "email" class="form-input" required>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    S'inscrire
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php'; // Inclure le fichier de configuration de la base de données

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Utilisez la fonction de traitement pour effectuer l'inscription
    if (registerUser($username, $password, $email)) {
        // Rediriger vers la page de connexion après l'inscription réussie
        header('Location: login.php');
    } else {
        // Rediriger vers la page d'inscription avec un message d'erreur
        header('Location: register.php?error=1');
    }
}

// Fonction pour effectuer l'inscription d'un utilisateur
function registerUser($username, $password, $email) {
    global $conn;
    $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $password, $email);

    return $stmt->execute();
}
?>
