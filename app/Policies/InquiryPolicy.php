<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;

class InquiryPolicy
{
    public function view(User $user, Inquiry $inquiry): bool
    {
        if ($user->isMcmc()) {
            return true;
        }

        if ($user->isAgency() && $inquiry->currentAssignment) {
            return $inquiry->currentAssignment->agency_id === $user->agency_id;
        }

        if ($user->isPublic()) {
            return $inquiry->user_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isPublic();
    }

    public function update(User $user, Inquiry $inquiry): bool
    {
        return $user->isMcmc();
    }

    public function delete(User $user, Inquiry $inquiry): bool
    {
        return $user->isMcmc() && $inquiry->user_id !== $user->id;
    }
}
