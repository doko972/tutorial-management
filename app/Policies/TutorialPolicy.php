<?php

namespace App\Policies;

use App\Models\Tutorial;
use App\Models\User;

class TutorialPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir les tutoriels
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tutorial $tutorial): bool
    {
        // Tous les utilisateurs peuvent voir les tutoriels publiés
        return $tutorial->is_published || $user->isAdmin() || $user->id === $tutorial->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // L'utilisateur doit appartenir à une branche pour créer un tutoriel
        return $user->branch_id !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tutorial $tutorial): bool
    {
        // L'auteur, un manager de la même branche, ou un admin peut modifier
        return $user->id === $tutorial->user_id 
            || ($user->isManager() && $user->branch_id === $tutorial->branch_id)
            || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tutorial $tutorial): bool
    {
        // L'auteur, un manager de la même branche, ou un admin peut supprimer
        return $user->id === $tutorial->user_id 
            || ($user->isManager() && $user->branch_id === $tutorial->branch_id)
            || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tutorial $tutorial): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tutorial $tutorial): bool
    {
        return $user->isAdmin();
    }
}