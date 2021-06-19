<?php

namespace App\Services\Auth\Form;

use App\Foundation\Validation\Form;

class RegisterUserForm extends Form
{
	protected $validationRules = [
        'name' 			=> 'required',
		'email'	 		=> 'required|email|unique:users,email',
		'password'	 	=> 'required|min:6|confirmed',
		'phone_number'	=> 'required|numeric|unique:users,phone_number',
    ];
}
