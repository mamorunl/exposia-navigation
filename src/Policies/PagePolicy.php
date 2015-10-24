<?php
/**
 * Created by Bas Hepping <info@mamoru.nl>.
 * Date: 24-10-2015
 * Time: 18:41
 */

namespace Exposia\Navigation\Policies;


class PagePolicy
{
    public function before(User $user, $ability)
    {
        if($user->hasRole('admin')) {
            return true;
        }
    }
}