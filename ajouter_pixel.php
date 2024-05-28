<?php
// Vérifier si les coordonnées et la couleur sont présentes dans la requête
if (isset($_POST['x'], $_POST['y'], $_POST['couleur'])) {
    $x = $_POST['x'];
    $y = $_POST['y'];
    $couleur = $_POST['couleur'];

    // Connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "admin";
    $mot_de_passe = "Canard.1010";
    $nom_base_de_donnees = "SITE_TOURNAMENT";

    $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees);
    if ($connexion->connect_error) {
        die("Échec de la connexion : " . $connexion->connect_error);
    }

    // Récupérer l'email de l'utilisateur à partir de la session ou autre source
    // Supposons qu'il est stocké dans une variable $email
    session_start();
    $email_connecte = $_SESSION['email_connecte'];
    $email = $email_connecte; // À remplacer par la vraie valeur

    // Récupérer l'email de l'utilisateur précédent qui a placé un pixel à cette position
    $sql_select_previous_email = "SELECT email FROM PIXEL_WARS WHERE x = ? AND y = ? ORDER BY id_pixel_war DESC LIMIT 1";
    $stmt_select_previous_email = $connexion->prepare($sql_select_previous_email);
    $stmt_select_previous_email->bind_param("ii", $x, $y);
    $stmt_select_previous_email->execute();
    $stmt_select_previous_email->bind_result($ancien_email);
    $stmt_select_previous_email->fetch();
    $stmt_select_previous_email->close();

    if ($ancien_email) {
        // Réduire le nombre de pixels placés de l'utilisateur précédent
        $sql_update_previous_user = "UPDATE UTILISATEUR SET pixel_war_placé = pixel_war_placé - 1 WHERE email = ?";
        $stmt_update_previous_user = $connexion->prepare($sql_update_previous_user);
        $stmt_update_previous_user->bind_param("s", $ancien_email);
        $stmt_update_previous_user->execute();
        $stmt_update_previous_user->close();
    }

    // Récupérer les valeurs actuelles de pixel_war_restant et pixel_war_placé
    $sql_select_user_values = "SELECT pixel_war_restant, pixel_war_placé FROM UTILISATEUR WHERE email = ?";
    $stmt_select_user_values = $connexion->prepare($sql_select_user_values);
    $stmt_select_user_values->bind_param("s", $email);
    $stmt_select_user_values->execute();
    $stmt_select_user_values->bind_result($pixel_war_restant, $pixel_war_place);
    $stmt_select_user_values->fetch();
    $stmt_select_user_values->close();

    // Mettre à jour les valeurs
    $pixel_war_restant--; // Décrémenter pixel_war_restant
    $pixel_war_place++;   // Incrémenter pixel_war_placé

    // Préparer la requête SQL pour mettre à jour les valeurs
    $sql_update_user_values = "UPDATE UTILISATEUR SET pixel_war_restant = ?, pixel_war_placé = ? WHERE email = ?";
    $stmt_update_user_values = $connexion->prepare($sql_update_user_values);
    $stmt_update_user_values->bind_param("iis", $pixel_war_restant, $pixel_war_place, $email);

    // Exécuter la requête préparée pour mettre à jour les valeurs
    if ($stmt_update_user_values->execute()) {
        // Insérer le pixel dans la table PIXEL_WARS
        $sql_insert_pixel = "INSERT INTO PIXEL_WARS (x, y, couleur, email) VALUES (?, ?, ?, ?)";
        $stmt_insert_pixel = $connexion->prepare($sql_insert_pixel);
        $stmt_insert_pixel->bind_param("iiss", $x, $y, $couleur, $email);
        
        // Exécuter la requête préparée pour insérer le pixel
        if ($stmt_insert_pixel->execute()) {
            echo "Pixel ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du pixel : " . $connexion->error;
        }
        $stmt_insert_pixel->close();
    } else {
        echo "Erreur lors de la mise à jour des valeurs : " . $connexion->error;
    }

    // Fermer la connexion à la base de données
    $connexion->close();
} else {
    echo "Coordonnées ou couleur manquante.";
}
?>

