<?php

namespace App\Providers;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Gestão de pedidos
        Gate::define('gestão_de_pedido_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Orders
        Gate::define('order_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('order_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('order_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('order_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('order_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Order status
        Gate::define('order_status_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('order_status_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('order_status_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('order_status_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('order_status_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Gestão de empresas
        Gate::define('gestão_de_empresa_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Companies
        Gate::define('company_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('company_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('company_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('company_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('company_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Partner
        Gate::define('partner_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('partner_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('partner_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('partner_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('partner_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Gestão de premiação
        Gate::define('gestão_de_premiação_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        // Auth gates for: Premiacao
        Gate::define('premiacao_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('premiacao_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('premiacao_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('premiacao_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('premiacao_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Clientes
        Gate::define('cliente_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('cliente_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('cliente_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('cliente_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('cliente_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Score
        Gate::define('score_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('score_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('score_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('score_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('score_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Partner type
        Gate::define('partner_type_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('partner_type_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('partner_type_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('partner_type_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('partner_type_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

    }
}
