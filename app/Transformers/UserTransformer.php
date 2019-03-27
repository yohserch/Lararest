<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    const PRUEBA = "1";

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int)$user->id,
            'username' => (string)$user->name,
            'email' => (string)$user->email,
            'isVerified' => (int)$user->verified,
            'isAdministrator' => ($user->admin === 'true'),
            'creation_date' => (string)$user->created_at,
            'update_date' => (string)$user->updated_at,
            'delete_date' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.show', $user->id)
                ]
            ]
        ];
    }

    static function originalAttribute($index) {
        $attributes = [
            'id' => 'id',
            'username' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'isAdministrator' => 'admin',
            'creation_date' => 'created_at',
            'update_date' => 'updated_at',
            'delete_date' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
