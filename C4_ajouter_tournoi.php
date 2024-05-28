<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $id = $_POST["id_tournois"];
    $createur = $_POST["email_connecte"];
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

    // Affichage des valeurs avant la modification
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

    // Préparer et exécuter la requête SQL pour modifier le tournoi dans la table TOURNOIS
    $sql = "UPDATE TOURNOIS SET nom_tournois='$nom_tournois', date_tournois='$date_tournois', lieu_tournois='$lieu_tournois', h_tournois=$h_tournois, m_tournois=$m_tournois, numero_telephone='$numero_telephone', prive='$prive', equipe='$equipe', nbr_equipe=$nbr_equipe, place_maximum=$place_maximum, plus_info='$plus_info', nom_activite='$nom_activite', cash_prize=$cash_prize, cout_tournois=$cout_tournois,createur='$createur',demander_numero='$num' WHERE id_tournois=$id";

    if ($connexion->query($sql) === TRUE) {
        echo "Le tournoi a été modifié avec succès.";
    } else {
        echo "Erreur lors de la modification du tournoi à la ligne " . __LINE__ . " : " . $connexion->error;
    }
    header("Location: C4.php");
    // Fermer la connexion à la base de données
    $connexion->close();
}

?>
