<?php

namespace App\Policies;

use App\Models\User;
use App\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function __construct(User $user) {
        if ($user->role == "ADMIN") {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->role == "ADMIN" || $user->role == "CLIENT") {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user->role == "ADMIN" || $user->role == "CLIENT") {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        if ($user->role == "ADMIN" || $user->role == "CLIENT") {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function update(User $user)
    {
        //
        if ($user->role == "ADMIN") {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        if ($user->role == "ADMIN") {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function restore(User $user, Ticket $ticket)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }

    /**
     * assigneUser
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function assigneUser(User $user)
    {
        //
        if ($user->role == "ADMIN") {
            return true;
        }
    }
}
