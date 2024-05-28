<?php
// Connexion à la base de données
$servername = "localhost";
$username = "admin";
$password = "Canard.1010";
$dbname = "SITE_TOURNAMENT";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);
// ajoute numero et inscrit tournois
// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $numero = $_POST["num"];
    $id_tournoi = $_POST["id_tournoi"];
    $email_connecte = $_POST["email_connecte"];
    $prive = $_POST["prive"];
    $createur = $_POST["createur"];
    
    // Définir les valeurs pour demandeur et participant en fonction de la confidentialité du tournoi
    $demandeur = ($prive == 1) ? 1 : 0;
    $participant = ($prive == 1) ? 0 : 1;
    
    // Créer la requête d'insertion dans la table PARTICIPATION
    $sql = "INSERT INTO NUMERO_ACCES (email, numero, voyeur) VALUES ('$email_connecte', '$numero', '$createur')";
    
    // Requête d'insertion dans la table PARTICIPATION
    $sql2 = "INSERT INTO PARTICIPATION (numero_tournois, demandeur, participant, email) VALUES ('$id_tournoi', '$demandeur', '$participant', '$email_connecte')";
    
    // Exécuter la requête
    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
        // Rediriger vers index.php
        header("Location: R1.php");
        exit; // Assure que le script s'arrête ici pour éviter toute exécution supplémentaire
    } else {
        echo "Erreur  " . $conn->error;
    }
}

// Fermer la connexion
$conn->close();
?>
