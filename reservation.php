<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation d'Événement</title>
    <style>
        body {
            background-color: #121212; /* Couleur de fond sombre */
            margin-top: 15%; /* Marge supérieure de 15% */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #292929; /* Couleur de fond du conteneur */
            padding: 16px;
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), -5px -5px 15px rgba(255, 255, 255, 0.1); /* Effet de neumorphisme */
        }

        .container h1 {
            color: #ffffff; /* Couleur du texte en blanc */
        }

        .container select,
        .container input[type="number"],
        .container button {
            background-color: #2b2b2b; /* Couleur de fond des champs de formulaire */
            border: none;
            color: #ffffff; /* Couleur du texte en blanc */
        }

        .container select,
        .container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
        }

        .container button {
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-xl font-bold mb-4">Réservation d'Événement</h1>

    <!-- Affichage de la liste des événements -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="evenement_id">
            Sélectionnez un Événement
        </label>
        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="evenement_id" name="evenement_id" required>
            <option value="" disabled selected>Choisissez un événement</option>
            <!-- Vous pouvez ajouter des options ici -->
        </select>
    </div>

    <!-- Formulaire de réservation -->
    <form action="reservation.php" method="post" class="mt-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre_billets">
                Nombre de Billets
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nombre_billets" name="nombre_billets" type="number" min="1" required>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Réserver
        </button>
    </form>
</div>
</body>
</html>