<?php

require 'inc/config.php';

$categorieList=array();
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
	$categorieList = $pdoStatement->fetchAll();
}

require 'inc/view/header.php';
require 'inc/view/home.phtml';
require 'inc/view/footer.php';