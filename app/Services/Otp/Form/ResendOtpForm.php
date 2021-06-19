<?php

namespace App\Services\Otp\Form;

use App\Foundation\Validation\Form;

class ResendOtpForm extends Form
{
	protected $validationRules = [
        'phone_number' 		=> 'required|exists:users,phone_number',
    ];
}