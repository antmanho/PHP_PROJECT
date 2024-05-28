<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel War</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            height: 70vh; /* 70% de la hauteur de la fenêtre */
            border-collapse: collapse;
        }
        td {
            width: calc(100% / 20); /* Pour un tableau de 20x20 */
            height: calc(70vh / 20); /* 70% de la hauteur de la fenêtre, divisée par le nombre de lignes */
            border: 1px solid black;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Pixel War</h1>
    <p>Choisissez une couleur et cliquez sur un pixel pour le colorer :</p>
    <div>
        <input type="color" id="colorPicker">
    </div>
    <table id="pixelTable">
<?php
    // Connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "admin";
    $mot_de_passe = "Canard.1010";
    $nom_base_de_donnees = "SITE_TOURNAMENT";

    $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees);
    if ($connexion->connect_error) {
        die("Échec de la connexion : " . $connexion->connect_error);
    }

    // Récupérer les couleurs des pixels depuis la base de données
    $sql_select_pixels = "SELECT x, y, couleur FROM PIXEL_WARS";
    $resultat = $connexion->query($sql_select_pixels);
    if ($resultat->num_rows > 0) {
        $pixels = [];
        while ($row = $resultat->fetch_assoc()) {
            $pixels[$row['x']][$row['y']] = $row['couleur'];
        }

        // Définir la taille du tableau de pixels
        $taille_tableau = 20; // Par exemple, un tableau de 20x20

        // Afficher le tableau de pixels avec les couleurs récupérées
        for ($i = 0; $i < $taille_tableau; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $taille_tableau; $j++) {
                $couleur = isset($pixels[$i][$j]) ? $pixels[$i][$j] : "#ffffff"; // Blanc par défaut
                echo "<td id='pixel_$i-$j' style='background-color: $couleur' data-x='$i' data-y='$j'></td>";
            }
            echo "</tr>";
        }
    } else {
        // Aucun pixel enregistré dans la base de données
        $taille_tableau = 20; // Par exemple, un tableau de 20x20
        for ($i = 0; $i < $taille_tableau; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $taille_tableau; $j++) {
                echo "<td id='pixel_$i-$j' style='background-color: #ffffff' data-x='$i' data-y='$j'></td>";
            }
            echo "</tr>";
        }
    }

    $connexion->close();
?>
    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        const ws = new WebSocket('ws://localhost:8080/chat');

        ws.onopen = function(event) {
            console.log('Connexion établie.');
        };

        ws.onmessage = function(event) {
            console.log('Message reçu du serveur :', event.data);
            
            // Vérifiez si le message est "reload"
            if (event.data === 'reload') {
                console.log('Reçu un message de rafraîchissement du serveur.');
                // Actualisez la page
                location.reload();
            }
        };

        // Fonction pour placer un pixel
        function placerPixel(x, y, couleur) {
            console.log('Pixel placé : x = ' + x + ', y = ' + y + ', couleur = ' + couleur);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "ajouter_pixel.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Réponse du serveur : ' + xhr.responseText);
                }
            };
            xhr.send("x=" + x + "&y=" + y + "&couleur=" + encodeURIComponent(couleur));

            // Envoyer une demande d'incrémentation du compteur au serveur WebSocket
            ws.send('refresh');
        }

        // Événement lors du clic sur un pixel
        $('#pixelTable').on('click', 'td', function() {
            var couleur = $('#colorPicker').val();
            var x = $(this).data('x');
            var y = $(this).data('y');

            // Mettre à jour la couleur du pixel sur la page
            $(this).css('background-color', couleur);

            // Appeler la fonction pour placer le pixel
            placerPixel(x, y, couleur);
        });
    </script>
</body>
</html>

