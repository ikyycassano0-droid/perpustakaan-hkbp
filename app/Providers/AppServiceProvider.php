<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Config;

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
        // FIX MAIL SSL (Brevo STARTTLS issue Windows)
        config([
            'mail.mailers.smtp.stream' => [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ],
        ]);

        // Notification logic (tetap)
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $unread = \App\Models\Notification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->count();

                $view->with('unreadNotif', $unread);
            }
        });
    }
}