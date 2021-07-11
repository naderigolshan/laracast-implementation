<?php

namespace App\Providers;

use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::before(function ($user, $ability) {
//            return $user->hasRole('Super_Admin') ? true : null;
//        });

        Gate::define('manage-thread', function (User $user, Request $request){
            $thread = Thread::find($request->id);
//            dd($thread->user_id .'.......'. $request->id);
            return $thread->user_id == $user->id;
        });

    }
}
