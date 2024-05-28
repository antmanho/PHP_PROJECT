<?php
require_once 'Exception.php';
require_once 'PHPMailer.php';
require_once 'SMTP.php';

// Inclusion de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération de l'adresse e-mail depuis le formulaire
    $email = $_POST['email'];

    // Création d'une nouvelle instance de PHPMailer
    $mail = new PHPMailer(true); // Pass true pour activer les exceptions

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'barbedetanthony@gmail.com'; // Adresse e-mail de l'expéditeur
        $mail->Password = 'dmunpyeuzmkuebqc'; // Mot de passe de l'adresse e-mail de l'expéditeur
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinataire et expéditeur
        $mail->setFrom('barbedetanthony@gmail.com', 'Anthony');
        $mail->addAddress($email);

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'MESSAGE INSCRIPTION "TOURNAMENT"';
      $mail->Body    = 'Cher compétiteur compétitrice, <br><br>

Nous sommes ravis de vous accueillir sur "TOURNAMENT" ! 🎉<br><br>

Félicitations pour votre inscription ! Vous avez maintenant accès à une plateforme passionnante où vous pouvez participer à des tournois de jeu compétitifs et avoir la chance de gagner de l'argent réel grâce à nos tournois cash prize.<br><br>

Sur "TOURNAMENT", nous nous engageons à offrir une expérience de jeu stimulante et équitable à tous nos utilisateurs. Que vous soyez un joueur chevronné ou que vous débutiez tout juste votre aventure dans le monde des tournois en ligne, notre plateforme est conçue pour vous offrir des défis passionnants et des opportunités de gains incroyables.<br><br>

Voici quelques-unes des fonctionnalités que vous trouverez sur notre site :<br><br>

Une variété de tournois disponibles dans différents jeux.<br>
Des cash prizes attractifs pour les vainqueurs.<br>
Un environnement de jeu sécurisé et équitable.<br>
Une communauté dynamique de joueurs passionnés.<br><br>

N'hésitez pas à explorer notre site et à participer aux tournois qui vous intéressent. Nous sommes convaincus que vous trouverez des défis à votre mesure et que vous profiterez pleinement de votre expérience sur "TOURNAMENT".<br><br>

Si vous avez des questions, des préoccupations ou simplement besoin d'aide, n'hésitez pas à nous contacter. Notre équipe de support est là pour vous aider à tout moment.<br><br>

Encore une fois, bienvenue sur "TOURNAMENT" ! Nous sommes impatients de voir ce que vous accomplirez dans nos tournois et de vous aider à atteindre de nouveaux sommets.<br><br>

Amusez-vous bien et bonne chance !<br><br>

Cordialement,<br>
L'équipe de "TOURNAMENT"<br>

';

        // Envoi de l'e-mail
        $mail->send();
        echo 'E-mail envoyé avec succès !';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}
?>
