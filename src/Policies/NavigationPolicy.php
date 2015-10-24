<?php
/**
 * Created by Bas Hepping <info@mamoru.nl>.
 * Date: 24-10-2015
 * Time: 18:35
 */

namespace Exposia\Navigation\Policies;


use Exposia\Models\User;

class NavigationPolicy
{
    public function before(User $user, $ability)
    {
        if($user->hasRole('admin')) {
            return true;
        }
    }
}