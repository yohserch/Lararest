<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $buyer->transactions()->with('product.categories')
                    ->get()
                    ->pluck('product.categories')
                    ->collapse()
                    ->unique('id')
                    ->values();

        return $this->showAll($categories);
    }
}
