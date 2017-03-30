<?php

require 'inc/config.php';

spl_autoload();

// Page par défaut => 1
$currentPage = 1;
$searchTerms = '';
$categorieId = 0;
// On souhaite afficher 4 films par page
$nbFilmsParPage = 4;
$offsetPage = 0;
// Je récupère le paramètre d'URL "page" de type integer
if (isset($_GET['page'])) {
	$currentPage = intval($_GET['page']);
	$offsetPage = ($currentPage-1)*$nbFilmsParPage;
}

// Je récupère le paramètre d'URL "q"
if (isset($_GET['q'])) {
	$searchTerms = trim($_GET['q']);
}
// Je récupère le paramètre d'URL "cat_id"
if (isset($_GET['cat_id'])) {
	$categorieId = intval(trim($_GET['cat_id']));
}


$filmlist = Film::getlist($offsetPage, $nbFilmsParPage, $categorieId, $searchTerms);

$pageTitle = 'Catalogue';
require 'html/header.php';
?>
<section class="pagination">
	<?php
	if ($currentPage >= 2) {
	?>
	<a href="?page=<?php echo $currentPage-1; ?>&q=<?php echo $searchTerms; ?>&cat_id=<?php echo $categorieId; ?>">&lt; précédent</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	}
	if (sizeof($filmList) >= 4) {
	?>
	<a href="?page=<?php echo $currentPage+1; ?>&q=<?php echo $searchTerms; ?>&cat_id=<?php echo $categorieId; ?>">suivant &gt;</a>
	<?php
	}
	?>	
</section>
<section class="filmList">
	<?php
	// Si la variable $filmList existe et si elle contient plusieurs lignes
	if (isset($filmList) && sizeof($filmList) > 0) {
		foreach ($filmList as $currentFilmInfos) {
		?>
		<article>
			<div class="content">
				<a href="details.php?id=<?php echo $currentFilmInfos['fil_id']; ?>"><img src="<?php echo $currentFilmInfos['fil_affiche']; ?>" border="0" /></a>
				<div class="titre">
					#<?php echo $currentFilmInfos['fil_id']; ?>&nbsp;
					<a href="details.php?id=<?php echo $currentFilmInfos['fil_id']; ?>"><?php echo $currentFilmInfos['fil_titre']; ?></a>
				</div>
				<div class="synopsis">
					<?php echo $currentFilmInfos['fil_synopsis']; ?>
				</div>
			</div>
			<div class="actions">
				<a class="btn" href="details.php?id=<?php echo $currentFilmInfos['fil_id']; ?>">Détails</a><br />
				<a class="btn" href="form_film.php?id=<?php echo $currentFilmInfos['fil_id']; ?>">Modifier</a><br />
			</div>
		</article>
		<?php
		}
	}
	?>
</section>
<?php
require 'html/footer.php';