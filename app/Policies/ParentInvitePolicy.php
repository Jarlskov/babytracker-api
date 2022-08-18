<?php

namespace App\Policies;

use App\Models\ParentInvite;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParentInvitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentInvite  $parentInvite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ParentInvite $parentInvite)
    {
        return $parentInvite->baby->parents()->contains(function ($parent) use ($user) {
            return $parent->id === $user->id;
        }) || $parentInvite->email === $user->email;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentInvite  $parentInvite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ParentInvite $parentInvite)
    {
        return $this->view($user, $parentInvite);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentInvite  $parentInvite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ParentInvite $parentInvite)
    {
        return $this->update($user, $parentInvite);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentInvite  $parentInvite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ParentInvite $parentInvite)
    {
        return $this->delete($user, $parentInvite);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentInvite  $parentInvite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ParentInvite $parentInvite)
    {
        return $this->delete($user, $parentInvite);
    }
}
