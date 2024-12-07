<?php

namespace App\Services\Currency;

class XmlCurrencyDriver extends CurrencyDriver
{
    /**
     * Fetch XML data from the file.
     */
    protected function fetchData()
    {
        return file_get_contents(storage_path('app/currencies/rates.xml'));
    }

    /**
     * Parse the XML data into an associative array.
     */
    protected function parseData($data)
    {
        $xml = simplexml_load_string($data);
        $rates = [];
        foreach ($xml->rate as $rate) {
            $rates["{$rate['from']}_to_{$rate['to']}"] = (float) $rate;
        }
        return $rates;
    }
}
