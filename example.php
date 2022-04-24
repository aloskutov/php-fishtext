<?php

declare(strict_types=1);

require_once("vendor/autoload.php");

use App\FishText;

$fishtext = new FishText();

var_dump($fishtext->title(1));

$fishtext->setFormat('html');
var_dump($fishtext->sentence(3));

var_dump($fishtext->paragraph(3));
