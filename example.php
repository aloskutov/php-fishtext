<?php

declare(strict_types=1);

require_once("vendor/autoload.php");

use App\FishText;

$fishtext = new FishText();

// Запрашиваем данные типа Заголовок, одно предложение (по-умолчанию)
var_dump($fishtext->title(1));

// Устанавливаем формат возвращаемых данных: HTML
$fishtext->setFormat('html');

// Запрашиваем данные типа Предложение, по умолчанию три предложения
var_dump($fishtext->sentence(3));

// Запрашиваем данные типа Абзац, по умолчанию три абзаца
var_dump($fishtext->paragraph(3));
