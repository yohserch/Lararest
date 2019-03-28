<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'id' => (int)$buyer->id,
            'username' => (string)$buyer->name,
            'email' => (string)$buyer->email,
            'isVerified' => (int)$buyer->verified,
            'creation_date' => (string)$buyer->created_at,
            'update_date' => (string)$buyer->updated_at,
            'delete_date' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $buyer->id)
                ],
                [
                    'rel' => 'buyer.categories',
                    'href' => route('buyers.categories.index',$buyer->id)
                ],
                [
                    'rel' => 'buyer.products',
                    'href' => route('buyers.products.index',$buyer->id)
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href' => route('buyers.sellers.index',$buyer->id)
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index',$buyer->id)
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show',$buyer->id)
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

    public static function transformedAttribute($index) {
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
