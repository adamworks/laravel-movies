<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Services\User\Form\UserProfileForm;
use App\Services\User\Form\UserUpdateProfileForm;

use App\Foundation\Validation\FormValidationException;

class UserService
{
    /**
     * @var userRepository
     */

    protected $userRepository;

    /**
     * Userservice Constructor
    *
    * @param UserRepository $userRepository
    */

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getById(UserProfileForm $form)
    {
        $data = $form->getValidData();
        $user = $this->userRepository->getById($data['user_id']);

        if (empty($user)) {
			throw new FormValidationException(['user' => trans('user.fail')]);
		}

        $user->userDetail;

        return $user;
    }

    public function updateData(UserUpdateProfileForm $form)
    {
        $data = $form->getValidData();
        $user = $this->userRepository->getById($data['user_id']);
        
        if (empty($user)) {
			throw new FormValidationException(['user' => trans('user.fail')]);
		}
        
        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        $this->userRepository->save($user);
        
        return $user;
    }
      
}