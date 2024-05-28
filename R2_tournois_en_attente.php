<?php
session_start();
$email_connecte = $_SESSION['email_connecte'];
//Utilisez $_GET pour récupérvariable// Paramètres de connexion à la base de données MySQLs
$serveur = "localhost"; // Adresse du serveur MySQL (localhost pour MAMP)
$utilisateur = "admin"; // Nom d'utilisateur MySQL (par défaut pour MAMP)
$mot_de_passe = "Canard.1010"; // Mot de passe MySQL (par défaut pour MAMP)
$nom_base_de_donnees = "SITE_TOURNAMENT"; // Nom de la base de données

// Connexion à la base de données MySQL
$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees);

// Vérification de la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Requête SQL pour récupérer les coordonnées de latitude et de longitude ainsi que les noms des tournois != '$email_connecte'" car on veut les tournois qu'on peut rejoindre
$sql = "SELECT * FROM TOURNOIS AS t LEFT JOIN PARTICIPATION AS p ON p.numero_tournois = t.id_tournois WHERE p.email = '$email_connecte' AND t.id_tournois IN (SELECT numero_tournois FROM PARTICIPATION WHERE email = '$email_connecte' AND demandeur=1);";

$resultat = $connexion->query($sql);

// Vérification s'il y a des résultats
if ($resultat->num_rows > 0) {
    // Création d'un tableau pour stocker les données des tournois
    $tournois = array();

    // Parcours des résultats et stockage des données dans le tableau
    while($ligne = $resultat->fetch_assoc()) {
        $tournois[] = array(
            'nom' => $ligne['nom_tournois'],
            'latitude' => $ligne['latitude'],
            'longitude' => $ligne['longitude'],
            'id_tournois' => $ligne['id_tournois']
        );
    }

    // Renvoi des données au format JSON
    echo json_encode($tournois);
} else {
    // Si aucun résultat n'est trouvé, renvoyer un tableau vide
    echo json_encode(array());
}

// Fermeture de la connexion à la base de données MySQL
$connexion->close();
?>
