<?php
// Connexion à la base de données
$servername = "localhost";
$username = "admin";
$password = "Canard.1010";
$dbname = "SITE_TOURNAMENT";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer l'ID du tournoi à partir de la requête GET
$tournoisId = $_GET['tournoisId'];
$email_connecte = $_GET['email_connecte'];
// Requête SQL pour vérifier si la demande de numéro est activée pour ce tournoi
$sql_demande_numero = "SELECT * FROM TOURNOIS WHERE id_tournois = $tournoisId AND demander_numero = 1";
$result_demande_numero = $conn->query($sql_demande_numero);

if ($result_demande_numero->num_rows > 0) {
    // Si la demande de numéro est activée, récupérer les participants avec leurs numéros d'accès
    $sql = "SELECT p.email, n.numero
            FROM PARTICIPATION AS p
            JOIN NUMERO_ACCES AS n ON p.email = n.email
            WHERE p.numero_tournois = $tournoisId AND p.participant = 1 AND n.voyeur=$email_connecte";
} else {
    // Sinon, récupérer uniquement les adresses e-mail des participants
    $sql = "SELECT email
            FROM PARTICIPATION
            WHERE numero_tournois = $tournoisId AND participant = 1";
}

$result = $conn->query($sql);

// Créer un tableau pour stocker les participants
$participants = array();

// Ajouter les participants au tableau
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Vérifier si l'e-mail est défini avant de l'ajouter
        if (isset($row['email'])) {
            $participants[] = $row;
        }
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Renvoyer les participants au format JSON
echo json_encode($participants);
?>
