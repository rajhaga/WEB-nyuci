<?php

namespace App\Providers;
use App\Policies\PesananPolicy;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    // app/Providers/AuthServiceProvider.php

protected $policies = [
    \App\Models\Pesanan::class => \App\Policies\PesananPolicy::class,
];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
