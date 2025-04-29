<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

class EmailSender {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);

        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'ahmedzouari725@gmail.com';
            $this->mailer->Password = 'zbdmsitclwjkyvpb';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;

            $this->mailer->setFrom('ahmedzouari725@gmail.com', 'Lisrelis Admin'); // Corriger setFrom
            $this->mailer->CharSet = 'UTF-8';
            error_log("PHPMailer configuré avec succès pour Username=ahmedzouari725@gmail.com");
        } catch (Exception $e) {
            error_log("Erreur de configuration PHPMailer : " . $e->getMessage());
        }
    }

    public function sendAlert($toEmail, $toName, $bookTitle, $returnDate) {
        try {
            $this->mailer->addAddress($toEmail, $toName);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Rappel : Retour de livre imminent';
            $this->mailer->Body = "
                <h2>Rappel de retour de livre</h2>
                <p>Bonjour $toName,</p>
                <p>Vous avez emprunté le livre <strong>$bookTitle</strong>. Veuillez le retourner avant le <strong>$returnDate</strong>.</p>
                <p>Merci de votre attention !</p>
                <p>L'équipe Lisrelis</p>
            ";
            $this->mailer->AltBody = "Rappel de retour de livre\nBonjour $toName,\nVous avez emprunté le livre $bookTitle. Veuillez le retourner avant le $returnDate.\nMerci de votre attention !\nL'équipe Lisrelis";

            error_log("Envoi d'un e-mail à $toEmail - Sujet : {$this->mailer->Subject}");

            $this->mailer->send();
            error_log("E-mail envoyé avec succès à $toEmail");
            return true;
        } catch (Exception $e) {
            error_log("Erreur lors de l'envoi de l'e-mail à $toEmail : " . $e->getMessage());
            return false;
        }
    }
}
?>