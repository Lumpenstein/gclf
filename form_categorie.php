<?php

require 'inc/config.php';

use inc\model\Categorie;

// Gestion du POST du formulaire
if (!empty($_POST)) {
    $cat_id = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;
    $cat_nom = isset($_POST['cat_nom']) ? trim($_POST['cat_nom']) : '';

    Categorie::setCategorie($cat_id, $cat_nom);
}

// J'initialise les variables affichés (echo) dans le form pour éviter les "NOTICE"
$currentId = 0;
$cat_nom = '';

// Récupère toutes les catégories pour générer le menu déroulant des catégories
// J'appelle ma fonction car j'ai factorisé comme un pro !
$categoriesList = Categorie::getAllCat();

// Si l'id est passé en paramètre => je pré-remplis le formulaire pour la modification
if (isset($_GET['id'])) {
    $currentId = intval($_GET['id']);

    $cat_nom = Categorie::getCategorie($currentId);
}


require 'inc/view/header.php';
require 'inc/view/form_categorie.phtml';
require 'inc/view/footer.php';
