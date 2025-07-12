<?php
namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Property $property)
    {
        return $user->id === $property->user_id;
    }

    public function delete(User $user, Property $property)
    {
        return $user->id === $property->user_id;
    }
}