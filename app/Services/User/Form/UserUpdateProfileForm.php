<?php

namespace App\Services\User\Form;

use App\Foundation\Validation\Form;

class UserUpdateProfileForm extends Form
{
	protected $validationRules = [
                'user_id'       => 'required|exists:users_details,id',
                'name'          => 'sometimes|required'
	];
}
