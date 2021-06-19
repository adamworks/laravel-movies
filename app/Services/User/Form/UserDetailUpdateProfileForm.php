<?php

namespace App\Services\User\Form;

use App\Foundation\Validation\Form;

class UserDetailUpdateProfileForm extends Form
{
	protected $validationRules = [
        'user_id' 	=> 'required|exists:users_details,user_id',
        'detail_id'     => 'required|exists:users_details,id',
        'status'        => 'sometimes|required',
        'position'      => 'sometimes|required'
	];
}
