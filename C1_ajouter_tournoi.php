<?php
echo "hey"; // Ajoutez un point-virgule ici pour terminer l'instruction

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php'; // Charger les dépendances de Composer

use GuzzleHttp\Client;

function getCoordinates($address) {
    // Créer un client Guzzle
    $client = new Client();

    // Construire l'URL de l'API OpenStreetMap
    $url = 'https://nominatim.openstreetmap.org/search?q=' . urlencode($address) . '&format=json';

    try {
        // Effectuer la requête GET
        $response = $client->request('GET', $url);

        // Vérifier le statut de la réponse
        if ($response->getStatusCode() == 200) {
            // Analyser la réponse JSON
            $data = json_decode($response->getBody(), true);
            
            // Vérifier si des résultats ont été renvoyés
            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                // Extraire les coordonnées
                $latitude = $data[0]['lat'];
                $longitude = $data[0]['lon'];
                return array('latitude' => $latitude, 'longitude' => $longitude);
            } else {
                // Si les coordonnées ne sont pas trouvées, retourner 0 pour les deux
                return array('latitude' => 0, 'longitude' => 0);
            }
        } else {
            // Si la requête n'a pas abouti, retourner 0 pour les deux coordonnées
            return array('latitude' => 0, 'longitude' => 0);
        }
    } catch (Exception $e) {
        // En cas d'erreur, retourner 0 pour les deux coordonnées
        return array('latitude' => 0, 'longitude' => 0);
    }
}

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    session_start();
    $createur = $_SESSION['email_connecte'];
    $nom_tournois = $_POST["nom_tournois"];
    $date_tournois = $_POST["date_tournois"];
    $lieu_tournois = $_POST["lieu_tournois"];
    $h_tournois = intval($_POST["h_tournois"]);
    $m_tournois = intval($_POST["m_tournois"]);
    $numero_telephone = $_POST["numero_telephone"];
    $nbr_equipe = !empty($_POST["nbr_equipe"]) ? $_POST["nbr_equipe"] : 0;
    $place_maximum = !empty($_POST["place_maximum"]) ? $_POST["place_maximum"] : 1000;
    $plus_info = !empty($_POST["plus_info"]) ? $_POST["plus_info"] : "d";
    $nom_activite = !empty($_POST["nom_activite"]) ? $_POST["nom_activite"] : "d";
    $cash_prize = !empty($_POST["cash_prize"]) ? $_POST["cash_prize"] : 0;
    $cout_tournois = !empty($_POST["cout_tournois"]) ? $_POST["cout_tournois"] : 0;
    $prive = isset($_POST["prive"]) && $_POST["prive"] == 'true' ? 1 : 0;
    $equipe = isset($_POST["equipe"]) && $_POST["equipe"] == 'true' ? 1 : 0;
    $num = isset($_POST["num"]) && $_POST["num"] == 'true' ? 1 : 0;


    // Connexion à la base de données
    $serveur = "localhost"; // Adresse du serveur MySQL (localhost pour MAMP)
    $utilisateur = "admin"; // Nom d'utilisateur MySQL (par défaut pour MAMP)
    $mot_de_passe = "Canard.1010"; // Mot de passe MySQL (par défaut pour MAMP)
    $nom_base_de_donnees = "SITE_TOURNAMENT"; // Nom de la base de données

    // Créer la connexion
    $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees);

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Échec de la connexion à la ligne " . __LINE__ . " : " . $connexion->connect_error);
    }

  
    
    // Adresse à tester
    $adresse = $lieu_tournois;
    $coords = getCoordinates($adresse);
    $latitude = $coords['latitude'];
    $longitude =$coords['longitude'];
    
    // Préparer et exécuter la requête SQL pour insérer le tournoi dans la table TOURNOIS
    $sql = "INSERT INTO TOURNOIS (nom_tournois, date_tournois, lieu_tournois, h_tournois, m_tournois, numero_telephone, prive, equipe, nbr_equipe, place_maximum, plus_info, nom_activite, cash_prize, cout_tournois,createur,demander_numero,latitude,longitude)
            VALUES ('$nom_tournois', '$date_tournois', '$lieu_tournois', $h_tournois, $m_tournois, '$numero_telephone', '$prive', '$equipe', $nbr_equipe, $place_maximum, '$plus_info', '$nom_activite', $cash_prize, $cout_tournois,'$createur','$num',$latitude,$longitude)";

    if ($connexion->query($sql) === TRUE) {
        echo "Le tournoi a été ajouté avec succès à la base de données.";
        // Affichage des valeurs avant l'insertion
        echo "Valeurs du formulaire : <br>";
        echo "Nom du tournoi : " . $nom_tournois . " (" . gettype($nom_tournois) . ")<br>";
        echo "Date du tournoi : " . $date_tournois . " (" . gettype($date_tournois) . ")<br>";
        echo "Lieu du tournoi : " . $lieu_tournois . " (" . gettype($lieu_tournois) . ")<br>";
        echo "Heure du tournoi : " . $h_tournois . " (" . gettype($h_tournois) . ")<br>";
        echo "Minutes du tournoi : " . $m_tournois . " (" . gettype($m_tournois) . ")<br>";
        echo "Numéro de téléphone : " . $numero_telephone . " (" . gettype($numero_telephone) . ")<br>";
        echo "Privé : " . ($prive ? 'true' : 'false') . " (" . gettype($prive) . ")<br>";
        echo "Équipe : " . ($equipe ? 'true' : 'false') . " (" . gettype($equipe) . ")<br>";
        echo "Nombre d'équipes : " . $nbr_equipe . " (" . gettype($nbr_equipe) . ")<br>";
        echo "Nombre maximum de participants : " . $place_maximum . " (" . gettype($place_maximum) . ")<br>";
        echo "Informations supplémentaires : " . $plus_info . " (" . gettype($plus_info) . ")<br>";
        echo "Nom de l'activité : " . $nom_activite . " (" . gettype($nom_activite) . ")<br>";
        echo "Prix en argent : " . $cash_prize . " (" . gettype($cash_prize) . ")<br>";
        echo "Coût du tournoi : " . $cout_tournois . " (" . gettype($cout_tournois) . ")<br>";
        echo "createur : " . $createur . " (" . gettype($createur) . ")<br>";
        echo "longitude : " . $longitude . " (" . gettype($longitude) . ")<br>";
        echo "latitude : " . $latitude . " (" . gettype($latitude) . ")<br>";
    } else {
        echo "Erreur lors de l'ajout du tournoi à la ligne " . __LINE__ . " : " . $connexion->error;
        // Affichage des valeurs avant l'insertion
        echo "Valeurs du formulaire : <br>";
        echo "Nom du tournoi : " . $nom_tournois . " (" . gettype($nom_tournois) . ")<br>";
        echo "Date du tournoi : " . $date_tournois . " (" . gettype($date_tournois) . ")<br>";
        echo "Lieu du tournoi : " . $lieu_tournois . " (" . gettype($lieu_tournois) . ")<br>";
        echo "Heure du tournoi : " . $h_tournois . " (" . gettype($h_tournois) . ")<br>";
        echo "Minutes du tournoi : " . $m_tournois . " (" . gettype($m_tournois) . ")<br>";
        echo "Numéro de téléphone : " . $numero_telephone . " (" . gettype($numero_telephone) . ")<br>";
        echo "Privé : " . ($prive ? 'true' : 'false') . " (" . gettype($prive) . ")<br>";
        echo "Équipe : " . ($equipe ? 'true' : 'false') . " (" . gettype($equipe) . ")<br>";
        echo "Nombre d'équipes : " . $nbr_equipe . " (" . gettype($nbr_equipe) . ")<br>";
        echo "Nombre maximum de participants : " . $place_maximum . " (" . gettype($place_maximum) . ")<br>";
        echo "Informations supplémentaires : " . $plus_info . " (" . gettype($plus_info) . ")<br>";
        echo "Nom de l'activité : " . $nom_activite . " (" . gettype($nom_activite) . ")<br>";
        echo "Prix en argent : " . $cash_prize . " (" . gettype($cash_prize) . ")<br>";
        echo "Coût du tournoi : " . $cout_tournois . " (" . gettype($cout_tournois) . ")<br>";
        echo "createur : " . $createur . " (" . gettype($createur) . ")<br>";
        echo "longitude : " . $longitude . " (" . gettype($longitude) . ")<br>";
        echo "latitude : " . $latitude . " (" . gettype($latitude) . ")<br>";  // Affichage des valeurs avant l'insertion
        echo "Valeurs du formulaire : <br>";
        echo "Nom du tournoi : " . $nom_tournois . " (" . gettype($nom_tournois) . ")<br>";
        echo "Date du tournoi : " . $date_tournois . " (" . gettype($date_tournois) . ")<br>";
        echo "Lieu du tournoi : " . $lieu_tournois . " (" . gettype($lieu_tournois) . ")<br>";
        echo "Heure du tournoi : " . $h_tournois . " (" . gettype($h_tournois) . ")<br>";
        echo "Minutes du tournoi : " . $m_tournois . " (" . gettype($m_tournois) . ")<br>";
        echo "Numéro de téléphone : " . $numero_telephone . " (" . gettype($numero_telephone) . ")<br>";
        echo "Privé : " . ($prive ? 'true' : 'false') . " (" . gettype($prive) . ")<br>";
        echo "Équipe : " . ($equipe ? 'true' : 'false') . " (" . gettype($equipe) . ")<br>";
        echo "Nombre d'équipes : " . $nbr_equipe . " (" . gettype($nbr_equipe) . ")<br>";
        echo "Nombre maximum de participants : " . $place_maximum . " (" . gettype($place_maximum) . ")<br>";
        echo "Informations supplémentaires : " . $plus_info . " (" . gettype($plus_info) . ")<br>";
        echo "Nom de l'activité : " . $nom_activite . " (" . gettype($nom_activite) . ")<br>";
        echo "Prix en argent : " . $cash_prize . " (" . gettype($cash_prize) . ")<br>";
        echo "Coût du tournoi : " . $cout_tournois . " (" . gettype($cout_tournois) . ")<br>";
        echo "createur : " . $createur . " (" . gettype($createur) . ")<br>";
        echo "longitude : " . $longitude . " (" . gettype($longitude) . ")<br>";
        echo "latitude : " . $latitude . " (" . gettype($latitude) . ")<br>";
    }
    

    // Fermer la connexion à la base de données
    $connexion->close();
}



?>

