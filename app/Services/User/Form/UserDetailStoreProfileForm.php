<?php

namespace App\Services\User\Form;

use App\Foundation\Validation\Form;

class UserDetailStoreProfileForm extends Form
{
	protected $validationRules = [
        'user_id' 	=> 'required|exists:users_details,user_id',
        'status'        => 'required',
        'position'      => 'required'
	];
}
