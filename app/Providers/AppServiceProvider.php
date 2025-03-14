<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\v1\CommentPolicy;
use App\Policies\v1\PostPolicy;
use App\Policies\v1\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-user', [UserPolicy::class, 'update']);
        Gate::define('delete-user', [UserPolicy::class, 'delete']);
        Gate::define('replace-user', [UserPolicy::class, 'replace']);

        Gate::define('create-post', [PostPolicy::class, 'create']);
        Gate::define('update-post', [PostPolicy::class, 'update']);
        Gate::define('delete-post', [PostPolicy::class, 'delete']);
        Gate::define('replace-post', [PostPolicy::class, 'replace']);

        Gate::define('create-comment', [CommentPolicy::class, 'create']);
        Gate::define('update-comment', [CommentPolicy::class, 'update']);
        Gate::define('delete-comment', [CommentPolicy::class, 'delete']);
    }
}
