<?php

namespace App\Services\Otp;

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\Otp\Notification\OtpNotification;
use App\Services\Otp\Form\VerificationOtpForm;
use App\Services\Otp\Form\ResendOtpForm;
use App\Foundation\Validation\FormValidationException;

class OtpService 
{
    protected $userRepository;

	public function __construct(UserRepository $users)
	{
		$this->userRepository = $users;
	}

	public function sendOtp(User $user)
	{
		$code = rand(1000, 9999);

		$user->otp = $code;

		$this->userRepository->save($user);

		//$user->notify(new OtpNotification);
	}

	public function verification(VerificationOtpForm $form)
	{
		// validating data, if fails it throw an exception
        $data = $form->getValidData();

		$user = $this->userRepository->getByPhoneNumber($data['phone_number']);

		if ($data['otp'] != $user->otp) {
			throw new FormValidationException(['otp' => trans('otp.verificationFail')]);
		}

		$user->otp = null;

		$this->userRepository->save($user);

		return $user;
	}

	public function resend(ResendOtpForm $form)
	{
		// validating data, if fails it throw an exception
        $data = $form->getValidData();

		$user = $this->userRepository->getByPhoneNumber($data['phone_number']);

		$this->sendOtp($user);
	}
}