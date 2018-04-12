<?php
/**
 * Created by PhpStorm.
 * User: danpirvulescu
 * Date: 12.04.18
 * Time: 22:55
 */

namespace App\Tests\Service;

use App\Service\CurrencyService;
use App\Tests\Fixtures\ApiResponse;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class CurrencyServiceTest extends TestCase
{
    public function testConvert()
    {
        $client = \Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->andReturn(new ApiResponse());
        $currencyService = new CurrencyService($client, '', '');

        $rez = $currencyService->convert('EUR', 'USD', 10);
        $this->assertEquals(12, $rez);
    }
}