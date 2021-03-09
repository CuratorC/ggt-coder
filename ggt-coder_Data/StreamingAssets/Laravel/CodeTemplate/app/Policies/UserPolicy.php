<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends Policy
{
    public function show(User $currentUser, User $user)
    {
        return $currentUser->can('管理权限');
    }
    public function add(User $currentUser, User $user)
    {
        return $currentUser->can('管理权限');
    }
    public function update(User $currentUser, User $user)
    {
        return $currentUser->can('管理权限');
    }
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->can('管理权限');
    }
}
