<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table  = 'users_details';

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
	{
		return $this->belongsTo(User::class);
	}
}
