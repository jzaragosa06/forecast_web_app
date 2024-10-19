<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'profile_photo',
    //     'contact_num',
    // ];
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path ? Storage::disk('public')->url($this->profile_photo_path) : 'path/to/default/photo.jpg';
    }

    public function sharedFiles()
    {
        // Files shared with this user
        return $this->belongsToMany(FileAssociation::class, 'file_user_shares', 'shared_to_user_id', 'file_assoc_id')
            ->withTimestamps();
    }

    public function filesSharedByMe()
    {
        // Files shared by this user
        return $this->hasMany(FileUserShare::class, 'shared_by_user_id');
    }
}