<?php

namespace Tests\Unit;

use App\Services\BrasilApiMunicipioProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BrasilApiMunicipioProviderTest extends TestCase
{
    public function testGetMunicipiosReturnsCorrectData()
    {
        Http::fake([
            'https://brasilapi.com.br/api/ibge/municipios/v1/RS' => Http::response([
                ['nome' => 'Porto Alegre', 'codigo_ibge' => 4314902],
                ['nome' => 'Canoas', 'codigo_ibge' => 4304606],
            ], 200)
        ]);

        $service = new BrasilApiMunicipioProvider();

        $result = $service->getMunicipiosByUf('RS');

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        $this->assertEquals('Porto Alegre', $result[0]['name']);
        $this->assertEquals(4314902, $result[0]['ibge_code']);
    }

    public function testGetMunicipiosHandlesWrongUF()
    {
        Http::fake([
            'https://brasilapi.com.br/api/ibge/municipios/v1/XX' => Http::response(null, 500),
        ]);

        $service = new BrasilApiMunicipioProvider();

        $result = $service->getMunicipiosByUf('XX');

        $this->assertEmpty($result);
    }
}
