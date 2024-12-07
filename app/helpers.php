<?php

if (!function_exists('convert_currency')) {
    function convert_currency($amount, $from, $to, $driverType = 'json')
    {
        return \App\Facades\CurrencyConverter::convert($amount, $from, $to, $driverType);
    }
}
