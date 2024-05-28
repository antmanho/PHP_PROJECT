<?php
echo '<!DOCTYPE html>';
echo '<html lang="fr">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Modifier un tournoi</title>';
echo '<style>';
echo '    .optional-fields {';
echo '        display: none;';
echo '    }';
echo '    .toggle-button {';
echo '        cursor: pointer;';
echo '        user-select: none;';
echo '    }';
echo '    h1 {';
echo '        font-family: \'Bangers\', cursive;';
echo '        text-align: center;';
echo '        margin: 0 auto; /* Pour centrer horizontalement */';
echo '    }';
echo '    .centered-button {';
echo '        width: 30%;';
echo '        height: 10%;';
echo '        font-size: 3vw;';
echo '        display: block;';
echo '        margin: 0 auto;';
echo '        text-align: center;';
echo '    }';
echo '    #m_tournois {';
echo '        width: 10%; /* Définissez la largeur selon vos besoins */';
echo '        height: 7vh; /* Ajustez la hauteur en fonction de la hauteur de la fenêtre */';
echo '    }';
echo '    #h_tournois {';
echo '        width: 10%; /* Définissez la largeur selon vos besoins */';
echo '        height: 7vh; /* Ajustez la hauteur en fonction de la hauteur de la fenêtre */';
echo '    }';
echo '    #date_tournois {';
echo '        width: 60%; /* Définissez la largeur selon vos besoins */';
echo '        height: 7vh; /* Ajustez la hauteur en fonction de la hauteur de la fenêtre */';
echo '    }';
echo '    body {';
echo '        position: relative; /* Assurez-vous que la position est relative pour les éléments enfants positionnés absolument */';
echo '        background-image: url(\'sport.jpg\');';
echo '        background-size: cover; /* Assurez-vous que l\'image de fond couvre toute la fenêtre */';
echo '    }';
echo '    body::before {';
echo '        content: "";';
echo '        position: absolute;';
echo '        top: 0;';
echo '        left: 0;';
echo '        width: 100%;';
echo '        height: 100%;';
echo '        background-color: rgba(255, 255, 255, 0.78); /* Couleur d\'arrière-plan semi-transparente */';
echo '        z-index: -1; /* Assurez-vous que cette couche est placée derrière le contenu de la page */';
echo '    }';
echo '    .custom-select {';
echo '        appearance: none; /* Supprime le style par défaut */';
echo '        -webkit-appearance: none; /* Pour les navigateurs basés sur WebKit */';
echo '        -moz-appearance: none; /* Pour les navigateurs basés sur Gecko */';
echo '        width: 10%; /* Définissez la largeur selon vos besoins */';
echo '        height: 5vh; /* Ajustez la hauteur en fonction de la hauteur de la fenêtre */';
echo '        padding: 10px; /* Ajoutez un peu de rembourrage */';
echo '        border: 1px solid #000; /* Ajoutez une bordure */';
echo '        background-color: #fff; /* Fond blanc */';
echo '        color: #000; /* Texte noir */';
echo '        font-size: 16px; /* Taille de police */';
echo '        cursor: pointer; /* Curseur */';
echo '    }';
echo '    /* Styles spécifiques au survol */';
echo '    .custom-select:hover {';
echo '        background-color: #f0f0f0; /* Fond gris clair au survol */';
echo '    }';
echo '    /* Styles spécifiques au focus */';
echo '    .custom-select:focus {';
echo '        outline: none; /* Supprimez la bordure lorsqu\'il est en focus */';
echo '    }';
echo '</style>';
echo '<script src="C1_validation.js"></script>';
echo '</head>';
echo '<body>';
echo '<h1 style="font-size: 7vw;">Modifier un tournoi</h1>';
echo '<form action="C4_ajouter_tournoi.php" method="post" class="centered-button" style="width: 65%; height: 60% ; border: 3px solid black;padding: 0.5vw;">';


// Valeur par défaut pour id_tournois
$email_connecte = isset($_POST['email_connecte']) ? $_POST['email_connecte'] : '';
// Valeur par défaut pour id_tournois
$id_tournois_default = isset($_POST['id_tournois']) ? $_POST['id_tournois'] : '';

// Valeur par défaut pour nom_tournois
$nom_tournois_default = isset($_POST['nom_tournois']) ? $_POST['nom_tournois'] : '';

// Valeur par défaut pour date_tournois
$date_tournois_default = isset($_POST['date_tournois']) ? $_POST['date_tournois'] : '';

// Valeur par défaut pour lieu_tournois
$lieu_tournois_default = isset($_POST['lieu_tournois']) ? $_POST['lieu_tournois'] : '';

// Valeur par défaut pour h_tournois
$h_tournois_default = isset($_POST['h_tournois']) ? $_POST['h_tournois'] : '';

// Valeur par défaut pour m_tournois
$m_tournois_default = isset($_POST['m_tournois']) ? $_POST['m_tournois'] : '';

// Valeur par défaut pour numero_telephone
$numero_telephone_default = isset($_POST['numero_telephone']) ? $_POST['numero_telephone'] : '';

// Valeur par défaut pour nbr_equipe
$nbr_equipe_default = isset($_POST['nbr_equipe']) ? $_POST['nbr_equipe'] : '';

// Valeur par défaut pour place_maximum
$place_maximum_default = isset($_POST['place_maximum']) ? $_POST['place_maximum'] : '';

// Valeur par défaut pour plus_info
$plus_info_default = isset($_POST['plus_info']) ? $_POST['plus_info'] : '';

// Valeur par défaut pour nom_activite
$nom_activite_default = isset($_POST['nom_activite']) ? $_POST['nom_activite'] : '';

// Valeur par défaut pour cash_prize
$cash_prize_default = isset($_POST['cash_prize']) ? $_POST['cash_prize'] : '';

// Valeur par défaut pour cout_tournois
$cout_tournois_default = isset($_POST['cout_tournois']) ? $_POST['cout_tournois'] : '';

// Valeur par défaut pour createur
$createur_default = isset($_POST['createur']) ? $_POST['createur'] : '';

// Valeur par défaut pour equipe
$equipe_default = isset($_POST['equipe']) ? ($_POST['equipe'] == 1 ? 'true' : '') : '';

// Valeur par défaut pour demander_numero
$demander_numero_default = isset($_POST['demander_numero']) ? ($_POST['demander_numero'] == 1 ? 'true' : '') : '';

// Valeur par défaut pour prive
$prive_default = isset($_POST['prive']) ? ($_POST['prive'] == 1 ? 'true' : '') : '';





echo '    <input type="hidden" id="email_connecte" name="email_connecte" value="' . $email_connecte . '" >';
echo '    <label for="nom_tournois" >Nom du tournoi : &nbsp;&nbsp;&nbsp;</label>';
echo '    <input type="text" id="nom_tournois" name="nom_tournois" style="width: 50%; height: 4vh; font-size: 2vw;" value="' . $nom_tournois_default . '" required><br><br>';
echo '    <label for="date_tournois">Date du tournoi: &nbsp;&nbsp;&nbsp;</label>';
echo '    <input type="date" id="date_tournois" name="date_tournois" style="width: 50%; height: 4vh; font-size: 2vw;" value="' . $date_tournois_default . '" required><br><br>';
echo '    <label for="lieu_tournois">Lieu du tournoi: &nbsp;&nbsp;&nbsp;</label>';
echo '    <input type="text" id="lieu_tournois" name="lieu_tournois" style="width: 50%; height: 4vh; font-size: 2vw;" value="' . $lieu_tournois_default . '" required><br><br>';
echo '    <div style="display: flex; justify-content: center; align-items: center;">';
echo '        <label for="h_tournois">Heure du tournois:  &nbsp&nbsp&nbsp;&nbsp;</label>';
echo '        <select id="h_tournois" name="h_tournois" class="form-control custom-select" style="width: 10%; height: 4vh; padding: 0;" required>';
for ($i = 0; $i < 24; $i++) {
    echo '<option value="' . sprintf("%02d", $i) . '"' . ($i == $h_tournois_default ? ' selected' : '') . '>' . sprintf("%02d", $i) . '</option>';
}
echo '        </select>';
echo '        <label for="h_tournois"> &nbsp; h &nbsp; </label>';
echo '        <select id="m_tournois" name="m_tournois" class="form-control custom-select" style="width: 10%; height: 4vh; padding: 0;" required>';
for ($i = 0; $i < 60; $i += 15) {
    echo '<option value="' . sprintf("%02d", $i) . '"' . ($i == $m_tournois_default ? ' selected' : '') . '>' . sprintf("%02d", $i) . '</option>';
}
echo '        </select><label for="m_tournois"> &nbsp; min &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>';
echo '    </div><br>';
echo '    <label for="numero_telephone">Numéro de tel: &nbsp;&nbsp;&nbsp;</label>';
echo '    <input type="text" id="numero_telephone" name="numero_telephone" style="width: 50%; height: 4vh; font-size: 2vw;" value="' . $numero_telephone_default . '" required><br>';
echo '    <h7 class="toggle-button" onclick="toggleOptionalFields()" style="display: inline-block; cursor: pointer;">&#9660;</h7>';
echo '    <span class="toggle-button" onclick="toggleOptionalFields()" style="display: inline-block; cursor: pointer;">Afficher les champs optionnels</span><br>';
echo '    <div class="optional-fields">';
echo '        <label for="prive"> Privé (optionnel):</label><br>';
echo '        <input type="checkbox" id="prive" name="prive" value="true"' . ($prive_default == 'true' ? ' checked' : '') . '><br>';
echo '        <label for="equipe">Équipe (optionnel):</label><br>';
echo '        <input type="checkbox" id="equipe" name="equipe" value="true"' . ($equipe_default == 'true' ? ' checked' : '') . '><br>';
echo '        <label for="num">Numero particcipant obligatoire(optionnel):</label><br>';
echo '        <input type="checkbox" id="num" name="num" value="true"' . ($demander_numero_default == 'true' ? ' checked' : '') . '><br>';
echo '        <label for="nbr_equipe">Nombre d\'équipes (optionnel):</label><br>';
echo '        <input type="number" id="nbr_equipe" name="nbr_equipe" value="' . $nbr_equipe_default . '"><br>';
echo '        <label for="place_maximum">Nombre maximum de participants (optionnel):</label><br>';
echo '        <input type="number" id="place_maximum" name="place_maximum" value="' . $place_maximum_default . '"><br>';
echo '        <label for="plus_info">Informations supplémentaires (optionnel):</label><br>';
echo '        <input type="text" id="plus_info" name="plus_info" value="' . $plus_info_default . '"><br>';
echo '        <label for="nom_activite">Nom de l\'activité (optionnel):</label><br>';
echo '        <input type="text" id="nom_activite" name="nom_activite" value="' . $nom_activite_default . '"><br>';
echo '        <label for="cash_prize">Prix en argent (optionnel):</label><br>';
echo '        <input type="number" id="cash_prize" name="cash_prize" value="' . $cash_prize_default . '"><br>';
echo '        <label for="cout_tournois">Coût du tournoi (optionnel):</label><br>';
echo '        <input type="number" id="cout_tournois" name="cout_tournois" value="' . $cout_tournois_default . '"><br>';
echo '    </div>';
echo '    <br>';
echo '    <input type="submit" value="Modifier" style="width: 100%; height: 10vh; font-size: 4.5vw; display: block; margin: 0 auto; text-align: center;">';
echo '</form>';
echo '</body>';
echo '</html>';
?>
