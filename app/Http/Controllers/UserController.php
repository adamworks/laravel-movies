<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Services\User\UserDetailService;

use App\Services\User\Form\UserProfileForm;
use App\Services\User\Form\UserUpdateProfileForm;
use App\Services\User\Form\UserDetailProfileForm;
use App\Services\User\Form\UserDetailUpdateProfileForm;
use App\Services\User\Form\UserDetailStoreProfileForm;
use App\Foundation\Validation\FormValidationException;

class UserController extends Controller
{
    protected $userService;
    protected $userDetailService;

    public function __construct(
        UserService       $user,
        UserDetailService $userDetail
    ){
        $this->userService      = $user;
        $this->userDetailService= $userDetail;
    }

    public function view(Request $request)
    {
        $data               = $request->all();
        $data['user_id']    = $request->user_id_from_header;

        $form = new UserProfileForm($data);

        try {
            $user = $this->userService->getById($form);

            return successResponse(trans('user.view'),$user);
        
        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        }
    }

    public function update(Request $request)
    {
        $data               = $request->all();
        $data['user_id']    = $request->user_id_from_header;

        $form = new UserUpdateProfileForm($data);

        try {
            $user = $this->userService->updateData($form);

            return successResponse(trans('user.updated'),$user);
        
        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        }
    }


    /**
     * Detail Method
     */

    public function detailView(Request $request,$detail_id)
    {
        $data               = $request->all();
        $data['detail_id']  = $detail_id;
        $data['user_id']    = $request->user_id_from_header;

        $form = new UserDetailProfileForm($data);

        try {
            $user = $this->userDetailService->getDetail($form);

            return successResponse(trans('userDetail.view'),$user);
        
        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        }
    }

    public function detailStore(Request $request)
    {
        $data               = $request->all();
        $data['user_id']    = $request->user_id_from_header;

        $form = new UserDetailStoreProfileForm($data);

        try {
            $user = $this->userDetailService->storeDetail($form);

            return successResponse(trans('userDetail.created'),$user);
        
        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        }
    }
    
    public function detailUpdate(Request $request,$detail_id)
    {
        $data               = $request->all();
        $data['detail_id']  = $detail_id;
        $data['user_id']    = $request->user_id_from_header;

        $form = new UserDetailUpdateProfileForm($data);

        try {
            $user = $this->userDetailService->updateDetail($form);

            return successResponse(trans('userDetail.updated'),$user);
        
        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        }
    }

    public function detailDestroy(Request $request,$detail_id)
    {
        $data               = $request->all();
        $data['detail_id']  = $detail_id;
        $data['user_id']    = $request->user_id_from_header;

        $form = new UserDetailProfileForm($data);

        try {
            $user = $this->userDetailService->destroyData($form);

            return successResponse(trans('userDetail.deleted'),$user);
        
        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        }
    }
}
