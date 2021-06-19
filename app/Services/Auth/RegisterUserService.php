<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Activation\ActivationService;
use App\Services\Otp\OtpService;
use App\Repositories\Activation\ActivationRepository;
use App\Repositories\User\UserRepository;

use App\Services\Auth\Form\RegisterUserForm;
use App\Services\Auth\Form\RegisterUserWithSosmedForm;
use App\Foundation\Validation\FormValidationException;


class RegisterUserService
{
    /**
     * @var userRepository
     */
    protected $otpService;
    protected $activationService;
    protected $activationRepository;
    protected $userRepository;

     /**
      * Userservice Constructor
      *
      */

    public function __construct(
      OtpService            $otpService,
      ActivationService     $activationService,
      UserRepository        $userRepository,
      ActivationRepository  $activationRepository
    ) {
        $this->otpService           = $otpService;
        $this->activationService    = $activationService;
        $this->userRepository       = $userRepository;
        $this->activationRepository = $activationRepository;
    }

    public function register(RegisterUserForm $form)
    {
       
      $data = $form->getValidData();
      $user = $this->registerValidUserData($data);
      
      $this->activationService->sendMail($user);
      $this->otpService->sendOtp($user);

      return $user;
    }

    public function registerWithSosmed(RegisterUserWithSosmedForm $form)
	  {
      $data               = $form->getValidData(); // perform validation
      $userByEmail        = $this->userRepository->getByEmail($data['email']);
      $userByPhoneNumber  = $this->userRepository->getByPhoneNumber($data['phone_number']);
      $userByPhoneNumberAndEmail = $this->userRepository->getByPhoneNumberAndEmail($data['phone_number'], $data['email']);
      
      // if user phone and email is already store than update only sosmed token
      if (!empty($userByPhoneNumberAndEmail)) { 
          return ['user' => $this->updateSosmedToken($userByPhoneNumberAndEmail, $data), 'code' => 200];
      }

      // if user email & phone already store but different data with customer than throw error response
      if (!empty($userByEmail) && !empty($userByPhoneNumber)) {
          if ($userByEmail->id != $userByPhoneNumber->id) { 
              throw new FormValidationException(['phone_number' => trans('register.phoneNumberExists')]);
          }
      }

      // if email alreadry store but number is different than update with new number
      if (!empty($userByEmail) && empty($userByPhoneNumber)) {
          if ($userByEmail->phone_number != $data['phone_number']) { 
              $user = $this->updatePhoneNumber($userByEmail, $data);
              $this->otpService->sendOtp($user);
              
              return ['user' => $user, 'code' => 201];
          }
      }

      // if phone already store but email is different than throw error phone number already exists
      if (empty($userByEmail) && !empty($userByPhoneNumber)) { 
          throw new FormValidationException(['phone_number' => trans('register.phoneNumberExists')]);
      }

      return ['user' => $this->registerWithoutEmailVerification($data), 'code' => 201];
    }

    private function registerValidUserData(array $data)
	  {

      $user               = $this->userRepository->getNew();
      $user->name         = !empty($data['name']) ? ucwords($data['name']) : $data['email'] ;
      $user->email        = $data['email'];
      $user->password     = bcrypt($data['password']);
      $user->phone_number = !empty($data['phone_number']) ? $data['phone_number'] : null;
      $user->api_token    = substr(md5(date('dmYhis')), -50);
      
      if (isset($data['sosmed'])) {
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

        $user->$key = $data[$key];
      }

      $this->userRepository->save($user);

      return $user;
    }

    public function registerWithoutEmailVerification(array $data)
    {
          $user = $this->registerValidUserData($data);

          $this->activationService->createAndActivate($user);

          if($data['sosmed']!="apple") {
              $this->otpService->sendOtp($user);
          }

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

      $user->$key = $data[$key] ;

      $this->userRepository->save($user);

      return $user;
	  }

    private function updatePhoneNumber(User $user, array $data)
    {
      $user->phone_number = $data['phone_number'];
      $this->userRepository->save($user);

      return $user;
    }
}