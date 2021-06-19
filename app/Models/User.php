<?php

namespace App\Models;

use App\Models\UserDetail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id', 'password', 'remember_token', 'api_token', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get API Token.
     *
     * @return void
     */
    public function getApiBasicAuthTokenAttribute()
    {
        return "Basic ".base64_encode($this->id.":".$this->api_token);
    }

    public function userDetail()
    {
        return $this->hasMany(UserDetail::class,'user_id');
    }
}
