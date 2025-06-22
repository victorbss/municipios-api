<?php

namespace App\Services;

use App\Services\MunicipioProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class IbgeMunicipioProvider implements MunicipioProviderInterface
{
    public function getMunicipiosByUf(string $uf): array
    {
        return Cache::remember("municipios_{$uf}", 3600, function () use ($uf) {
            $response = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios");
            return collect($response->json())->map(fn($m) => [
                'name' => $m['nome'],
                'ibge_code' => $m['id'],
            ])->toArray();
        });
    }
}
