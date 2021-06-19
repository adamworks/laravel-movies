<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\Auth\Form\LoginUserForm;
use App\Services\Auth\Form\LoginUserWithSosmedForm;
use App\Services\Auth\Exception\LoginUserException;
use App\Services\Auth\Exception\SosmedLoginUserException;

class LoginUserService
{
    protected $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
    }

    public function login(LoginUserForm $form)
	{
        // validating data, if fails it throw an exception
		$data = $form->getValidData();

		// auth process
		if (Auth::attempt(['phone_number' => $data['phone_number'], 'password' => $data['password']])) {
		    $user = Auth::User();
		    $this->userStatusChecker($user);

		    // The user is active, not suspended, and exists.
		    return $user;
		} else {
			throw new LoginUserException(['password' => trans('login.wrongCredentials')], trans('login.wrongCredentials'));
		}
	}

    public function loginWithSosmed(LoginUserWithSosmedForm $form)
	{
		// validating data, if fails it throw an exception
        $data               = $form->getValidData();
        $data['is_private'] = false;
        $data['email']      = (!empty($data['email']) ? $data['email'] : null);

		switch ($data['sosmed']) {
			case 'facebook':
				$key  = 'fb_token';
				$user = $this->userRepository->getByFbToken($data[$key]);
				break;
			case 'google':
				$key  = 'google_token';
				$user = $this->userRepository->getByGoogleToken($data[$key]);
                break;
        	default:
				break;
        }

        //check email address in database
        $userByEmail = $this->userRepository->getByEmail($data['email']);

        if (!empty($userByEmail) && empty($user)) {
            $user = $this->updateSosmedToken($userByEmail, $data);
        } else {
            throw new SosmedLoginUserException([$key => trans('login.sosmedTokenNoutFound')], trans('login.sosmedTokenNoutFound'));
        }

		$this->userStatusChecker($user);

	    return $user;
	}

    private function updateSosmedToken(User $user, array $data)
	{
		switch ($data['sosmed']) {
			case 'facebook':
				$key = 'fb_token';
				break;
			case 'google':
				$key = 'google_token';
                break;
			default:
				break;
		}

		$user->$key =  $data[$key];
		$this->userRepository->save($user);

		return $user;
    }

    private function userStatusChecker(User $user)
	{
		if (!is_null($user->otp)) {
			throw new LoginUserException(['phone_number' => $user->phone_number], trans('login.mustOtp'));
	    }
    }
}