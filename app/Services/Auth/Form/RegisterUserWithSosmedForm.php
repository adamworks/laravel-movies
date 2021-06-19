<?php

namespace App\Services\Auth\Form;

use  App\Foundation\Validation\Form;

class RegisterUserWithSosmedForm extends Form
{
	protected $validationRules = [
		'sosmed' 		=> 'required|in:facebook,google,apple',
        'fb_token' 		=> 'required_if:sosmed,facebook',
        'google_token'  => 'required_if:sosmed,google',
        'apple_token'   => 'required_if:sosmed,apple',
        'name' 			=> 'required_if:sosmed,facebook|required_if:sosmed,google',
		'email'	 		=> 'required|email',
		'password'	 	=> 'required|min:6|confirmed',
		'phone_number'	=> 'required_if:sosmed,facebook|required_if:sosmed,google|numeric',
    ];
}
