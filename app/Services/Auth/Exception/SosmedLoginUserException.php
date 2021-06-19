<?php

namespace App\Services\Auth\Exception;

class SosmedLoginUserException extends \Exception
{
	protected $errors = [];
    protected $codeMessage;
    protected $data;

	public function __construct($errors, $codeMessage = '',$data='')
	{
		parent::__construct('Not found', 404);

		$this->errors = $errors;
        $this->codeMessage = $codeMessage;
        $this->data = $data;
	}

	public function getErrors()
	{
		return $this->errors; //$this->data;
	}

	public function getResponse()
	{
		$content = [
            'code' => 404,
            'code_message' => $this->codeMessage,
            'code_type' => 'notFound',
            'data' => $this->getErrors(),
        ];

		return response($content, $status = 404);
	}
}
