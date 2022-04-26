<?php

declare(strict_types=1);

require_once("vendor/autoload.php");

use ALoskutov\FishText\FishText;
use ALoskutov\FishText\FishTextAdaptorLocal;

$fishtext = new FishText(new FishTextAdaptorLocal());

// Устанавливаем формат возвращаемых данных: text
$fishtext->setFormat('text');

// Запрашиваем данные типа Заголовок, одно предложение (по-умолчанию)
var_dump($fishtext->title());

// Запрашиваем данные типа Предложение, по умолчанию три предложения
var_dump($fishtext->sentence());

// Устанавливаем формат возвращаемых данных: HTML
$fishtext->setFormat('html');

// Запрашиваем данные типа Абзац, по умолчанию три абзаца
var_dump($fishtext->paragraph());
