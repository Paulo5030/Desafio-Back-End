<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuthRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findByEmail (Model $provider, string $email)
    {
        return $provider->where('email', $email)->first();
    }
}