<?php

declare(strict_types=1);

namespace App;

class FishText
{
    /**
     * @var string
     */
    private $url = 'https://fish-text.ru/get';

    /**
     * @var array|\int[][]
     */
    private $types = [
        'sentence' => ['min' => 1, 'max' => 500],
        'paragraph' => ['min' => 1, 'max' => 100],
        'title' => ['min' => 1, 'max' => 500]
    ];

    /**
     * @var array|string[]
     */
    private $errorCode = [
        11 => "Превышен допустимый объём запрашиваемого контента",
        21 => "IP заблокирован на 120 секунд из-за превышения лимита обращений",
        22 => "IP заблокирован навсегда",
        31 => "Неизвестная ошибка сервера",
    ];

    /**
     * @var string
     */
    private $queryString ='';

    /**
     * @var string
     */
    private $format = "json";

    /**
     * Create query string
     *
     * @param string $type
     * @param int $number
     * @param string $format
     * @return void
     */
    private function createQuery(string $type, int $number)
    {
        $this->queryString = http_build_query(
            array(
                "format" => $this->format,
                "type" => $type,
                "number" => $number,
            )
        );
    }

    /**
     * @return ?string
     */
    private function getRequest(): ?string
    {
        $response = file_get_contents($this->url . "?" . $this->queryString);

        if ($this->format === 'json') {
            $result = json_decode($response);

            if (property_exists($result, 'errorCode')) {
                throw new Exception($this->errorCode[$result->errorCode], $result->errorCode);
            }
            return $result->text;
        }
        return $response;
    }

    /**
     * Prepare
     *
     * @param string $type
     * @param int $number
     * @return false|string
     */
    private function request(string $type, int $number)
    {
        $number = $number < $this->types[$type]['min'] ? $this->types[$type]['min'] : $number;
        $number = $number > $this->types[$type]['max'] ? $this->types[$type]['max'] : $number;

        $this->createQuery($type, $number);
        return $this->getRequest();
    }

    public function sentence(int $number = 3): string
    {
        return $this->request('sentence', $number);
    }

    public function paragraph(int $number = 3): string
    {
        return $this->request('paragraph', $number);
    }

    public function title(int $number = 1): string
    {
        return $this->request('title', $number);
    }

    public function setFormat(string $format)
    {
        $format = strtolower($format);

        $this->format = ($format == 'json' || $format == 'html') ? $format : 'json';
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
