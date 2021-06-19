<?php

namespace App\Services\Auth\Exception;

class LoginUserException extends \Exception
{
	protected $errors = [];
	protected $codeMessage;

	public function __construct($errors, $codeMessage = '')
	{
		parent::__construct('Invalid form', 400);

		$this->errors = $errors;
		$this->codeMessage = $codeMessage;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function getResponse()
	{
		$content = [
            'code' => 400,
            'code_message' => $this->codeMessage,
            'code_type' => 'badRequest',
            'data' => $this->getErrors(),
        ];

		return response($content, $status = 400);
	}
}

