<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;


//    use Likeable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function degreePosts()
    {
        return $this->hasMany(DegreePost::class);
    }


    public function parties()
    {
        return $this->hasMany(Party::class);
    }

    public function degree(){
        return $this->belongsToMany(Degree::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'following', 'followed_id', 'follower_id'
        )->withTimestamps();
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'following', 'follower_id', 'followed_id')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function degreeComments()
    {
        return $this->hasMany(DegreeComment::class);
    }

    public function partyComments()
    {
        return $this->hasMany(PartyComment::class);
    }

    public function eventComments()
    {
        return $this->hasMany(EventComment::class);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    public function partyInvites(){
        return $this->hasMany(PartyInvite::class);
    }
}
