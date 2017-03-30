<?php

require 'inc/config.php';

use inc\model\Categorie;

$categorieList = Categorie::get4Categories();

require 'inc/view/header.php';
require 'inc/view/home.phtml';
require 'inc/view/footer.php';
