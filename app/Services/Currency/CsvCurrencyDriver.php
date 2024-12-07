<?php

namespace App\Services\Currency;

class CsvCurrencyDriver extends CurrencyDriver
{
    /**
     * Fetch CSV data from the file.
     */
    protected function fetchData()
    {
        return file(storage_path('app/currencies/rates.csv'));
    }

    /**
     * Parse the CSV data into an associative array.
     */
    protected function parseData($data)
    {
        $rates = [];
        foreach (array_slice($data, 1) as $line) { // Skip the header row
            [$from, $to, $rate] = str_getcsv($line);
            $rates["{$from}_to_{$to}"] = (float) $rate;
        }
        return $rates;
    }
}
