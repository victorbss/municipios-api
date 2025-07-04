<?php

namespace Tests\Unit;

use App\Services\IbgeMunicipioProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IbgeMunicipioProviderTest extends TestCase
{
    public function testGetMunicipiosReturnsCorrectData()
    {
        $service = new IbgeMunicipioProvider();

        $result = $service->getMunicipiosByUf('rs');

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
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
