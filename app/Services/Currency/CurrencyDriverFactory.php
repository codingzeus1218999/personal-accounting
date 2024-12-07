<?php

namespace App\Services\Currency;

use Illuminate\Support\Facades\Cache;
use App\Services\Currency\JsonCurrencyDriver;
use App\Services\Currency\XmlCurrencyDriver;
use App\Services\Currency\CsvCurrencyDriver;

class CurrencyDriverFactory
{
    public static function create($type)
    {
        $driver = null;

        switch ($type) {
            case 'json':
                $driver = new JsonCurrencyDriver();
                break;
            case 'xml':
                $driver = new XmlCurrencyDriver();
                break;
            case 'csv':
                $driver = new CsvCurrencyDriver();
                break;
            default:
                throw new \Exception('Unsupported driver type.');
        }

        $cacheKey = "currency_rates_{$type}";

        // Cache the rates fetched by the driver
        return Cache::remember($cacheKey, 300, function () use ($driver) {
            return $driver->getRates();
        });
    }
}
