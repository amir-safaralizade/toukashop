<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'phone',
        'name',
        'username',
        'password',
        'email',
        'status',
        'role_id',
        'last_login',
        'last_login_ip',
        'last_login_user_agent',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'last_login' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string>
     */
    protected $dates = [
        'last_login',
        'deleted_at',
    ];

    /**
     * Get the role associated with the admin.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }


    public function mediaFiles()
    {
        return $this->morphMany(MediaFile::class, 'fileable');
    }


    public function firstMedia(string $group)
    {
        return $this->mediaFiles()->where('group', $group)->first();
    }

    public function getProfileImageAttribute()
    {
        return $this->firstMedia('profile_image')
            ? asset($this->firstMedia('profile_image')->path)
            : asset('images/placeholder.jpg');
    }
}
