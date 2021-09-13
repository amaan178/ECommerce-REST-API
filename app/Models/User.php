<?php

namespace App\Models;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Transformers\UserTrasformer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;
    const ADMIN_USER = 1;
    const REGULAR_USER = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public string $transformer = UserTrasformer::class;
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'admin',
        'verification_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function(User $user) {
            retry(5, function () use($user){
                Mail::to($user)->send(new UserCreated($user));
            }, 100);
        });

        self::updated(function (User $user) {
            if($user->isDirty('email')) {
                retry(5, function () use($user){
                    Mail::to($user)->send(new UserMailChanged($user));
                },500);
            }
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVerified()
    {
        return $this->verified == self::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->admin == self::ADMIN_USER;
    }

    public static function generateVerificationCode()
    {
        return Str::random(40);
    }

    public function getNameAttribute()
    {
        return ucwords($this->attributes['name']);
    }

    /* Mutators */
    public function setNameAttribute(string $name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setEmailAttribute(string $email)
    {
        $this->attributes['email'] = strtolower($email);
    }
}
