<?php

namespace App\Providers;

use App\Models\CommentNotification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\File;
use App\Models\FileAssociation;
use App\Models\Post;
use App\Models\User;
use Auth;
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

            //additional data for search feature. 
            //files
            $files = File::where('user_id', $userId)->get();
            //results
            $results = FileAssociation::where('user_id', $userId)->get();
            //users
            $users = User::where('id', '!=', $userId)->get();
            //post
            $posts = Post::with('user')->get();


            //for comment notification
            //only get the notification for the current user
            $comment_notifications = DB::table("comment_notifications")->join("users", "comment_notifications.commenter_user_id", "=", "users.id")
                ->where("comment_notifications.post_owner_id", Auth::id())->
                where("comment_notifications.read", false)->select("comment_notifications.post_id", "users.name", "comment_notifications.created_at")->orderBy("comment_notifications.created_at")->get();


            // Share the notifications with the base view
            $view->with(['notifications' => $notifications, 'comment_notifications' => $comment_notifications, 'files' => $files, 'results' => $results, 'posts' => $posts, 'users' => $users]);
        });
    }
}