<?php
session_start();
$email_connecte = $_SESSION['email_connecte'];
//$email_connecte = "dced";
//echo "wewe<br><br><br>" ;
//echo $email_connecte;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des tournois</title>
    
    <style>
body {
    background-color: #f4f4f4; /* Couleur de fond gris clair */
}
/* Style pour les boutons d'information et d'étoile */
.info-button,
.star-button {
    margin-left: 0px; /* Réduire la marge entre les boutons */
    margin-right: 0px; /* Réduire la marge entre les boutons */

}

.container {
  text-align: center;
  margin-top: 50px;
}

button {
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
}

/* Style pour les tournois avec cash prize */
.cash-prize {
    background-color: #FFDE0A;
}
/* Style de la boîte modale */
.modal {
    display: none; /* Par défaut, la boîte modale est cachée */
    position: fixed; /* Position fixe pour la boîte modale */
    z-index: 1; /* Mettre la boîte modale au-dessus de tout le reste */
    left: 0;
    top: 0;
    width: 100%; /* Largeur pleine de la boîte modale */
    height: 100%; /* Hauteur pleine de la boîte modale */
    overflow: auto; /* Activer le défilement si nécessaire */
    background-color: rgba(0,0,0,0.4); /* Fond sombre semi-transparent */
}

/* Contenu de la boîte modale */
.modal-content {
    background-color: #fefefe; /* Fond blanc de la boîte modale */
    margin: 15% auto; /* Centrer la boîte modale verticalement */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Largeur de la boîte modale */
}

/* Bouton de fermeture de la boîte modale */
.close {
    color: #aaaaaa; /* Couleur du texte */
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000; /* Couleur du texte lorsqu'il est survolé */
    text-decoration: none;
    cursor: pointer;
}

/* Style du formulaire de filtrage */
.optional-fields {
    margin-bottom: 10px;
}

/* Style des champs de formulaire */
.optional-fields input[type='checkbox'],
.optional-fields input[type='number'],
.optional-fields input[type='text'] {
    margin-bottom: 5px;
    width: 100%; /* Largeur pleine des champs */
}

/* Style du bouton de validation */
.optional-fields input[type='submit'] {
    background-color: #4CAF50; /* Couleur de fond verte */
    color: white; /* Couleur du texte */
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 10px;
    cursor: pointer;
}

.optional-fields input[type='submit']:hover {
    background-color: #45a049; /* Couleur de fond verte plus foncée lorsqu'il est survolé */
}

/* Style de la pop-up de filtre */
.filter-popup {
    display: none; /* Par défaut, la pop-up de filtre est cachée */
    position: fixed; /* Position fixe pour la pop-up de filtre */
    z-index: 1; /* Mettre la pop-up de filtre au-dessus de tout le reste */
    left: 0;
    top: 0;
    width: 100%; /* Largeur pleine de la pop-up de filtre */
    height: 100%; /* Hauteur pleine de la pop-up de filtre */
    overflow: auto; /* Activer le défilement si nécessaire */
    background-color: rgba(0,0,0,0.4); /* Fond sombre semi-transparent */
}

/* Contenu de la pop-up de filtre */
.filter-content {
    background-color: #fefefe; /* Fond blanc de la pop-up de filtre */
    margin: 15% auto; /* Centrer la pop-up de filtre verticalement */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Largeur de la pop-up de filtre */
}

/* Bouton de fermeture de la pop-up de filtre */
.filter-close {
    color: #aaaaaa; /* Couleur du texte */
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.filter-close:hover,
.filter-close:focus {
    color: #000; /* Couleur du texte lorsqu'il est survolé */
    text-decoration: none;
    cursor: pointer;
}
td {
    font-size: 2vw; /* Taille de la police proportionnelle à la largeur de la fenêtre */
    border: 2px solid black; /* Bordure noire de 2 pixels */
    text-align: center; /* Centrage du texte */
}
th {
    font-size: 3vw; /* Taille de la police pour les en-têtes */
    font-weight: bold; /* Texte en gras */
    border: 2px solid black; /* Bordure noire de 2 pixels */
    text-align: center; /* Centrage du texte */
}


/* Style pour la colonne des boutons */
td.buttons-column button {
    width: 100%;
}

#back-to-top {
    position: fixed;
    top: 1px;
    left: 1px;
    width: 50px;
    height: 50px;
    cursor: pointer;
    transition: transform 0.3s ease;
}
#back-to-top:hover {
    transform: scale(1.1);
}
h1 {
    
    font-family: 'Bangers', cursive;
    text-align: center;
    margin: 0 auto; /* Pour centrer horizontalement */
    font-size: 7vw;
}
    </style>
</head>
<body>
<br>
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

// Définir l'email de l'utilisateur connecté



    // Sinon, si $_SESSION['email_connecte'] a déjà une valeur, vous pouvez simplement la récupérer
//    $email_connecte = $_SESSION['email_connecte'];



// Initialisation de la variable de recherche
$search_query = "";

// Vérifier si une recherche a été effectuée
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Requête SQL de base pour récupérer les tournois non inscrits par l'utilisateur connecté
$sql = "SELECT t.*,
               COUNT(DISTINCT CASE WHEN p.participant = 1 THEN p.email END) AS nombre_participants
        FROM TOURNOIS AS t
        LEFT JOIN DEMANDE AS d ON t.id_tournois = d.numero_tournois
        LEFT JOIN PARTICIPATION AS p ON t.id_tournois = p.numero_tournois
        WHERE t.id_tournois NOT IN (
            SELECT numero_tournois
            FROM PARTICIPATION
            WHERE email='$email_connecte' AND (participant=1 OR demandeur=1)
        )";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql .= " AND id_tournois = $id";
}
// Ajouter une condition WHERE pour filtrer les tournois publics si la case est cochée
if(isset($_GET['public'])) {
    $sql .= " AND prive = 0";
}
// Ajouter une condition WHERE pour filtrer les tournois publics si la case est cochée
if(isset($_GET['public2'])) {
    $sql .= " AND demander_numero = 0";
}

// Ajouter une condition WHERE pour filtrer les tournois par nombre d'équipes si la valeur est saisie
if(isset($_GET['nbr_equipe']) && $_GET['nbr_equipe'] !== '') {
    $nbr_equipe = $_GET['nbr_equipe'];
    $sql .= " AND nbr_equipe = $nbr_equipe";
}

// Ajouter une condition WHERE pour filtrer les tournois par nom_activite si le texte est saisi
if(isset($_GET['activite']) && $_GET['activite'] !== '') {
    $activite = $_GET['activite'];
    $activite_lowercase = strtolower($activite); // Convertir la valeur de recherche en minuscules
    $sql .= " AND LOWER(nom_activite) LIKE '%$activite_lowercase%'";
}

// Ajouter une condition WHERE pour filtrer les tournois par cash prize minimum si la valeur est saisie
if(isset($_GET['cash_prize_min']) && $_GET['cash_prize_min'] !== '') {
    $cash_prize_min = $_GET['cash_prize_min'];
    $sql .= " AND cash_prize >= $cash_prize_min";
}

// Ajouter une condition WHERE pour filtrer les tournois par coût maximum si la valeur est saisie
if(isset($_GET['cout_tournois_max']) && $_GET['cout_tournois_max'] !== '') {
    $cout_tournois_max = $_GET['cout_tournois_max'];
    $sql .= " AND cout_tournois <= $cout_tournois_max";
}

// Ajouter la condition de recherche dans le nom, le lieu ou l'activité
if (!empty($search_query)) {
    $search_query_lowercase = strtolower($search_query); // Convertir la valeur de recherche en minuscules
    $sql .= " AND (LOWER(nom_tournois) LIKE '%$search_query_lowercase%' OR LOWER(lieu_tournois) LIKE '%$search_query_lowercase%' OR LOWER(nom_activite) LIKE '%$search_query_lowercase%')";
}

$sql .= " GROUP BY t.id_tournois"; // Ajout de GROUP BY

// Ajouter la condition pour filtrer les tournois où le nombre de participants est inférieur au nombre maximum de places
$sql .= " HAVING nombre_participants < place_maximum";

$result = $conn->query($sql);

echo '<br>';
// Conteneur flexbox pour aligner les éléments côte à côte

echo "<div style='display: flex; flex-direction: column; justify-content: center; align-items: center;'>";

if(isset($_POST['id'])) {

echo "<div id='header' style=' width: 100%;height: 1.5vh; background-color: white; z-index: 1000;'>";
echo "    <div style='text-align: center;'>";
echo "<br>";
echo "        <h1>DETAIL TOURNOIS :</h1>";
echo "    </div>";
echo "    <a href='R2.php' style='position: absolute; top: 20px; left: 20px;'>";
echo "        <img src='retour.png' alt='Retour' style='width: 50px; height: 50px;'>";
echo "    </a>";
echo "<br><br>";


    }

    else{
// Affichage de la barre de recherche
echo '<div style="display: flex; align-items: center;width: 100%">';
echo '<div style="flex-grow: 1;">'; // Utilisation de flex-grow pour que la barre de recherche prenne autant d'espace que possible
echo '<form method="get" action="" style="display: flex;">';
echo '<input type="text" name="search" placeholder="Rechercher..." value="' . (isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '') . '" style="flex-grow: 1; height: 5vh; border: 2px solid black; outline: none; font-size: 2vw;" />';
echo '<input type="submit" value="Rechercher" style="width: 7%; height: 5vh; border: none;" />';
echo '</form>';
echo '</div>';
// Affichage du bouton "Filtrer"
echo '<div>'; // Suppression de la propriété display: inline-block;
echo '<button onclick="openFilterPopup()">Filtrer</button>';
echo '</div>';
echo '</div>'; // Fermeture du conteneur flexbox
echo '<br>';
}

// Affichage de la pop-up de filtre
echo '<div id="filterPopup" class="modal filter-popup">';
echo '<div class="modal-content filter-content">';
echo '<span class="close filter-close" onclick="closeFilterPopup()">&times;</span>';
echo '<h3>Filtres</h3>';
echo '<form id="filterForm" class="optional-fields">';
echo '<label for="publicCheckbox">Tournois publics :</label>';
echo '<input type="checkbox" id="publicCheckbox" name="public">';
echo '<br>';
echo '<label for="publicCheckbox2">NON partage num</label>';
echo '<input type="checkbox" id="publicCheckbox2" name="public2">';
echo '<br>';
echo '<label for="nbrEquipe">Nombre d\'équipes :</label>';
echo '<input type="number" id="nbrEquipe" name="nbr_equipe">';
echo '<br>';
echo '<label for="activite">Activité :</label>';
echo '<input type="text" id="activite" name="activite">';
echo '<br>';
echo '<label for="cashPrizeMin">Cash Prize minimum :</label>';
echo '<input type="number" id="cashPrizeMin" name="cash_prize_min">';
echo '<br>';
echo '<label for="coutTournoisMax">Coût Tournois maximum :</label>';
echo '<input type="number" id="coutTournoisMax" name="cout_tournois_max">';
echo '<button type="button" onclick="applyFilters()">Appliquer</button>';
echo '<!-- Ajout du bouton "Réinitialiser" -->';
echo '<button type="button" onclick="resetFilters()" >Réinitialiser</button>';
echo '</form>';
echo '</div>';
echo '</div>';



if ($result->num_rows > 0) {
    // Affichage des données sous forme de table avec 7 colonnes par ligne
    echo "<table border='1' style='width: 100%;background-color: white;'>";
    echo "<tr><th>Nom</th><th>Date</th><th>Lieu</th><th>Contact</th><th>Info</th><th>Bouton</th></tr>";
    while($row = $result->fetch_assoc()) {
        $cash_prize_class = ($row["cash_prize"] > 0) ? 'cash-prize' : ''; // Ajout de la classe si le cash prize est supérieur à 0
        echo "<tr class='$cash_prize_class'>";
        
        echo "<td><br>" . $row["nom_tournois"] . "<br></td>";
        
        echo "<td><br> " . $row["date_tournois"] . " <br>" . $row["h_tournois"] . "H" . $row["m_tournois"] . "</td>";
        
        echo "<td  class='buttons-column'> " . ($row["prive"] == 1 ? "PRIVE" : "<div class='container'><p id='texteACopier'>" . $row['lieu_tournois'] . "</p><button onclick='copierLieu()'> Copier </button></div>") . "</td>" ;
        
        echo "<td  class='buttons-column'>" . ($row["prive"] == 1 ? "<p> <br>PRIVE </p>" :  "<div class='container'><p id='texteACopier2'>" .  $row['numero_telephone'] . "</p>" . " " . "<button onclick='copierNum()'> Copier </button></div></td>" );
        
        echo "<td><br>" . $row["nombre_participants"] . "/" . $row["place_maximum"] . "   participants<br>" . ($row["cash_prize"] > 0 ? "(" . $row["cash_prize"] . "€ à gagner) <br>" . "(" . $row["cash_prize"] . "€ prix entré)" : "<br>") ;
        
        echo ($row["demander_numero"] == 1 ? "<br><button class='info-button' onclick='showInfo(\"" . $row["plus_info"] . "\")' style='width: 76%;'>+information</button>" . "<button class='star-button' onclick='showPopup()' style='width: 10%;'>*</button>"  : "<br><button onclick='showInfo(\"" . $row["plus_info"] . "\")' style='width: 97%;'>+information</button>");

        
        echo "<td class='buttons-column' style='height: 100%;'>";
        // Affichage de la numero popup
        echo '<div id="NumeroPopup" method="post" class="modal filter-popup">';
        echo '<div class="modal-content filter-content">';
        echo '<span class="close filter-close" onclick="closeNumeroPopup()">&times;</span>';
        echo '<h3>Le créateur du tournois veut avoir acces à ton numéro de téléphone.</h3>';
        echo '<form id="NumeroForm" method="post" class="optional-fields" action="R1_ajout_numero.php">';
        echo '<label for="num">NUMERO :</label>';
        echo '<input type="text" id="num" name="num">';
        echo "<input id='id_tournoi' type='hidden' name='id_tournoi'>
                <input id='email_connecte' type='hidden' name='email_connecte' value='" . $email_connecte . "'>
                <input id='prive' type='hidden' name='prive'>
                <input id='createur' type='hidden' name='createur'>";

        echo '<button type="button" onclick="validateForm()">Appliquer</button>';
        echo '</form>';

        echo '</div>';
        echo '</div>';
        // Arreter
        if ($row["demander_numero"] == 1){
            if ($row["prive"] == 1) {
                echo '<button type="button" style="height: 100%;" onclick="openNumeroPopup(\'' . $row["id_tournois"] . '\', \'' .  $row["createur"] . '\', \'' . $row["prive"] . '\')">DEMANDER</button>';

            } else {
                echo '<button type="button" style="height: 100%;" onclick="openNumeroPopup(\'' . $row["id_tournois"] . '\', \'' .  $row["createur"] . '\', \'' . $row["prive"] . '\')">REJOINDRE</button>';
            }
        } 
        
        else {
            
    
            
            if ($row["prive"] == 1) {
                echo "<button type='button' style='height: 100%; width: 100%;' onclick='submitForm(\"inscription\", " . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")' name='demande'>DEMANDER</button>";
            } else {
                echo "<button type='button' style='height: 100%; width: 100%;' onclick='submitForm(\"inscription\", " . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")' name='rejoindre'>REJOINDRE</button>";
            }

    
        }
        
        echo "</td>";

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<br><br> <br><h1> Aucuns tournois trouvé </h1><<br><br>";
}
$conn->close();
echo "</div>";
?>

<script>
    function showInfo(info) {
         alert(info);
     }
    function showPopup() {
        alert("Ce logo signifie que vous êtes obligé de donner votre téléphone au créateur pour pouvoir participer.");
    }
    // Fonction pour réinitialiser les filtres
    function resetFilters() {
    // Réinitialiser les valeurs des champs de filtre à leurs valeurs par défaut
        document.getElementById("publicCheckbox").checked = false;
        document.getElementById("publicCheckbox2").checked = false;
        document.getElementById("nbrEquipe").value = "";
        document.getElementById("activite").value = "";
        document.getElementById("cashPrizeMin").value = "";
        document.getElementById("coutTournoisMax").value = "";
    }
    // Fonction pour fermer la pop-up de filtre
    function closeFilterPopup() {
        document.getElementById("filterPopup").style.display = "none";
    }
    // Fonction pour fermer la pop-up de filtre
    function closeNumeroPopup() {
      document.getElementById("NumeroPopup").style.display = "none";
    }
    // Fonction pour ouvrir la pop-up de filtre  MET PAS DS JS
    function openFilterPopup() {
        document.getElementById("filterPopup").style.display = "block";
        // Remplir les champs de filtre avec les valeurs précédemment saisies (s'il y en a)
        document.getElementById("publicCheckbox").checked = <?php echo isset($_GET['public']) ? 'true' : 'false'; ?>;
        document.getElementById("publicCheckbox2").checked = <?php echo isset($_GET['public2']) ? 'true' : 'false'; ?>;
        document.getElementById("nbrEquipe").value = "<?php echo isset($_GET['nbr_equipe']) ? $_GET['nbr_equipe'] : ''; ?>";
        document.getElementById("activite").value = "<?php echo isset($_GET['activite']) ? $_GET['activite'] : ''; ?>";
        document.getElementById("cashPrizeMin").value = "<?php echo isset($_GET['cash_prize_min']) ? $_GET['cash_prize_min'] : ''; ?>";
        document.getElementById("coutTournoisMax").value = "<?php echo isset($_GET['cout_tournois_max']) ? $_GET['cout_tournois_max'] : ''; ?>";
    }
 
    // Fonction pour ouvrir la pop-up de filtre  MET PAS DS JS
    function openNumeroPopup(x,y,z) {
        // Afficher la pop-up
        document.getElementById("NumeroPopup").style.display = "block";
        // Attribuer les valeurs aux champs du formulaire
        document.getElementById("NumeroForm").querySelector("input[id='id_tournoi']").value = x;
        document.getElementById("NumeroForm").querySelector("input[id='createur']").value = y;
        document.getElementById("NumeroForm").querySelector("input[id='prive']").value = z;
        document.getElementById("num").value = "<?php echo isset($_GET['num']) ? $_GET['num'] : ''; ?>";
    }

    // Fonction pour appliquer les filtres
    function applyFilters() {
        var publicCheckbox = document.getElementById("publicCheckbox");
        var isChecked = publicCheckbox.checked;
        
        var publicCheckbox2 = document.getElementById("publicCheckbox2");
        var isChecked2 = publicCheckbox2.checked;
    // Récupérer le nombre d'équipes saisi par l'utilisateur
        var nbrEquipe = document.getElementById("nbrEquipe").value.trim();
        nbrEquipe = nbrEquipe === "" ? "" : nbrEquipe;

    // Récupérer le texte saisi par l'utilisateur pour le filtre par activité
        var activite = document.getElementById("activite").value.trim();
        activite = activite === "" ? "" : activite;

    // Récupérer le montant minimum du cash prize saisi par l'utilisateur
        var cashPrizeMin = document.getElementById("cashPrizeMin").value.trim();
        cashPrizeMin = cashPrizeMin === "" ? "" : cashPrizeMin;

    // Récupérer le coût maximum du tournoi saisi par l'utilisateur
        var coutTournoisMax = document.getElementById("coutTournoisMax").value.trim();
        coutTournoisMax = coutTournoisMax === "" ? "" : coutTournoisMax;

    // Construire l'URL avec seulement les paramètres non vides
        var url = window.location.origin + window.location.pathname;
        var params = [];

        if (isChecked) {
            params.push('public=1');
        }
        if (isChecked2) {
            params.push('public2=1');
        }
        if (nbrEquipe !== '') {
            params.push('nbr_equipe=' + nbrEquipe);
        }
        if (activite !== '') {
            params.push('activite=' + activite);
        }
        if (cashPrizeMin !== '') {
            params.push('cash_prize_min=' + cashPrizeMin);
        }
        if (coutTournoisMax !== '') {
            params.push('cout_tournois_max=' + coutTournoisMax);
        }

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        window.location.href = url;
    }
    // Fonction pour valider le numéro de téléphone
    function numerovalide() {
        // Récupérer la valeur du champ de numéro de téléphone
        var numeroInput = document.getElementById('num');
        var numero = numeroInput.value;

        // Valider le numéro de téléphone
        if (numero.length < 10 || !numero.startsWith('0') && !numero.startsWith('+')) {
            // Afficher un message d'erreur si la validation échoue
            return false; // Le numéro n'est pas valide
        } else {
            // Le numéro est valide
            return true;
        }
    }

    // Fonction pour valider le formulaire
    function validateForm() {
        if (numerovalide()) {
            
            document.getElementById("NumeroForm").submit(); // Soumettre le formulaire si le numéro est valide

        } else {
            // Afficher un message d'erreur si le numéro n'est pas valide
            alert("Le numéro n'est pas valide. Veuillez corriger avant de soumettre le formulaire.");
        }
    }
// Fonction pour ouvrir la pop-up d'inscription
function openInscriptionPopup() {
    document.getElementById("inscriptionPopup").style.display = "block";
}

// Fonction pour fermer la pop-up d'inscription
function closeInscriptionPopup() {
    document.getElementById("inscriptionPopup").style.display = "none";
}
function copierLieu() {
  // Sélectionner le texte à copier
  var texte = document.getElementById("texteACopier");

  // Créer une zone de texte temporaire pour copier le texte
  var zoneTemporaire = document.createElement("textarea");
  zoneTemporaire.value = texte.innerText;

  // Ajouter la zone temporaire à la page
  document.body.appendChild(zoneTemporaire);

  // Sélectionner le texte dans la zone temporaire
  zoneTemporaire.select();
  zoneTemporaire.setSelectionRange(0, 99999); // Pour les navigateurs mobiles

  // Copier le texte sélectionné
  document.execCommand("copy");

  // Supprimer la zone temporaire
  document.body.removeChild(zoneTemporaire);

}
function copierNum() {
  // Sélectionner le texte à copier
  var texte = document.getElementById("texteACopier2");

  // Créer une zone de texte temporaire pour copier le texte
  var zoneTemporaire = document.createElement("textarea");
  zoneTemporaire.value = texte.innerText;

  // Ajouter la zone temporaire à la page
  document.body.appendChild(zoneTemporaire);

  // Sélectionner le texte dans la zone temporaire
  zoneTemporaire.select();
  zoneTemporaire.setSelectionRange(0, 99999); // Pour les navigateurs mobiles

  // Copier le texte sélectionné
  document.execCommand("copy");

  // Supprimer la zone temporaire
  document.body.removeChild(zoneTemporaire);

}
// Fonction pour soumettre le formulaire avec des paramètres supplémentaires
function submitForm(id_form, row) {
    // Création dynamique du formulaire avec les données de la ligne $row
    var form = document.createElement('form');
    form.setAttribute('id', 'inscription');
    form.setAttribute('method', 'POST');
    form.setAttribute('class', 'optional-fields');
    form.setAttribute('action', 'R1_inscription_tournoi.php');

    // Création d'éléments input pour les données de la ligne $row
    var inputIdTournoi = document.createElement('input');
    inputIdTournoi.setAttribute('type', 'hidden');
    inputIdTournoi.setAttribute('name', 'id_tournoi');
    inputIdTournoi.setAttribute('value', row['id_tournois']);
    form.appendChild(inputIdTournoi);

    var inputEmailConnecte = document.createElement('input');
    inputEmailConnecte.setAttribute('type', 'hidden');
    inputEmailConnecte.setAttribute('name', 'email_connecte');
    inputEmailConnecte.setAttribute('value', '<?php echo $email_connecte; ?>');
    inputEmailConnecte.style.display = 'none';
    form.appendChild(inputEmailConnecte);

    var inputPrive = document.createElement('input');
    inputPrive.setAttribute('type', 'hidden');
    inputPrive.setAttribute('name', 'prive');
    inputPrive.setAttribute('value', row['prive']);
    inputPrive.style.display = 'none';
    form.appendChild(inputPrive);

    var inputCreateur = document.createElement('input');
    inputCreateur.setAttribute('type', 'hidden');
    inputCreateur.setAttribute('name', 'createur');
    inputCreateur.setAttribute('value', row['createur']);
    inputCreateur.style.display = 'none';
    form.appendChild(inputCreateur);

    // Ajout du formulaire à la page et soumission
    document.body.appendChild(form);
    form.submit();
}

</script>
</body>
</html>


