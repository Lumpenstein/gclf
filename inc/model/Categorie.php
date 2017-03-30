<?php

namespace inc\model;

use PDO;

class Categorie {

    private $id;
    private $nom;

    public function __construct($id, $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public static function get4Categories() {
        global $pdo;
        $sql = '
                SELECT categorie.cat_id, cat_nom, count(*) as nb
                FROM categorie
                INNER JOIN film ON film.cat_id = categorie.cat_id
                GROUP BY categorie.cat_id, cat_nom
                ORDER BY nb DESC
                LIMIT 0,4
                ';
        $pdoStatement = $pdo->query($sql);
        if ($pdoStatement && $pdoStatement->rowCount() > 0) {
            return $pdoStatement->fetchAll();
        }
    }

    public static function getCategorie($currentId) {
        global $pdo;
        $sql = '
		SELECT cat_id, cat_nom
		FROM categorie
		WHERE cat_id = :cat_id
		LIMIT 1
	';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':cat_id', $currentId, PDO::PARAM_INT);
        if ($pdoStatement->execute()) {
            $resList = $pdoStatement->fetch();
            return $resList['cat_nom'];
        }
    }

    public static function setCategorie($cat_id, $cat_nom) {
        global $pdo;
        // Si modification
        if ($cat_id > 0) {
            $sql = '
			UPDATE categorie
			SET cat_nom = :nom,
			cat_updated = NOW()
			WHERE cat_id = :cat_id
		';
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->bindValue(':nom', $cat_nom);
            $pdoStatement->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
        }
        // Sinon ajout
        else {
            $sql = '
			INSERT INTO categorie (cat_nom, cat_created, cat_updated)
			VALUES (:nom, NOW(),  NOW())
		';
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->bindValue(':nom', $cat_nom);
        }
        // J'exécute ma requete (quelle soit insert ou update)
        if ($pdoStatement->execute()) {
            // Redirection après modif
            if ($cat_id > 0) {
                header('Location: ?id=' . $cat_id);
                exit;
            }
            // Redirection après ajout
            else {
                // On va d'abord récupérer l'ID créé
                $cat_id = $pdo->lastInsertId();
                header('Location: ?id=' . $cat_id);
                exit;
            }
        }
    }

    public static function getAllCat() {
        global $pdo;

        // J'initialise ma variable de retour
        $myList = array();

        $sql = '
		SELECT cat_id, cat_nom
		FROM categorie
	';
        $pdoStatement = $pdo->query($sql);
        if ($pdoStatement && $pdoStatement->rowCount() > 0) {
            $myList = $pdoStatement->fetchAll();
        }

        return $myList;
    }

}
