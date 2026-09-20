<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        // التحقق من الصلاحية مع تحديد الـ guard صراحة إذا لزم، أو الفحص المباشر
        return $user->hasPermissionTo('Index Role');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('Show Role');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('Edit Role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('Delete Role');
    }
}
