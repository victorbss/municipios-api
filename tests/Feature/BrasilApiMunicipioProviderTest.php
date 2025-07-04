<?php

namespace Tests\Unit;

use App\Services\BrasilApiMunicipioProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BrasilApiMunicipioProviderTest extends TestCase
{
    public function testGetMunicipiosReturnsCorrectData()
    {
        $service = new BrasilApiMunicipioProvider();

        $result = $service->getMunicipiosByUf('RS');

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
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
