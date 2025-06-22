<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MunicipioProviderInterface;

class MunicipioController extends Controller
{
    public function index(string $uf, Request $request, MunicipioProviderInterface $service)
    {
        try {
            if(empty($uf) || strlen($uf) != 2){
                throw new \Exception('UF inválido');
            }

            $data = $service->getMunicipiosByUf(strtoupper($uf));
            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
