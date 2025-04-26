<?php

class Genre {
    private $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $this->pdo = dbConnect();
    }

    public function findAll() {
        $sql = "SELECT * FROM genre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nom, $description) {
        $sql = "INSERT INTO genre (nom, description) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $description]);
    }

    public function update($id, $nom, $description) {
        $sql = "UPDATE genre SET nom = ?, description = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $description, $id]);
    }

    public function getDefaultGenre() {
        // Vérifier si le genre "Non classé" existe
        $sql = "SELECT id FROM genre WHERE nom = 'Non classé'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id'];
        }

        // Si le genre n'existe pas, le créer
        $this->create('Non classé', 'Genre par défaut pour les livres non classés');
        return $this->pdo->lastInsertId();
    }

    public function reassignBooksToDefault($genreId) {
        $defaultGenreId = $this->getDefaultGenre();
        $sql = "UPDATE livre SET genre_id = ? WHERE genre_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$defaultGenreId, $genreId]);
    }

    public function delete($id) {
        // Réassigner les livres au genre par défaut
        $this->reassignBooksToDefault($id);

        // Supprimer le genre
        $sql = "DELETE FROM genre WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}