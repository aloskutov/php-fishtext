# php-fishtext

Получает данные через API с сайта FishText (https://fish-text.ru/get) генерирующего тестовый контент трёх типов: заголовок, предложения и абзац/параграф.

## Требования

- PHP 7.4 или выше
- для php 7.4 расширение **mbstring**

## Установка

```shell
composer require aloskutov/php-fishtext
```

## Данные

Работает с тремя типами данных:
- Заголовок (от 1 до 500 заголовков, по-умолчанию: 1)
- Предложение (от 1 до 500 предложений, по-умолчанию: 3)
- Абзац (от 1 до 100 абзацев, по умолчанию 3)

## Форматы

Может возвращать данные в формате `JSON` или `HTML`. Формат указывается методом `setFormat()`, по-умолчанию установлен формат `JSON`.

### JSON

Пример использования:

```php
use App\FishText;

$fishtext = new FishText();
$fishtext->setFormat('json');
echo $fishtext->title();
```

На выходе строка обработанная `json_decode`.


При запросе нескольких параграфов, абзацы разделены символами `\n\n`.

### HTML

Пример использования:

```php
use App\FishText;

$fishtext = new FishText();
$fishtext->setFormat('html');
echo $fishtext->paragraph(5);
```

Данные возвращаются обёрнутые html тэгами.

- Предложения, (метод `sentence()`) оборачиваются тэгом `<h1>`.
- Заголовки, (метод `title()`) оборачивается тегом `<p>`.
- Абазацы/параграфы, (метод `paragraph()`) каждый параграф оборачивается тэгом `<p>`.

## Пример

```php
<?php

declare(strict_types=1);

require_once("vendor/autoload.php");

use App\FishText;

$fishtext = new FishText();

// Запрашиваем данные типа Заголовок, одно предложение (по-умолчанию)
var_dump($fishtext->title());

// Устанавливаем формат возвращаемых данных: HTML
$fishtext->setFormat('html');

// Запрашиваем данные типа Предложение, три предложения (по-умолчанию)
var_dump($fishtext->sentence());

// Запрашиваем данные типа Абзац, по умолчанию три абзаца (по-умолчанию)
var_dump($fishtext->paragraph());
```
