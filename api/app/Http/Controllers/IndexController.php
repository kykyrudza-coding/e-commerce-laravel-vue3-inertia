<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $region = 'Fortress';

        return response()->json([
            'status' => 'success',
            'data' => [
                'most_sold_in_store' => Product::mostSoldInStore(4),
                'most_sold_in_region' => Product::mostSoldInRegion($region, 4),
                'region' => $region,
            ]
        ]);
    }
}
