<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;

class BudgetPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Budget $budget): bool
    {
        return $user->id === $budget->client_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Budget $budget): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Budget $budget): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can manage transactions (add/remove payments/charges).
     */
    public function manageTransactions(User $user, Budget $budget): bool
    {
        return $user->role === 'admin';
    }
}
