<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAdminDashboard(User $user)
    {
        return $user->isAdmin();
    }
    
    public function viewOperatorDashboard(User $user)
    {
        return $user->isOperator();
    }
}
