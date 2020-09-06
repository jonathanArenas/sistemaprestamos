<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(User $authUser, User $user){
        return $authUser->id == $user->id;
    }

    public function edit(User $authUser, User $user){
        return $authUser->id == $user->id;
    }

    public function update(User $authUser, User $user){
        return $authUser->id == $user->id;
    }
}
