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
        return $stmt->execute([$livre_id, $utilisateur_id, $date_emprunt, $date_retour]);
    }
}