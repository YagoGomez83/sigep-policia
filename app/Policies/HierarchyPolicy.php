<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hierarchy;
use Illuminate\Auth\Access\HandlesAuthorization;

class HierarchyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_hierarchy');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hierarchy $hierarchy): bool
    {
        return $user->can('view_hierarchy');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_hierarchy');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hierarchy $hierarchy): bool
    {
        return $user->can('update_hierarchy');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hierarchy $hierarchy): bool
    {
        return $user->can('delete_hierarchy');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_hierarchy');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Hierarchy $hierarchy): bool
    {
        return $user->can('force_delete_hierarchy');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_hierarchy');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Hierarchy $hierarchy): bool
    {
        return $user->can('restore_hierarchy');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_hierarchy');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Hierarchy $hierarchy): bool
    {
        return $user->can('replicate_hierarchy');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_hierarchy');
    }
}
