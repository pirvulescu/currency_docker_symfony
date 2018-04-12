<?php
namespace App\Tests\Fixtures;

class ApiResponse
{
    public function getStatusCode()
    {
        return 200;
    }

    public function getBody()
    {
        $returnArray = [
            "rates" => [
                "EUR" => 1,
                "USD" => 1.2,
            ]
        ];

        return json_encode($returnArray);
    }
}