<?php

namespace App\Services\Auth\Form;

use App\Foundation\Validation\Form;

class LoginUserForm extends Form
{
	protected $validationRules = [
        'phone_number' 		=> 'sometimes|exists:users,phone_number',
        'password' 			=> 'required',
        'username'          => 'sometimes|exists:users,email'
    ];
}