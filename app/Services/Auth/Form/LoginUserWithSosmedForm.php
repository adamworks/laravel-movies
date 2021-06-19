<?php

namespace App\Services\Auth\Form;

use App\Foundation\Validation\Form;

class LoginUserWithSosmedForm extends Form
{
	protected $validationRules = [
        'sosmed' 		=> 'required|in:facebook,google,apple',
        'fb_token' 		=> 'required_if:sosmed,facebook',
        'google_token'  => 'required_if:sosmed,google'
    ];
}
