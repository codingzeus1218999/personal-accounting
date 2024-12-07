<?php

namespace App\Services\Currency;

abstract class CurrencyDriver
{
    public function getRates()
    {
        $data = $this->fetchData();
        return $this->parseData($data);
    }

    abstract protected function fetchData();
    abstract protected function parseData($data);
}
