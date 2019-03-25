<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = $buyer->transactions()->with('product.seller')
                    ->get()
                    ->pluck('product.seller')
                    ->unique('id')
                    ->values();

        return $this->showAll($sellers);
    }
}
