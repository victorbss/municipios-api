<?php

namespace App\Services;

use App\Services\MunicipioProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BrasilApiMunicipioProvider implements MunicipioProviderInterface
{
    public function getMunicipiosByUf(string $uf): array
    {
        return Cache::remember("municipios_{$uf}", 3600, function () use ($uf) {
            $response = Http::get("https://brasilapi.com.br/api/ibge/municipios/v1/{$uf}");
            return collect($response->json())->map(fn($m) => [
                'name' => $m['nome'],
                'ibge_code' => $m['codigo_ibge'],
            ])->toArray();
        });
    }
}
