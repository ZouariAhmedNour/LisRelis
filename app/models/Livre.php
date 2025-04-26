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

    public function findById($id) {
        $sql = "SELECT livre.id, livre.titre, livre.isbn, livre.image, livre.disponible, auteur.nom AS auteur, auteur.biographie, genre.nom AS genre, genre.description
                FROM livre
                JOIN auteur ON livre.auteur_id = auteur.id
                JOIN genre ON livre.genre_id = genre.id
                WHERE livre.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($titre, $auteur_id, $genre_id, $isbn, $imageData) {
        $sql = "INSERT INTO livre (titre, auteur_id, genre_id, isbn, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titre, $auteur_id, $genre_id, $isbn, $imageData]);
    }

    public function update($id, $titre, $auteur_id, $genre_id, $isbn, $imageData) {
        if ($imageData !== null) {
            // Mettre à jour avec la nouvelle image
            $sql = "UPDATE livre SET titre = ?, auteur_id = ?, genre_id = ?, isbn = ?, image = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$titre, $auteur_id, $genre_id, $isbn, $imageData, $id]);
        } else {
            // Mettre à jour sans modifier l'image
            $sql = "UPDATE livre SET titre = ?, auteur_id = ?, genre_id = ?, isbn = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$titre, $auteur_id, $genre_id, $isbn, $id]);
        }
    }

    public function updateDisponibilite($id, $disponible) {
        $sql = "UPDATE livre SET disponible = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$disponible, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM livre WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}