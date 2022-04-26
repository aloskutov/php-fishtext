<?php

namespace ALoskutov\FishText;

class FishTextAdaptorLocal implements FishTextAdaptor
{
    /**
     * @var string text data for generator
     */
    private string $dataFile = __DIR__.'/includes/AdaptorOnline/text.php';
    /**
     * @var array|mixed generated text
     */
    private array $text;
    /**
     * @var string data format
     */
    private string $format = 'json';

    public function __construct()
    {
        $this->text = include $this->dataFile;
    }

    /**
     * Text generator
     *
     * @return string
     */
    private function generator(): string
    {
        $text = [];
        foreach ($this->text as $phrase) {
            $text[] = $phrase[rand(0, count($phrase) - 1)];
        }
        return implode(" ", $text);
    }

    /**
     * Title generator
     *
     * @param int $number
     * @return string
     */
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

    /**
     * Sentence generator
     *
     * @param int $number
     * @return string
     */
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

    /**
     * Paragraph generator
     *
     * @param int $number
     * @return string
     */
    public function paragraph(int $number = 3): string
    {
        $text = [];
        for ($i = 1; $i <= $number; $i++) {
            $text[] = $this->sentence(rand(2, 7));
        }
        return $this->format == 'json' ? implode("\n\n", $text) : implode("", $text);
    }

    /**
     * Set data format
     *
     * @param string $format html or json
     * @return void
     */
    public function setFormat(string $format = 'json'): void
    {
        $format = strtolower($format);
        $this->format = ($format == 'json' || $format == 'html') ? $format : 'json';
    }

    /**
     * Get data format
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }
}
