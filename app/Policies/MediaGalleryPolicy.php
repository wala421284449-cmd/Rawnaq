<?php

namespace App\Policies;

use App\Models\MediaGallery;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MediaGalleryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Index MediaGallery');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MediaGallery $mediaGallery): bool
    {
        return $user->hasPermissionTo('Show MediaGallery');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create MediaGallery');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MediaGallery $mediaGallery): bool
    {
        return $user->hasPermissionTo('Edit MediaGallery');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MediaGallery $mediaGallery): bool
    {
        return $user->hasPermissionTo('Delete MediaGallery');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MediaGallery $mediaGallery): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MediaGallery $mediaGallery): bool
    {
        return false;
    }
}
