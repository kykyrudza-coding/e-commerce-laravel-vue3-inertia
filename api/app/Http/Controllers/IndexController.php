<?php

namespace App\Http\Controllers;

use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {
        $region = 'Fortress';

        return response()->json([
            'most_sold_in_store' => Product::most_sold_in_store(4),
            'most_sold_in_region' => Product::most_sold_in_region($region, 4),
            'region' => $region,
        ]);
    }

    public function faq()
    {
        return response()->json(['data' => []]);
    }

    public function contact()
    {
        return response()->json(['data' => []]);
    }

    public function about()
    {
        return response()->json(['data' => []]);
    }
}
