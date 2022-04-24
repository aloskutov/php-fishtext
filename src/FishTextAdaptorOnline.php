<?php

namespace App;

use Exception;

class FishTextAdaptorOnline implements FishTextAdaptor
{
    /**
     * @var string
     */
    private string $url = 'https://fish-text.ru/get';

    /**
     * @var array|int[][]
     */
    private array $types = [
        'sentence' => ['min' => 1, 'max' => 500],
        'paragraph' => ['min' => 1, 'max' => 100],
        'title' => ['min' => 1, 'max' => 500]
    ];

    /**
     * @var array
     */
    private array $errorCode = [
        11 => "Превышен допустимый объём запрашиваемого контента",
        21 => "IP заблокирован на 120 секунд из-за превышения лимита обращений",
        22 => "IP заблокирован навсегда",
        31 => "Неизвестная ошибка сервера",
    ];

    /**
     * @var string
     */
    private string $queryString ='';

    /**
     * @var string
     */
    private string $format = "json";

    /**
     * Create query string
     *
     * @param string $type
     * @param int $number
     * @return void
     */
    private function createQuery(string $type, int $number): void
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
     * @throws Exception
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
     * @return string
     * @throws Exception
     */
    private function request(string $type, int $number)
    {
        $number = max($number, $this->types[$type]['min']);
        $number = min($number, $this->types[$type]['max']);

        $this->createQuery($type, $number);
        return $this->getRequest();
    }

    /**
     * @param int $number
     * @return string
     * @throws Exception
     */
    public function sentence(int $number = 3): string
    {
        return $this->request('sentence', $number);
    }

    /**
     * @param int $number
     * @return string
     * @throws Exception
     */
    public function paragraph(int $number = 3): string
    {
            return $this->request('paragraph', $number);
    }

    /**
     * @param int $number
     * @return string
     * @throws Exception
     */
    public function title(int $number = 1): string
    {
        return $this->request('title', $number);
    }

    /**
     * @param string $format
     * @return void
     */
    public function setFormat(string $format = 'json'): void
    {
        $format = strtolower($format);

        $this->format = ($format == 'json' || $format == 'html') ? $format : 'json';
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }
}
