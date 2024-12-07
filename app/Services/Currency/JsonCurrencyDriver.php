<?php

namespace App\Services\Currency;

class JsonCurrencyDriver extends CurrencyDriver
{
    /**
     * Fetch JSON data from the file.
     */
    protected function fetchData()
    {
        return file_get_contents(storage_path('app/currencies/rates.json'));
    }

    /**
     * Parse the JSON data into an array.
     */
    protected function parseData($data)
    {
        return json_decode($data, true);
    }
}
