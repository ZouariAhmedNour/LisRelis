<?php
class Utilisateur {
    private $pdo;

    public function __construct(){
        require_once __DIR__ . '/../config/database.php';
        $this->pdo = dbConnect();
    }

    public function register($nom, $email, $telephone, $password, $role) {
        $stmt = $this->pdo->prepare("INSERT INTO utilisateur (nom, email, telephone, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $telephone, password_hash($password, PASSWORD_DEFAULT), $role]);
        return $stmt->rowCount() > 0;
    }

    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Retourne les données de l'utilisateur
        }
        return false; // Retourne false si l'email ou le mot de passe est incorrect
    }

    // Récupérer les utilisateurs avec des emprunts dont la date de retour est proche (dans les 3 prochains jours)
    public function getUsersWithUpcomingReturns() {
        $sql = "
            SELECT u.id AS utilisateur_id, u.nom, l.titre, e.date_emprunt, e.date_retour,
                   DATEDIFF(e.date_retour, CURDATE()) AS jours_restants
            FROM utilisateur u
            JOIN emprunt e ON u.id = e.utilisateur_id
            JOIN livre l ON e.livre_id = l.id
            WHERE e.date_retour >= CURDATE()
            AND DATEDIFF(e.date_retour, CURDATE()) <= 3
            ORDER BY e.date_retour ASC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Rechercher des utilisateurs par nom, email ou téléphone
    public function searchUsers($query) {
        $sql = "
            SELECT id, nom, email, telephone
            FROM utilisateur
            WHERE nom LIKE ? OR email LIKE ? OR telephone LIKE ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les détails d'un utilisateur par ID
    public function getUserById($id) {
        $sql = "SELECT id, nom, email, telephone, role FROM utilisateur WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer l'historique des emprunts d'un utilisateur
    public function getUserBorrowHistory($utilisateur_id) {
        $sql = "
            SELECT e.id AS emprunt_id, l.id AS livre_id, l.titre, e.date_emprunt, e.date_retour, l.disponible
            FROM emprunt e
            LEFT JOIN livre l ON e.livre_id = l.id
            WHERE e.utilisateur_id = ?
            ORDER BY e.date_emprunt DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$utilisateur_id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Débogage : Loguer les résultats pour vérifier les données
        error_log("Résultats de getUserBorrowHistory pour utilisateur $utilisateur_id : " . print_r($results, true));
        
        return $results;
    }

    // Marquer un livre comme retourné
    public function returnBook($livre_id, $emprunt_id) {
        // Mettre à jour la colonne disponible dans la table livre
        $sql = "UPDATE livre SET disponible = 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$livre_id]);

   

        return true;
    }
}