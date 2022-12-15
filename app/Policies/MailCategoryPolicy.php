<?php

namespace App\Policies;

use App\Models\MailCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MailCategoryPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, MailCategory $mailCategory)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, MailCategory $mailCategory)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, MailCategory $mailCategory)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, MailCategory $mailCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, MailCategory $mailCategory)
    {
        //
    }
}
