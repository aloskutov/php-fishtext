<?php

declare(strict_types=1);

namespace ALoskutov\FishText;

interface FishTextAdaptor
{
    public function title(int $number = 1): string;

    public function sentence(int $number = 3): string;

    public function paragraph(int $number = 3): string;

    public function setFormat(string $format = 'text'): void;

    public function getFormat(): string;
}
