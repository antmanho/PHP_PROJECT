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
    $email_demandeur = $_POST['email']; // Assurez-vous de valider et échapper cette valeur pour éviter les injections SQL
    $id_participation = $_POST['id_participation'];
    // Requête pour insérer une nouvelle entrée dans la table DEMANDE
    $sql_insert_demande = "INSERT INTO DEMANDE (numero_tournois, demandeur, accepter) VALUES ('$id_tournoi', '$email_demandeur', 0)";

    // Exécuter la requête d'insertion
    if ($connexion->query($sql_insert_demande) === TRUE) {
        echo "La demande a été refusée avec succès.";

        // Requête pour supprimer la ligne de la table PARTICIPATION
        $sql_delete_participation = "DELETE FROM PARTICIPATION WHERE id_participation = '$id_participation'";

        // Exécuter la requête de suppression
        if ($connexion->query($sql_delete_participation) === TRUE) {
            echo "La participation a été supprimée avec succès.";
        } else {
            echo "Erreur lors de la suppression de la participation : " . $connexion->error;
        }

        header("Location: C3.php");
        exit;
    } else {
        echo "Erreur lors de la refus de la demande : " . $connexion->error;
    }

    // Fermeture de la connexion à la base de données MySQL
    $connexion->close();
//}
?>
