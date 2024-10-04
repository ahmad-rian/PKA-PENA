<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Peksos;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeksosPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_peksos');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Peksos $peksos): bool
    {
        return $user->can('view_peksos');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_peksos');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Peksos $peksos): bool
    {
        return $user->can('update_peksos');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Peksos $peksos): bool
    {
        return $user->can('delete_peksos');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_peksos');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Peksos $peksos): bool
    {
        return $user->can('force_delete_peksos');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_peksos');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Peksos $peksos): bool
    {
        return $user->can('restore_peksos');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_peksos');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Peksos $peksos): bool
    {
        return $user->can('replicate_peksos');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_peksos');
    }
}
