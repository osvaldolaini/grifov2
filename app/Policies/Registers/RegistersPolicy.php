<?php

namespace App\Policies\Registers;

use App\Models\User;
use App\Models\Registers\Registers;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistersPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_registers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Registers $registers): bool
    {
        return $user->can('view_registers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_registers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Registers $registers): bool
    {
        return $user->can('update_registers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Registers $registers): bool
    {
        return $user->can('delete_registers');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_registers');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Registers $registers): bool
    {
        return $user->can('force_delete_registers');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_registers');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Registers $registers): bool
    {
        return $user->can('restore_registers');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_registers');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Registers $registers): bool
    {
        return $user->can('replicate_registers');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_registers');
    }
}
