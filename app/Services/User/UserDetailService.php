<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Repositories\User\UserDetailRepository;
use App\Services\User\Form\UserDetailProfileForm;
use App\Services\User\Form\UserDetailUpdateProfileForm;
use App\Services\User\Form\UserDetailStoreProfileForm;
use App\Foundation\Validation\FormValidationException;

class UserDetailService
{
    /**
     * @var userRepository
     */

    protected $userDetailRepository;
    protected $userRepository;

    /**
     * Userservice Constructor
    *
    * @param UserRepository $userRepository
    */

    public function __construct(
        UserDetailRepository $userDetail,
        UserRepository       $user
    ) {
        $this->userDetailRepository = $userDetail;
        $this->userRepository       = $user;
    }

    public function getDetail(UserDetailProfileForm $form)
    {
        $data = $form->getValidData();
        $user = $this->userDetailRepository->getById($data['detail_id']);

        if (empty($user)) {
			throw new FormValidationException(['userDetail' => trans('userDetail.fail')]);
		}

        return $user;
    }

    public function storeDetail(UserDetailStoreProfileForm $form)
    {
        $data = $form->getValidData();
        $user = $this->userDetailRepository->getNew();
       
        $user->user_id  = $data['user_id'];
        $user->status   = $data['status'];
		$user->position  = $data['position'];
        
        $this->userDetailRepository->save($user);

        return $user;
    }

    public function updateDetail(UserDetailUpdateProfileForm $form)
    {
        $data = $form->getValidData();
        $user = $this->userDetailRepository->getById($data['detail_id']);

        if (empty($user)) {
			throw new FormValidationException(['userDetail' => trans('userDetail.fail')]);
		}

        $user->user_id = $data['user_id'];

        if (isset($data['status'])) {
			$user->status = $data['status'];
		}

        if (isset($data['position'])) {
            $user->position = $data['position'];
        }
        
        $this->userDetailRepository->save($user);

        return $user;
    }

    public function destroyData(UserDetailProfileForm $form)
    {
        $data = $form->getValidData();
        $user = $this->userDetailRepository->getById($data['detail_id']);

        if (empty($user)) {
			throw new FormValidationException(['userDetail' => trans('userDetail.fail')]);
		}

        $this->userDetailRepository->destroy($user);
        $user = $this->userRepository->getById($data['user_id']);
        $user->userDetail;

        return $user; 
    }
}