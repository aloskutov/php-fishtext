<?php

declare(strict_types=1);

namespace ALoskutov\FishText;

class FishText
{
    private FishTextAdaptor $adaptor;

    public function __construct(FishTextAdaptor $adaptor = null)
    {
        if (!$adaptor) {
            $adaptor = new FishTextAdaptorOnline();
        }
        $this->adaptor = $adaptor;
    }

    public function sentence(int $number = 3): string
    {
        return $this->adaptor->sentence($number);
    }

    public function paragraph(int $number = 3): string
    {
        return $this->adaptor->paragraph($number);
    }

    public function title(int $number = 1): string
    {
        return $this->adaptor->title($number);
    }

    public function setFormat(string $format)
    {
        $this->adaptor->setFormat($format);
    }

    public function getFormat(): string
    {
        return $this->adaptor->getFormat();
    }
}
