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
            error_log("Utilisateur trouvé pour email=$email : " . print_r($user, true));
            return $user;
        }
        error_log("Échec de la connexion pour email=$email : utilisateur non trouvé ou mot de passe incorrect");
        return false;
    }

    public function getUsersWithUpcomingReturns() {
        $sql = "
            SELECT u.id AS utilisateur_id, u.nom, u.email, l.titre, e.date_emprunt, e.date_retour,
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
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Résultats de getUsersWithUpcomingReturns : " . print_r($results, true));
        return $results;
    }

    public function searchUsers($query) {
        $sql = "
            SELECT id, nom, email, role
            FROM utilisateur
            WHERE nom LIKE ? OR email LIKE ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $sql = "SELECT id, nom, email, telephone, role FROM utilisateur WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Résultats de getUserById($id) : " . ($user ? print_r($user, true) : "non trouvé"));
        return $user;
    }

    public function updateUser($id, $nom, $email, $telephone, $role, $password = null) {
        if ($password) {
            $sql = "UPDATE utilisateur SET nom = ?, email = ?, telephone = ?, role = ?, password = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nom, $email, $telephone, $role, password_hash($password, PASSWORD_DEFAULT), $id]);
        } else {
            $sql = "UPDATE utilisateur SET nom = ?, email = ?, telephone = ?, role = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nom, $email, $telephone, $role, $id]);
        }
        return $stmt->rowCount() > 0;
    }

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
        error_log("Résultats de getUserBorrowHistory pour utilisateur $utilisateur_id : " . print_r($results, true));
        return $results;
    }

    public function getUserIdByEmpruntId($emprunt_id) {
        $sql = "SELECT utilisateur_id FROM emprunt WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$emprunt_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['utilisateur_id'] ?? null;
    }

    public function returnBook($livre_id, $emprunt_id) {
        $sql = "UPDATE livre SET disponible = 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$livre_id]);
        return true;
    }
}
?>