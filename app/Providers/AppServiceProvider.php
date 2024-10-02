<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share notifications with base layout
        View::composer('layouts.base', function ($view) {
            $userId = Auth::id();


            // Fetch unread notifications
            $notifications = DB::table('notifications')
                ->join('users as shared_by_user', 'notifications.shared_by_user_id', '=', 'shared_by_user.id')
                ->join('file_associations', 'notifications.file_assoc_id', '=', 'file_associations.file_assoc_id')
                ->where('notifications.user_id', $userId)
                ->where('notifications.read', false) // Only fetch unread notifications
                ->select(
                    'file_associations.file_assoc_id',
                    'shared_by_user.id as user_id',
                    'file_associations.assoc_filename',
                    'shared_by_user.name as shared_by',
                    'notifications.created_at as notification_time'
                )
                ->orderBy('notifications.created_at', 'desc')
                ->get();

            // Share the notifications with the base view
            $view->with('notifications', $notifications);
        });
    }
}
