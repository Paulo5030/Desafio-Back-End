<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserAuthRepository
{
    public function __construct(protected readonly User $user)
    {
    }

    public function findByEmail(Model $provider, string $email)
    {
        return $provider->where('email', $email)->first();
    }
}
