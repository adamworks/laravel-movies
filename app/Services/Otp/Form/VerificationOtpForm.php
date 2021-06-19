<?php

namespace App\Services\Otp\Form;

use App\Foundation\Validation\Form;

class VerificationOtpForm extends Form
{
	protected $validationRules = [
        'phone_number' 		=> 'required|exists:users,phone_number',
        'otp' 				=> 'required',
    ];
}