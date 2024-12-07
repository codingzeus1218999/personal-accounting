<?php

namespace App\Facades;

use App\Services\Currency\CurrencyDriverFactory;

class CurrencyConverter
{
    public static function convert($amount, $from, $to, $driverType = 'json')
    {
        $driver = CurrencyDriverFactory::create($driverType);
        $rates = $driver->getRates();

        $rateKey = "{$from}_to_{$to}";
        if (!isset($rates[$rateKey])) {
            throw new \Exception("Conversion rate from {$from} to {$to} not found.");
        }

        return $amount * $rates[$rateKey];
    }
}
