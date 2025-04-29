<?php
class Emprunt {
    private $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $this->pdo = dbConnect();
    }

    public function create($livre_id, $utilisateur_id, $date_emprunt, $date_retour) {
        $sql = "INSERT INTO emprunt (livre_id, utilisateur_id, date_emprunt, date_retour) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([$livre_id, $utilisateur_id, $date_emprunt, $date_retour]);
        $rowsAffected = $stmt->rowCount();
        error_log("Emprunt::create(livre_id=$livre_id, utilisateur_id=$utilisateur_id, date_emprunt=$date_emprunt, date_retour=$date_retour) : " . ($success ? "succès, $rowsAffected ligne(s) insérée(s)" : "échec"));
        if (!$success) {
            error_log("Erreur SQL : " . print_r($stmt->errorInfo(), true));
        }
        return $success && $rowsAffected > 0;
    }
}
?>