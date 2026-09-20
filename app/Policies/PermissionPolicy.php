<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Index Permission');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Permission $permission): bool
    {
        return $user->hasPermissionTo('Show Permission');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create Permission');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Permission $permission): bool
    {
        return $user->hasPermissionTo('Edit Permission');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Permission $permission): bool
    {
        return $user->hasPermissionTo('Delete Permission');
    }
}
