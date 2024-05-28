<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-size: 2.7vw; /* Taille de police par défaut */
}

.card {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    border: 2px solid black;
    border-radius: 10px;
    position: relative;
    background-color: #f1f1f1; /* Couleur de fond gris clair */
}

        .profile-img {
            width: 15%;
            height: 15vh;
            border-radius: 50%;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .user-info {
            text-align: left;
            margin-top: 20px;
            width: 60%;
            margin: 0 auto;
        }

        .user-level {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .user-level span {
            display: inline-block;
            padding: 1vw 3vw;
            background-color: black;
            color: white;
            border-radius: 50%; /* Ajustez cette valeur selon vos préférences */
        }

h1 {
    font-family: 'Bangers', cursive;
    text-align: center;
    margin: 0 auto;
    font-size: 4vw;
    border: 2px solid black;
    background-color: white; /* Ajout de la couleur de fond blanche */
    padding: 10px; /* Ajustez le rembourrage selon vos préférences */
}

        .info-item {
            margin-bottom: 2.3vh;
        }
    </style>
</head>
<body>

<?php
//$email_connecte = "zddz@gmaim.com";
session_start();
$email_connecte = $_SESSION['email_connecte'];
//echo "Email connectés : " . $email_connecte;
?>
<br>
<div class="card">
    <div class="user-level">
        <!-- Niveau de l'utilisateur -->
        <span>Niv:<br> 5</span>
    </div>
    <img class="profile-img" src="profil.png" alt="Photo de profil">
    <div class="user-info">
        <!-- Informations de l'utilisateur -->
        <h1>Carte identité</h1><br><br>
<div class="info-item">
    <strong>Email: </strong><?php echo $email_connecte;?> (reel)
</div>
        <div class="info-item">
            <strong>Nom:</strong> John Doe (fictif)
        </div>
        <div class="info-item">
            <strong>Prénom:</strong> Jane (f)
        </div>
        <div class="info-item">
            <strong>Adresse:</strong> 123 Rue des Fleurs, Ville (f)
        </div>
        <div class="info-item">
            <strong>Numéro:</strong> 1234567890 (f)
        </div>
        <div class="info-item">
            <strong>Tournois participés/créés:</strong> 10/5 (f)
        </div>
        <div class="info-item">
            <strong>Badges:</strong> Champion, Participant Actif (f)
        </div>
        <div class="info-item">
            <strong>Activité favorite:</strong> Jeux de société (f)
        </div>
    </div>

</div>

</body>
</html>
