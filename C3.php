<?php
session_start();
//$_SESSION['email_connecte'] = "invite@example.com";
$email_connecte = $_SESSION['email_connecte'];
//echo "wewe<br><br><br>" ;
//echo $email_connecte;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des tournois</title>
    
    <!-- Lier le fichier CSS -->
    <style>
body {
    background-color: #f4f4f4; /* Couleur de fond gris clair */
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


td.buttons-column button {
    width: 100%;/* Ajustez la hauteur pour remplir entièrement la cellule */
}

h1 {
    font-family: 'Bangers', cursive;
    text-align: center;
    font-size: 5vw; /* Par exemple, 3 fois la taille par défaut */
    margin: 0 auto; /* Pour centrer horizontalement */
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

// Initialisation de la variable de recherche
$search_query = "";

// Vérifier si une recherche a été effectuée
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
}

$sql = "SELECT p.id_participation, p.numero_tournois, p.demandeur, p.participant, p.email, t.nom_tournois,
               COUNT(DISTINCT CASE WHEN p.participant = 1 THEN p.email END) AS nombre_participants
            FROM PARTICIPATION AS p
            JOIN TOURNOIS AS t
            ON t.id_tournois = p.numero_tournois
            WHERE p.numero_tournois IN (
                SELECT id_tournois FROM TOURNOIS WHERE createur = '$email_connecte')
            AND NOT EXISTS (
                SELECT 1
                FROM DEMANDE d
                WHERE d.numero_tournois = p.numero_tournois
                AND d.demandeur = p.demandeur
            )
            AND p.demandeur=1";
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

$sql .= " GROUP BY p.id_participation, p.numero_tournois, p.demandeur, p.participant, p.email, t.nom_tournois "; // Ajout de GROUP BY

// Ajouter la condition pour filtrer les tournois où le nombre de participants est inférieur au nombre maximum de places

$result = $conn->query($sql);

echo '<br>';
// Conteneur flexbox pour aligner les éléments côte à côte
echo '<div style="display: flex; align-items: center;">';

// Affichage de la barre de recherche
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
echo '<button type="button" onclick="resetFilters()">Réinitialiser</button>';
echo '</form>';
echo '</div>';
echo '</div>';


if ($result->num_rows > 0) {
    // Affichage des données sous forme de table avec 7 colonnes par ligne
    echo "<table border='1' style='width: 100%;background-color: white; '>";
    echo "<tr><th>NOM</th><th>PRETENDANT</th><th>MESSAGERIE ANONYME</th><th>CHOIX</th></tr>";
    while($row = $result->fetch_assoc()) {
        
        echo "<td><br>" . $row["nom_tournois"] . "<br></td>";
        
        echo "<td><br>" . $row["email"] . "</td>" ;
        
        echo "<td>";
    
        // Création dynamique du bouton DISCUTER qui appelle la fonction submitMessForm(row)
        echo '<button type="button" onclick="submitMessForm(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ')" style="height: 10vh; width: 100%;"> DISCUTER </button>';

        echo "</td>";
        
        echo "<td>";
        
        echo '<button type="button" onclick="submitAccepterForm(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ')" style="height: 5vh; width: 100%;">ACCEPTER</button>';

        echo '<button type="button" onclick="submitRefuserForm(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ')" style="height: 5vh; width: 100%;"> REFUSER </button>';


        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<br><br> <br><h1> Aucuns tournois trouvé </h1><br><br>";
}
$conn->close();
?>

<script>
    function showInfo(info) {
         alert(info);
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
function submitAccepterForm(row) {
    // Création dynamique du formulaire avec les données de la ligne $row
    var form = document.createElement('form');
    form.setAttribute('id', 'accepterForm');
    form.setAttribute('method', 'POST');
    form.setAttribute('class', 'optional-fields');
    form.setAttribute('action', 'C3_accepter.php');

    // Création d'éléments input pour les données de la ligne $row
    var inputIdTournoi = document.createElement('input');
    inputIdTournoi.setAttribute('type', 'hidden');
    inputIdTournoi.setAttribute('name', 'id_tournoi');
    inputIdTournoi.setAttribute('value', row['numero_tournois']);
    form.appendChild(inputIdTournoi);
    
    var inputIdparticipation = document.createElement('input');
    inputIdparticipation.setAttribute('type', 'hidden');
    inputIdparticipation.setAttribute('name', 'id_participation'); // Assurez-vous que le nom correspond à celui attendu par votre script PHP
    inputIdparticipation.setAttribute('value', row['id_participation']);
    form.appendChild(inputIdparticipation);
    
    var inputEmail = document.createElement('input');
    inputEmail.setAttribute('type', 'hidden');
    inputEmail.setAttribute('name', 'email');
    inputEmail.setAttribute('value', row['email']);
    form.appendChild(inputEmail);

    // Ajout du formulaire à la page et soumission
    document.body.appendChild(form);
    form.submit();
}

function submitRefuserForm(row) {
    // Création dynamique du formulaire avec les données de la ligne $row
    var form = document.createElement('form');
    form.setAttribute('id', 'refuserForm');
    form.setAttribute('method', 'POST');
    form.setAttribute('class', 'optional-fields');
    form.setAttribute('action', 'C3_refuser.php');

    // Création d'éléments input pour les données de la ligne $row
    var inputIdTournoi = document.createElement('input');
    inputIdTournoi.setAttribute('type', 'hidden');
    inputIdTournoi.setAttribute('name', 'id_tournoi');
    inputIdTournoi.setAttribute('value', row['numero_tournois']);
    form.appendChild(inputIdTournoi);
    
    var inputIdparticipation = document.createElement('input');
    inputIdparticipation.setAttribute('type', 'hidden');
    inputIdparticipation.setAttribute('name', 'id_participation'); // Assurez-vous que le nom correspond à celui attendu par votre script PHP
    inputIdparticipation.setAttribute('value', row['id_participation']);
    form.appendChild(inputIdparticipation);
    
    var inputEmail = document.createElement('input');
    inputEmail.setAttribute('type', 'hidden');
    inputEmail.setAttribute('name', 'email');
    inputEmail.setAttribute('value', row['email']);
    form.appendChild(inputEmail);

    // Ajout du formulaire à la page et soumission
    document.body.appendChild(form);
    form.submit();
}


function submitMessForm(row) {
    // Création dynamique du formulaire
    var form = document.createElement('form');
    form.setAttribute('name', 'mess');
    form.setAttribute('action', 'messagerie.php');
    form.setAttribute('method', 'post');

    // Création des champs de formulaire
    var inputEmailConnecte = document.createElement('input');
    inputEmailConnecte.setAttribute('type', 'hidden');
    inputEmailConnecte.setAttribute('id', 'createur');
    inputEmailConnecte.setAttribute('name', 'createur');
    inputEmailConnecte.setAttribute('value', '<?php echo $email_connecte; ?>');
    form.appendChild(inputEmailConnecte);

    var inputPretendant = document.createElement('input');
    inputPretendant.setAttribute('type', 'hidden');
    inputPretendant.setAttribute('id', 'participant');
    inputPretendant.setAttribute('name', 'participant');
    inputPretendant.setAttribute('value', row['email']);
    form.appendChild(inputPretendant);


    // Ajout du formulaire à la page et soumission
    document.body.appendChild(form);
    form.submit();
}

</script>
</body>
</html>
