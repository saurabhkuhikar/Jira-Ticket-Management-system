<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Ticket' => 'App\Policies\TicketPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /**
         * User access defination
         */
        Gate::define('update-user', 'App\Policies\UserPolicy@update');
        Gate::define('view-user', 'App\Policies\UserPolicy@view');
        Gate::define('delete-user', 'App\Policies\UserPolicy@delete');
        Gate::define('create-user', 'App\Policies\UserPolicy@create');

        /**
         * Tickets access defination
         */
        Gate::define('update-ticket', 'App\Policies\TicketPolicy@update');
        Gate::define('create-ticket', 'App\Policies\TicketPolicy@create');
        Gate::define('view-ticket', 'App\Policies\TicketPolicy@view');
        Gate::define('delete-ticket', 'App\Policies\TicketPolicy@create');
        Gate::define('assign-ticket', 'App\Policies\TicketPolicy@assigneUser');
    }
}
