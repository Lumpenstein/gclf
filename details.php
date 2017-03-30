<?php

require 'inc/config.php';

use inc\model\Film;

$currentId = 0;

// Je récupère le paramètre d'URL "page" de type integer
if (isset($_GET['id'])) {
    $currentId = intval($_GET['id']);
}

$filmInfos = Film::getMovie($currentId);

require 'inc/view/header.php';
require 'inc/view/details.phtml';
require 'inc/view/footer.php';
