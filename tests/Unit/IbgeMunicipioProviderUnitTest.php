<?php

namespace Tests\Unit;

use App\Services\IbgeMunicipioProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IbgeMunicipioProviderUnitTest extends TestCase
{
    public function testGetMunicipiosReturnsCorrectData()
    {
        Http::fake([
            'https://servicodados.ibge.gov.br/api/v1/localidades/estados/rs/municipios' => Http::response([
                ['nome' => 'Porto Alegre', 'id' => 4314902],
                ['nome' => 'Canoas', 'id' => 4304606],
            ], 200)
        ]);

        $service = new IbgeMunicipioProvider();

        $result = $service->getMunicipiosByUf('rs');

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        $this->assertEquals('Porto Alegre', $result[0]['name']);
        $this->assertEquals(4314902, $result[0]['ibge_code']);
    }

    public function testGetMunicipiosHandlesWrongUF()
    {
        Http::fake([
            'https://servicodados.ibge.gov.br/api/v1/localidades/estados/xx/municipios' => Http::response(null, 500),
        ]);

        $service = new IbgeMunicipioProvider();

        $result = $service->getMunicipiosByUf('XX');

        $this->assertEmpty($result);
    }
}
