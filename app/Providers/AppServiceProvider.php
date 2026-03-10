<?php

namespace App\Providers;

use App\Models\Chat\Chat;
use App\Models\Chat\ChatParticipant;
use App\Models\Chat\Message;
use App\Policies\Chat\ChatPolicy;
use App\Policies\ChatParticipant\ChatParticipantPolicy;
use App\Policies\Message\MessagePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(ChatParticipant::class, ChatParticipantPolicy::class);
        Gate::policy(Chat::class, ChatPolicy::class);
        Gate::policy(Message::class, MessagePolicy::class);
    }
}
