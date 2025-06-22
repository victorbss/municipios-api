<?php

namespace App\Services;

interface MunicipioProviderInterface {
    public function getMunicipiosByUf(string $uf): array;
}