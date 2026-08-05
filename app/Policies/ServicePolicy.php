<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;
use Illuminate\Auth\Access\Response;

class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Service $service): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isServiceProvider();
    }

    public function update(User $user, Service $service): bool
    {
        return $user->id === $service->user_id || $user->user_type === 'admin';
    }

    public function delete(User $user, Service $service): bool
    {
        return $user->id === $service->user_id || $user->user_type === 'admin';
    }
}
