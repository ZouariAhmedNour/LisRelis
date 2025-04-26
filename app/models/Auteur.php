<?php

class Auteur {
    private $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $this->pdo = dbConnect();
    }

    public function findAll($search = '') {
        $sql = "SELECT * FROM auteur";
        if (!empty($search)) {
            $sql .= " WHERE nom LIKE :search";
        }
        $stmt = $this->pdo->prepare($sql);
        if (!empty($search)) {
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nom, $biographie, $date_de_naissance) {
        $sql = "INSERT INTO auteur (nom, biographie, date_de_naissance) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $biographie, $date_de_naissance]);
    }

    public function update($id, $nom, $biographie, $date_de_naissance) {
        $sql = "UPDATE auteur SET nom = ?, biographie = ?, date_de_naissance = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $biographie, $date_de_naissance, $id]);
    }

    public function getDefaultAuthor() {
        // Vérifier si l'auteur "Auteur inconnu" existe
        $sql = "SELECT id FROM auteur WHERE nom = 'Auteur inconnu'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id'];
        }

        // Si l'auteur n'existe pas, le créer
        $this->create('Auteur inconnu', 'Auteur par défaut pour les livres sans auteur', '1900-01-01');
        return $this->pdo->lastInsertId();
    }

    public function reassignBooksToDefault($authorId) {
        $defaultAuthorId = $this->getDefaultAuthor();
        $sql = "UPDATE livre SET auteur_id = ? WHERE auteur_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$defaultAuthorId, $authorId]);
    }

    public function delete($id) {
        // Ne pas supprimer l'auteur par défaut
        $defaultAuthorId = $this->getDefaultAuthor();
        if ($id == $defaultAuthorId) {
            return false; // Ne pas supprimer l'auteur par défaut
        }

        // Réassigner les livres à l'auteur par défaut
        $this->reassignBooksToDefault($id);

        // Supprimer l'auteur
        $sql = "DELETE FROM auteur WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}