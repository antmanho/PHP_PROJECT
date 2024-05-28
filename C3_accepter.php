<?php
// Vérifier si le formulaire a été soumis et si la variable $_POST['accepter'] existe
//if(isset($_POST['accepter'])) {
    // Paramètres de connexion à la base de données MySQL
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

    // Récupérer les valeurs du formulaire
    $id_tournoi = $_POST['id_tournoi'];
    $id_participation = $_POST['id_participation']; // Correction : Utiliser 'id_participation' au lieu de 'id_tournoi'
    $email_demandeur = $_POST['email']; // Assurez-vous de valider et échapper cette valeur pour éviter les injections SQL

    // Requête pour insérer une nouvelle entrée dans la table DEMANDE
    $sql_insert_demande = "INSERT INTO DEMANDE (numero_tournois, demandeur, accepter) VALUES ('$id_tournoi', '$email_demandeur', 1)";

    // Exécuter la requête d'insertion
    if ($connexion->query($sql_insert_demande) === TRUE) {
        echo "La demande a été acceptée avec succès.";

        // Requête pour mettre à jour la ligne dans la table PARTICIPATION
        $sql_update_participation = "UPDATE PARTICIPATION SET demandeur = 0, participant = 1 WHERE id_participation = '$id_participation'";

        // Exécuter la requête de mise à jour
        if ($connexion->query($sql_update_participation) === TRUE) {
            echo "L'état de participation a été mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour de l'état de participation : " . $connexion->error;
        }

        header("Location: C3.php");
        exit;
    } else {
        echo "Erreur lors de l'acceptation de la demande : " . $connexion->error;
    }

    // Fermeture de la connexion à la base de données MySQL
    $connexion->close();
//}
?>

