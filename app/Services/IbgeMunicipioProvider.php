<?php

namespace App\Services;

use App\Services\MunicipioProviderInterface;
use Illuminate\Support\Facades\Http;

class IbgeMunicipioProvider implements MunicipioProviderInterface
{
    public function getMunicipiosByUf(string $uf): array
    {
        $response = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios");
        return collect($response->json())->map(fn($m) => [
            'name' => $m['nome'],
            'ibge_code' => $m['id'],
        ])->toArray();
    }
}
