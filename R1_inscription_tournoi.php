
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


    // Récupérer les données du formulaire
    $id_tournoi = $_POST["id_tournoi"];
    echo "<br><br><br><br>";
    echo $id_tournoi;
    $email_connecte = $_POST["email_connecte"];
    echo $email_connecte;
    $prive = $_POST["prive"];

    // Définir les valeurs pour demandeur et participant en fonction de la confidentialité du tournoi
    $demandeur = ($prive == 1) ? 1 : 0;
    $participant = ($prive == 1) ? 0 : 1;

    // Requête d'insertion dans la table PARTICIPATION
    $sql = "INSERT INTO PARTICIPATION (numero_tournois, demandeur, participant, email) VALUES ('$id_tournoi', '$demandeur', '$participant', '$email_connecte')";
    
    // Exécution de la requête
    if ($conn->query($sql) === TRUE) {
        // Redirection vers liste_rejoint.php
        header("Location: R1.php");
        exit; // Assure que le script s'arrête ici pour éviter toute exécution supplémentaire
    } else {
        echo "Erreur lors de l'inscription au tournoi : " . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
?>

