<?php

namespace App\Providers;

use App\Policies\SellerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addMinutes(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));

        // To add multiple Scopes
        Passport::tokensCan([
            'purchase-product' => 'Create a new Transaction for a specific product',
            'manage-account' => 'Read your account data such as id,name,emsail,is_verified and is _admin (password is not given). Modify yout account data(email and password). CANNOT DELETE ACCOUNT',
            'manage-product' => 'CRUD for Products',
            'read-general' => 'Read general info like categories,products,purchased products, your transactions'
        ]);
    }
}
