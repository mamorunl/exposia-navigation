<?php
/**
 * Created by Bas Hepping <info@mamoru.nl>.
 * Date: 24-10-2015
 * Time: 12:11
 */

namespace Exposia\Navigation\Providers;


use Exposia\Navigation\Models\Navigation;
use Exposia\Navigation\Models\Page;
use Exposia\Navigation\Policies\NavigationPolicy;
use Exposia\Navigation\Policies\PagePolicy;
use Illuminate\Contracts\Auth\Access\Gate;

class AuthServiceProvider extends \Illuminate\Foundation\Support\Providers\AuthServiceProvider
{
    protected $policies = [
        Navigation::class => NavigationPolicy::class,
        Page::class       => PagePolicy::class
    ];

    public function boot(Gate $gate)
    {
        $this->registerPolicies($gate);
    }
}