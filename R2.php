<?php
session_start();
$email_connecte = $_SESSION['email_connecte'];
//$email_connecte = "dced";
//echo "wewe<br><br><br>" ;
//echo $email_connecte;
?>
<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Leaflet avec marqueur rouge centré sur l'utilisateur et marqueur jaune</title>
    <!-- Inclure la bibliothèque Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Couleur de fond gris clair */

        }
        #map-container {
            height: 55%;
            width: 100%;
        }
        #map {
            height: 100%;
            width: 100%;
        }
        .legend-container {
            height: 20%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .legend {
            text-align: center;
        }
        .legend img {
            max-width: 100%; /* Adapté à la taille de la fenêtre */
            max-height: 8vh; /* Adapté à la taille de la fenêtre */
        }
    h1 {
        font-family: 'Bangers', cursive;
        text-align: center;
        font-size: 5vw; /* Par exemple, 3 fois la taille par défaut */
        margin: 0 auto; /* Pour centrer horizontalement */
    }

    </style>
</head>
<body>
    <br>
    <h1>LA MAP DES TOURNOIS</h1>
    <br>
    <div id="map-container">
        <div id="map"></div> <!-- Div pour afficher la carte -->
    </div>
    <!-- Légende -->
    <div class="legend-container">
        <div class="legend">
            <img src="https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png"> Votre position
            <img src="https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png"> Tournois rejoint
            <img src="https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png"> Tournois disponibles
            <img src="https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png"> Mes demandes en attente
        </div>
    </div>

    <script>
        // Initialiser la carte Leaflet
        var map = L.map('map').setView([0, 0], 13); // Définir la vue par défaut

        // Ajouter une couche de tuiles OpenStreetMap à la carte
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Définir l'icône personnalisée pour le marqueur rouge
        var redIcon = L.icon({
            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Ajouter un marqueur rouge à la position de l'utilisateur
        function onLocationFound(e) {
            var radius = e.accuracy / 2;
            L.marker(e.latlng, {icon: redIcon}).addTo(map)
                .bindPopup("My location").openPopup(); // Ajouter une popup au marqueur
            map.setView(e.latlng, 13); // Centrer la carte sur la position de l'utilisateur
        }

        // Fonction en cas d'erreur lors de la récupération de la position
        function onLocationError(e) {
            alert(e.message);
        }

        // Demander la position de l'utilisateur
        map.locate({setView: true, maxZoom: 16});

        // Écouter l'événement de localisation trouvé
        map.on('locationfound', onLocationFound);

        // Écouter l'événement d'erreur de localisation
        map.on('locationerror', onLocationError);
            function addYellowMarker(lat, lng, name, id) {
                console.log("addYellowMarker ");
                // Définir l'icône personnalisée pour le marqueur jaune
                var yellowIcon = L.icon({
                    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                // Créer un formulaire HTML pour le tournoi
                var popupContent = '<h3>' + name + '</h3>' +
                       '<form action="R4.php" method="POST">' +
                       '<input type="hidden" name="id" value="' + id + '">' +
                       '<input type="hidden" name="email_connecte" value="<?php echo $email_connecte; ?>">' + // Champ input avec la valeur de $email_connecte
                       '<button type="submit">VOIR DETAIL</button>' +
                       '</form>';

                // Ajouter un marqueur jaune à la position spécifique avec la popup contenant le formulaire
                var yellowMarker = L.marker([lat, lng], {icon: yellowIcon}).addTo(map)
                    .bindPopup(popupContent); // Utilisez le contenu de la popup avec le formulaire

                // Ajouter un événement de clic pour ouvrir la popup
                yellowMarker.on('click', function() {
                    yellowMarker.openPopup();
                });
            }
        // Fonction pour ajouter un marqueur jaune à une position spécifique
            function addBlueMarker(lat, lng, name, id) {
                console.log("addBlueMarker ");
                // Définir l'icône personnalisée pour le marqueur bleu
                var blueIcon = L.icon({
                    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                // Créer un formulaire HTML pour le tournoi
                var popupContent = '<h3>' + name + '</h3>' +
                       '<form action="R1.php" method="POST">' +
                       '<input type="hidden" name="id" value="' + id + '">' +
                       '<input type="hidden" name="email_connecte" value="<?php echo $email_connecte; ?>">' + // Champ input avec la valeur de $email_connecte
                       '<button type="submit">VOIR DETAIL</button>' +
                       '</form>';

                // Ajouter un marqueur bleu à la position spécifique avec la popup contenant le formulaire
                var blueMarker = L.marker([lat, lng], {icon: blueIcon}).addTo(map)
                                    .bindPopup(popupContent); // Utilisez le contenu de la popup avec le formulaire

                // Ajouter un événement de clic pour ouvrir la popup
                blueMarker.on('click', function() {
                    blueMarker.openPopup();
                });
            }
            // Fonction pour ajouter un marqueur vert à une position spécifique
            function addGreenMarker(lat, lng, name, id) {
                console.log("addGreenMarker ");
                // Définir l'icône personnalisée pour le marqueur vert
                var greenIcon = L.icon({
                    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                var popupContent = '<h3>' + name + '</h3>' +
                       '<form action="R3.php" method="POST">' +
                       '<input type="hidden" name="id" value="' + id + '">' +
                       '<input type="hidden" name="email_connecte" value="<?php echo $email_connecte; ?>">' + // Champ input avec la valeur de $email_connecte
                       '<button type="submit">VOIR DETAIL</button>' +
                       '</form>';

                // Ajouter un marqueur vert à la position spécifique avec la popup contenant le formulaire
                var greenMarker = L.marker([lat, lng], {icon: greenIcon}).addTo(map)
                                    .bindPopup(popupContent); // Utilisez le contenu de la popup avec le formulaire

                // Ajouter un événement de clic pour ouvrir la popup
                greenMarker.on('click', function() {
                    greenMarker.openPopup();
                });
            }



        // Fonction pour ajouter les marqueurs jaunes à partir des coordonnées des tournois ou email_connecte n'est pas inscrit
        function addYellowMarkersFromCoordinates(data) {
            console.log("addYellowMarkersFromCoordinates ");
            for (var i = 0; i < data.length; i++) {
                var tournoi = data[i];
                var lat = tournoi.latitude;
                var lng = tournoi.longitude;
                var name = tournoi.nom;
                var id = tournoi.id_tournois;
                addYellowMarker(lat, lng, name, id);
            }
        }
        // Fonction pour ajouter les marqueurs jaunes à partir des coordonnées des tournois ou email_connecte n'est pas inscrit
        function addBlueMarkersFromCoordinates(data) {
            console.log("addBlueMarkersFromCoordinates ");
            for (var i = 0; i < data.length; i++) {
                var tournoi = data[i];
                var lat = tournoi.latitude;
                var lng = tournoi.longitude;
                var name = tournoi.nom;
                var id = tournoi.id_tournois;
                addBlueMarker(lat, lng, name, id);
            }
        }
        // Fonction pour ajouter les marqueurs verts à partir des coordonnées des tournois où l'utilisateur a des demandes en attente
        function addGreenMarkersFromCoordinates(data) {
            console.log("addGreenMarkersFromCoordinates ");
            for (var i = 0; i < data.length; i++) {
                var tournoi = data[i];
                var lat = tournoi.latitude;
                var lng = tournoi.longitude;
                var name = tournoi.nom;
                var id = tournoi.id_tournois;
                addGreenMarker(lat, lng, name, id);
            }
        }

        // Appel AJAX pour récupérer les coordonnées des tournois depuis PHP
            var email_connecte = "<?php echo $email_connecte; ?>"; // Récupérer la variable PHP
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        try {
                            var data = JSON.parse(this.responseText);
                            addBlueMarkersFromCoordinates(data);
                        } catch (error) {
                            console.error("Erreur lors de l'analyse JSON :", error);
                        }
                    } else {
                        console.error("Erreur de requête :", this.status);
                    }
                }
            };

            xmlhttp.open("GET", "R2_tournois_non_inscrit.php", true);
            xmlhttp.send();
// Appel AJAX pour récupérer les coordonnées des tournois où l'utilisateur est déjà inscrit
        var xmlhttpInscrit = new XMLHttpRequest();
        xmlhttpInscrit.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var dataInscrit = JSON.parse(this.responseText);
                addYellowMarkersFromCoordinates(dataInscrit);
            }
        };
        xmlhttpInscrit.open("GET", "R2_tournois_inscrit.php?email_connecte=" + encodeURIComponent(email_connecte), true);
        xmlhttpInscrit.send();
// Appel AJAX pour récupérer les coordonnées des tournois où l'utilisateur a des demandes en attente
var xmlhttpEnAttente = new XMLHttpRequest();
xmlhttpEnAttente.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var dataEnAttente = JSON.parse(this.responseText);
        addGreenMarkersFromCoordinates(dataEnAttente);
    }
};
xmlhttpEnAttente.open("GET", "R2_tournois_en_attente.php?email_connecte=" + encodeURIComponent(email_connecte), true);
xmlhttpEnAttente.send();

// Fonction pour centrer la carte sur une position par défaut en cas d'erreur de localisation
function centerMapOnDefaultLocation() {
    var defaultLat = 43.541959; // Latitude par défaut
    var defaultLng = 3.964823; // Longitude par défaut
    map.setView([defaultLat, defaultLng], 13); // Centrer la carte sur la position par défaut avec un zoom de 13
}

// Fonction en cas d'erreur lors de la récupération de la position de l'utilisateur
function onLocationError(e) {
    console.error("Erreur de localisation :", e.message);
    centerMapOnDefaultLocation(); // Centrer la carte sur la position par défaut en cas d'erreur de localisation
}

// Écouter l'événement d'erreur de localisation
map.on('locationerror', onLocationError);
    </script>
</body>
</html>
