<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'id' => (int)$seller->id,
            'username' => (string)$seller->name,
            'email' => (string)$seller->email,
            'isVerified' => (int)$seller->verified,
            'creation_date' => (string)$seller->created_at,
            'update_date' => (string)$seller->updated_at,
            'delete_date' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('sellers.show', $seller->id)
                ],
                [
                    'rel' => 'seller.buyers',
                    'href' => route('sellers.buyers.index',$seller->id)
                ],
                [
                    'rel' => 'seller.categories',
                    'href' => route('sellers.categories.index',$seller->id)
                ],
                [
                    'rel' => 'seller.products',
                    'href' => route('sellers.products.index',$seller->id)
                ],
                [
                    'rel' => 'seller.transactions',
                    'href' => route('sellers.transactions.index',$seller->id)
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show',$seller->id)
                ]
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'id' => 'id',
            'username' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'creation_date' => 'created_at',
            'update_date' => 'updated_at',
            'delete_date' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'username',
            'email' => 'email',
            'verified' => 'isVerified',
            'created_at' => 'creation_date',
            'updated_at' => 'update_date',
            'deleted_at' => 'delete_date',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
