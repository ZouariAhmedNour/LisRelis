<?php
class Livre {
    private $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $this->pdo = dbConnect();
    }

    public function findAll($searchQuery = '') {
        if ($searchQuery) {
            // Recherche par titre, auteur ou genre
            $sql = "SELECT livre.id, livre.titre, livre.isbn, livre.image, livre.disponible, auteur.nom AS auteur, genre.nom AS genre
                    FROM livre
                    JOIN auteur ON livre.auteur_id = auteur.id
                    JOIN genre ON livre.genre_id = genre.id
                    WHERE livre.titre LIKE ?
                       OR auteur.nom LIKE ?
                       OR genre.nom LIKE ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(["%$searchQuery%", "%$searchQuery%", "%$searchQuery%"]);
        } else {
            // Récupérer tous les livres
            $sql = "SELECT livre.id, livre.titre, livre.isbn, livre.image, livre.disponible, auteur.nom AS auteur, genre.nom AS genre
                    FROM livre
                    JOIN auteur ON livre.auteur_id = auteur.id
                    JOIN genre ON livre.genre_id = genre.id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findMostBorrowed($limit = 5) {
        $sql = "
            SELECT livre.id, livre.titre, livre.isbn, livre.image, livre.disponible, 
                   auteur.nom AS auteur, genre.nom AS genre, 
                   COUNT(emprunt.id) AS nombre_emprunts
            FROM livre
            JOIN auteur ON livre.auteur_id = auteur.id
            JOIN genre ON livre.genre_id = genre.id
            LEFT JOIN emprunt ON livre.id = emprunt.livre_id
            GROUP BY livre.id, livre.titre, livre.isbn, livre.image, livre.disponible, auteur.nom, genre.nom
            ORDER BY nombre_emprunts DESC
            LIMIT ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Livre::findMostBorrowed(limit=$limit) : " . (count($results) > 0 ? "trouvé " . count($results) . " livres" : "aucun livre trouvé") . ", Résultat : " . print_r($results, true));
        return $results;
    }

    public function findById($id) {
        $sql = "SELECT livre.id, livre.titre, livre.isbn, livre.image, livre.disponible, auteur.nom AS auteur, auteur.biographie, genre.nom AS genre, genre.description
                FROM livre
                JOIN auteur ON livre.auteur_id = auteur.id
                JOIN genre ON livre.genre_id = genre.id
                WHERE livre.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Livre::findById($id) : " . ($result ? "trouvé" : "non trouvé") . ", Résultat : " . print_r($result, true));
        return $result;
    }

    public function create($titre, $auteur_id, $genre_id, $isbn, $imageData) {
        $sql = "INSERT INTO livre (titre, auteur_id, genre_id, isbn, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([$titre, $auteur_id, $genre_id, $isbn, $imageData]);
        error_log("Livre::create(titre=$titre, auteur_id=$auteur_id, genre_id=$genre_id, isbn=$isbn) : " . ($success ? "succès" : "échec"));
        return $success;
    }

    public function update($id, $titre, $auteur_id, $genre_id, $isbn, $imageData) {
        if ($imageData !== null) {
            // Mettre à jour avec la nouvelle image
            $sql = "UPDATE livre SET titre = ?, auteur_id = ?, genre_id = ?, isbn = ?, image = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute([$titre, $auteur_id, $genre_id, $isbn, $imageData, $id]);
        } else {
            // Mettre à jour sans modifier l'image
            $sql = "UPDATE livre SET titre = ?, auteur_id = ?, genre_id = ?, isbn = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute([$titre, $auteur_id, $genre_id, $isbn, $id]);
        }
        error_log("Livre::update(id=$id, titre=$titre, auteur_id=$auteur_id, genre_id=$genre_id, isbn=$isbn) : " . ($success ? "succès" : "échec"));
        return $success;
    }

    public function updateDisponibilite($id, $disponible) {
        $sql = "UPDATE livre SET disponible = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([$disponible, $id]);
        $rowsAffected = $stmt->rowCount();
        error_log("Livre::updateDisponibilite(id=$id, disponible=$disponible) : " . ($success ? "succès, $rowsAffected ligne(s) mise(s) à jour" : "échec"));
        if (!$success) {
            error_log("Erreur SQL : " . print_r($stmt->errorInfo(), true));
        }
        return $success && $rowsAffected > 0;
    }

    public function delete($id) {
        $sql = "DELETE FROM livre WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([$id]);
        error_log("Livre::delete(id=$id) : " . ($success ? "succès" : "échec"));
        return $success;
    }
}
?>