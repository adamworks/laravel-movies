<?php

namespace App\Services\User\Form;

use App\Foundation\Validation\Form;

class UserDetailProfileForm extends Form
{
	protected $validationRules = [
        'user_id' 	=> 'required|exists:users_details,user_id',
        'detail_id'     => 'required|exists:users_details,id'
	];
}
