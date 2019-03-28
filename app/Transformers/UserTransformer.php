<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
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

    public static function originalAttribute($index) {
        $attributes = [
            'id' => 'id',
            'username' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'isAdministrator' => 'admin',
            'creation_date' => 'created_at',
            'update_date' => 'updated_at',
            'delete_date' => 'deleted_at',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'id',
            'name' => 'username',
            'email' => 'email',
            'verified' => 'isVerified',
            'admin' => 'isAdministrator',
            'created_at' => 'creation_date',
            'updated_at' => 'update_date',
            'deleted_at' => 'delete_date',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
