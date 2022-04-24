<?php

namespace App;

class FishTextAdaptorLocal implements FishTextAdaptor
{
    private string $dataFile = __DIR__.'/includes/AdaptorOnline/text.php';
    private array $text = [];
    private string $format = 'json';

    public function __construct()
    {
        $this->text = include $this->dataFile;
    }

    private function generator()
    {
        $text = [];
        foreach ($this->text as $phrase) {
            $text[] = $phrase[rand(0, count($phrase) - 1)];
        }
        return implode(" ", $text);
    }

    public function title(int $number = 1): string
    {
        $text = [];
        for ($i = 1; $i <= $number; $i++) {
            $text[] = $this->generator();
        }

        $text = implode(' ', $text);

        if ($this->format === 'html') {
            $text = '<h1>' . $text . '</h1>';
        }
        return $text;
    }

    public function sentence(int $number = 3): string
    {
        $text = [];
        for ($i = 1; $i <= $number; $i++) {
            $text[] = $this->generator();
        }
        $text = implode(' ', $text);
        if ($this->format === 'html') {
            $text = '<p>' . $text . '</p>';
        }
        return $text;
    }

    public function paragraph(int $number = 3): string
    {
        $text = [];
        for ($i = 1; $i <= $number; $i++) {
            $text[] = $this->sentence(rand(2, 7));
        }
        return implode("\n\n", $text);
    }

    public function setFormat(string $format = 'json'): void
    {
        $format = strtolower($format);
        $this->format = ($format == 'json' || $format == 'html') ? $format : 'json';
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
