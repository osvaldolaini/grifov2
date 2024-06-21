<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Configurations;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigurationsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_configurations');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Configurations $configurations): bool
    {
        return $user->can('view_configurations');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_configurations');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Configurations $configurations): bool
    {
        return $user->can('update_configurations');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Configurations $configurations): bool
    {
        return $user->can('delete_configurations');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_configurations');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Configurations $configurations): bool
    {
        return $user->can('force_delete_configurations');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_configurations');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Configurations $configurations): bool
    {
        return $user->can('restore_configurations');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_configurations');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Configurations $configurations): bool
    {
        return $user->can('replicate_configurations');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_configurations');
    }
}
