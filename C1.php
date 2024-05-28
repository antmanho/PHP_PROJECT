<?php
//$email_connecte = "participant1@example.com";
session_start();
$email_connecte = $_SESSION['email_connecte'];
//echo "Email connectés : " . $email_connecte;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un tournoi</title>
    <style>
        .optional-fields {
            display: none;
        }
        .toggle-button {
            cursor: pointer;
            user-select: none;
        }
h1 {
    font-family: 'Bangers', cursive;
    text-align: center;
    margin: 0 auto; /* Pour centrer horizontalement */
}
.centered-button {
           width: 30%;
           height: 10%;
           font-size: 3vw;
           display: block;
           margin: 0 auto;
           text-align: center;
       }

#m_tournois {
    width: 10%; /* Définissez la largeur selon vos besoins */
    height: 7vh; /* Ajustez la hauteur en fonction de la hauteur de la fenêtre */
}
#h_tournois {
    width: 10%; /* Définissez la largeur selon vos besoins */
    height: 7vh; /* Ajustez la hauteur en fonction de la hauteur de la fenêtre */
}
#date_tournois {
    width: 60%; /* Définissez la largeur selon vos besoins */
    height: 7vh; /* Ajustez la hauteur en fonction de la hauteur de la fenêtre */
}
body {
    position: relative; /* Assurez-vous que la position est relative pour les éléments enfants positionnés absolument */
    background-image: url('sport.jpg');
    background-size: cover; /* Assurez-vous que l'image de fond couvre toute la fenêtre */
}

body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.78); /* Couleur d'arrière-plan semi-transparente */
    z-index: -1; /* Assurez-vous que cette couche est placée derrière le contenu de la page */
}
.custom-select {
            appearance: none; /* Supprime le style par défaut */
            -webkit-appearance: none; /* Pour les navigateurs basés sur WebKit */
            -moz-appearance: none; /* Pour les navigateurs basés sur Gecko */
            width: 10%; /* Définissez la largeur selon vos besoins */
            height: 5vh; /* Ajustez la hauteur en fonction de la hauteur de la fenêtre */
            padding: 10px; /* Ajoutez un peu de rembourrage */
            border: 1px solid #000; /* Ajoutez une bordure */
            background-color: #fff; /* Fond blanc */
            color: #000; /* Texte noir */
            font-size: 16px; /* Taille de police */
            cursor: pointer; /* Curseur */
        }

        /* Styles spécifiques au survol */
        .custom-select:hover {
            background-color: #f0f0f0; /* Fond gris clair au survol */
        }

        /* Styles spécifiques au focus */
        .custom-select:focus {
            outline: none; /* Supprimez la bordure lorsqu'il est en focus */
        }

    </style>
    <script src="C1_validation.js"></script>
</head>
<body>
<br>
    <h1 style="font-size: 7vw;">Ajouter un tournois</h1>
    <form action="C1_ajouter_tournoi.php" method="post" class="centered-button" style="width: 65%; height: auto ; border: 3px solid black;padding: 0.5vw;">
            <input type="hidden" id="email_connecte" name="email_connecte" value="<?php echo $email_connecte; ?>" >
            
            <label for="nom_tournois" >Nom du tournoi : &nbsp;&nbsp;&nbsp;</label>
          <input type="text" id="nom_tournois" name="nom_tournois" style="width: 50%; height: 4vh; font-size: 2vw;" required><br><br>

            
            <label for="date_tournois">Date du tournoi: &nbsp;&nbsp;&nbsp;</label>
            <input type="date" id="date_tournois" name="date_tournois" style="width: 50%; height: 4vh; font-size: 2vw;" required><br><br>

            
            <label for="lieu_tournois">Lieu du tournoi: &nbsp;&nbsp;&nbsp;</label>
            <input type="text" id="lieu_tournois" name="lieu_tournois" style="width: 50%; height: 4vh; font-size: 2vw;"required><br><br>

            
<div style="display: flex; justify-content: center; align-items: center;">
            <label for="h_tournois">Heure du tournois:  &nbsp&nbsp&nbsp;&nbsp;</label>
            <select id="h_tournois" name="h_tournois" class="form-control custom-select" style="width: 10%; height: 4vh; padding: 0;" required>
                <option value="0">00</option>
                <option value="1">01</option>
                <option value="2">02</option>
                <option value="3">03</option>
                <option value="4">04</option>
                <option value="5">05</option>
                <option value="6">06</option>
                <option value="7">07</option>
                <option value="8">08</option>
                <option value="9">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
            </select>
            
                    <label for="h_tournois"> &nbsp; h &nbsp; </label>
            
<select id="m_tournois" name="m_tournois" class="form-control custom-select" style="width: 10%; height: 4vh; padding: 0;" required>
                        <option value="0">00</option>
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>
                        <option value="9">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                        <option value="32">32</option>
                        <option value="33">33</option>
                        <option value="34">34</option>
                        <option value="35">35</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38">38</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                        <option value="41">41</option>
                        <option value="42">42</option>
                        <option value="43">43</option>
                        <option value="44">44</option>
                        <option value="45">45</option>
                        <option value="46">46</option>
                        <option value="47">47</option>
                        <option value="48">48</option>
                        <option value="49">49</option>
                        <option value="50">50</option>
                        <option value="51">51</option>
                        <option value="52">52</option>
                        <option value="53">53</option>
                        <option value="54">54</option>
                        <option value="55">55</option>
                        <option value="56">56</option>
                        <option value="57">57</option>
                        <option value="58">58</option>
                        <option value="59">59</option>
                        
                    </select><label for="m_tournois"> &nbsp; min &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
                </div><br>

            
            <label for="numero_telephone">Numéro de tel: &nbsp;&nbsp;&nbsp;</label>
            <input type="text" id="numero_telephone" name="numero_telephone" style="width: 50%; height: 4vh; font-size: 2vw;" required><br>
        
        <h7 class="toggle-button" onclick="toggleOptionalFields()" style="display: inline-block; cursor: pointer;">&#9660;</h7>
        <span class="toggle-button" onclick="toggleOptionalFields()" style="display: inline-block; cursor: pointer;">Afficher les champs optionnels</span><br>
        
        <div class="optional-fields">
            <label for="prive"> Privé (optionnel):</label><br>
            <input type="checkbox" id="prive" name="prive" value='true'><br>
            
            <label for="equipe">Équipe (optionnel):</label><br>
            <input type="checkbox" id="equipe" name="equipe" value='true'><br>
            
            <label for="num">Numero particcipant obligatoire(optionnel):</label><br>
            <input type="checkbox" id="num" name="num" value='true'><br>
                
            <label for="nbr_equipe">Nombre d'équipes (optionnel):</label><br>
            <input type="number" id="nbr_equipe" name="nbr_equipe"><br>
            
            <label for="place_maximum">Nombre maximum de participants (optionnel):</label><br>
            <input type="number" id="place_maximum" name="place_maximum"><br>
            
            <label for="plus_info">Informations supplémentaires (optionnel):</label><br>
            <input type="text" id="plus_info" name="plus_info" ><br>
            
            <label for="nom_activite">Nom de l'activité (optionnel):</label><br>
            <input type="text" id="nom_activite" name="nom_activite"><br>
            
            <label for="cash_prize">Prix en argent (optionnel):</label><br>
            <input type="number" id="cash_prize" name="cash_prize"><br>
            
            <label for="cout_tournois">Coût du tournoi (optionnel):</label><br>
            <input type="number" id="cout_tournois" name="cout_tournois"><br>
        </div>
<br>
        
<input type="submit" value="Ajouter" style="width: 100%; height: 10vh; font-size: 3.5vw; display: block; margin: 0 auto; text-align: center;">



    </form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>

