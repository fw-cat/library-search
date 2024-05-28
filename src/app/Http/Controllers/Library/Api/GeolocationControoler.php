<?php

namespace App\Http\Controllers\Library\Api;

use App\Http\Controllers\Controller;
use App\Services\CalilSearchService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class GeolocationControoler extends Controller
{
    public function get(Request $request, CalilSearchService $calilService): JsonResponse
    {
        // カーリルAPI
        $libraies = $calilService->geolocation("{$request->input('lon')},{$request->input('lat')}");
        return new JsonResponse([
            'libraies'  => $libraies,
            'lat'       => $request->input('lat'),
            'lon'       => $request->input('lon'),
        ], Response::HTTP_OK);
    }
}
