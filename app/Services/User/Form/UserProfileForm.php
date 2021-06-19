<?php

namespace App\Services\User\Form;

use App\Foundation\Validation\Form;

class UserProfileForm extends Form
{
	protected $validationRules = [
        'user_id' 		=> 'required|exists:users_details,id',
	];
}
