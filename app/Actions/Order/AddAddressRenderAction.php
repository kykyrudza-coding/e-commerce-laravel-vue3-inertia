<?php

namespace App\Actions\Order;

use AllowDynamicProperties;
use App\Models\City;
use App\Models\PostOffice;
use App\Models\Region;
use Inertia\Inertia;
use Inertia\Response;

class AddAddressRenderAction
{
    protected CartDataAndVerifyToken $cartDataAndVerifyToken;

    public function __construct(CartDataAndVerifyToken $cartDataAndVerifyToken)
    {
        $this->cartDataAndVerifyToken = $cartDataAndVerifyToken;
    }

    public function addAddressRenderAction($token): Response
    {
        $products = $this->cartDataAndVerifyToken->cart_data_and_order_token($token);

        $cities = City::select('name')->get();

        $regions = Region::select('name')->get();

        $postOffices = PostOffice::select('name')->get();

        return Inertia::render('Order/Index', [
            'contactInfo' => false,
            'addAddress' => true,
            'confirmOrder' => false,
            'products' => $products,
            'token' => $token,
            'cities' => $cities,
            'regions' => $regions,
            'postOffices' => $postOffices,
        ]);
    }
}
