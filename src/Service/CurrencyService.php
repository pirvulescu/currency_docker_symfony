<?php

namespace App\Service;

use GuzzleHttp\Client;

class CurrencyService
{
    private $client;
    private $key;
    private $baseApi;

    public function __construct(Client $client, string $key, string $baseApi)
    {
        $this->client = $client;
        $this->key = $key;
        $this->baseApi = $baseApi;
    }

    public function convert(string $from, string $to, float $value): ?string
    {
        if (!$conversionRate = $this->getConversionRate($from, $to)) {
            return null;
        }

        return $conversionRate * $value;
    }

    public function getCurrencies(): array
    {
        try {
            $decodedRates = $this->getRates();
        } catch (\Exception $e) {
            return [];
        }

        return array_combine(array_keys($decodedRates['rates']), array_keys($decodedRates['rates']));
    }

    private function getConversionRate(string $from, string $to): ?float
    {
        /**
         * For free fixer.io accounts /api/convert endpoint is not accessible
         * In this case we extract conversion rate from api/latest endpoint and convert manually
         */
        try {
            $decodedRates = $this->getRates();
        } catch (\Exception $e) {
            return null;
        }

        return $decodedRates['rates'][$to]/$decodedRates['rates'][$from];
    }

    private function getRates(): array
    {
        if (!$rates = $this->client
            ->request('GET', $this->baseApi . '/api/latest?access_key=' . $this->key)) {
            throw new \Exception('Invalid conversion response');
        }

        if ($rates->getStatusCode() !== 200) {
            throw new \Exception('Invalid conversion response');
        }

        if (!$decodedRates = json_decode($rates->getBody(), true)) {
            throw new \Exception('Invalid conversion response');
        }

        if (empty($decodedRates['rates'])) {
            throw new \Exception('Invalid conversion response');
        }

        return $decodedRates;
    }
}