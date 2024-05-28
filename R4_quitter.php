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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'identifiant du tournoi à annuler
    $id_tournoi = $_POST['id_tournoi'];
    
    // Récupérer l'email de l'utilisateur connecté (vous devrez implémenter cette partie)
    $email_connecte = $_POST['email_connecte']; // Remplacez par la vraie valeur
    
    // Exécuter la requête DELETE pour supprimer la ligne dans la table PARTICIPATION
    $delete_sql = "DELETE FROM PARTICIPATION WHERE email = '$email_connecte' AND numero_tournois = $id_tournoi AND participant = 1";
    
    if ($conn->query($delete_sql) === TRUE) {
        echo "La demande a été annulée avec succès.";
    } else {
        echo "Erreur lors de l'annulation de la demande : " . $conn->error;
    }

    // Rediriger vers index.php
    header("Location: R4.php");
    exit();
}

// Fermer la connexion à la base de données
$conn->close();
?>
