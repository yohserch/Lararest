<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => (int)$product->id,
            'title' => (string)$product->name,
            'details' => (string)$product->description,
            'stock' => (int)$product->quantity,
            'available' => (string)$product->status,
            'image' => url("img/{$product->image}"),
            'seller' => (int)$product->seller_id,
            'creation_date' => (string)$product->created_at,
            'update_date' => (string)$product->updated_at,
            'delete_date' => isset($product->deleted_at) ? (string)$product->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $product->id),
                ],
                [
                    'rel' => 'product.buyers',
                    'href' => route('products.buyers.index', $product->id)
                ],
                [
                    'rel' => 'product.categories',
                    'href' => route('products.categories.index', $product->id)
                ],
                [
                    'rel' => 'product.transactions',
                    'href' => route('products.transactions.index', $product->id)
                ],
                [
                    'rel' => 'seller',
                    'href' => route('sellers.show', $product->seller_id)
                ]
            ]
        ];
    }

    static function originalAttribute($index) {
        $attributes = [
            'id' => 'id',
            'title' => 'name',
            'details' => 'description',
            'stock' => 'quantity',
            'available' => 'status',
            'image' => 'image',
            'seller' => 'seller_id',
            'creation_date' => 'created_at',
            'update_date' => 'updated_at',
            'delete_date' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
