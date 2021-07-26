<?php

namespace App\Http\Controllers;

use App\Foundation\Validation\FormValidationException;
use Illuminate\Http\Request;
use App\Services\Auth\RegisterUserService;
use App\Services\Auth\LoginUserService;

use App\Services\Auth\Form\RegisterUserForm;
use App\Services\Auth\Form\RegisterUserWithSosmedForm;
use App\Services\Auth\Form\LoginUserForm;
use App\Services\Auth\Form\LoginUserWithSosmedForm;
use App\Services\Auth\Exception\LoginUserException;
use App\Services\Auth\Exception\SosmedLoginUserException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $registerUserService;
    protected $loginUserService;

    public function __construct(
        RegisterUserService $registerUserService,
        LoginUserService $loginUserService
    ) {
        $this->registerUserService = $registerUserService;
        $this->loginUserService    = $loginUserService;
    }


    public function register(Request $request)
    {
        $data = $request->all();
        $form = new RegisterUserForm($data);
        
        try {
            $user = $this->registerUserService->register($form);

            return successResponse(trans('register.success'), $user);
        
        } catch(FormValidationException $exception){
            return $exception->getResponse(trans('register.validationFail'));
            
        }
    }

    public function registerSosmed(Request $request)
    {
        $data   = $request->all();
        
        switch($data['sosmed']){
            case 'facebook':
                $pwd    = substr($data['fb_token'],0,8);
                break;
            case 'google':
                $pwd    = substr($data['google_token'],0,8);
                break;
            default:
                break;
        }

        $data['password']               = $pwd;
        $data['password_confirmation']  = $pwd;
        
        $form = new RegisterUserWithSosmedForm($data);

        try { 
            $s = $this->registerUserService->registerWithSosmed($form);

            if ($s['code'] == 200) {
                $user = $s['user'];

                return successResponse(trans('register.successWithSosmed'),
                    [
                        "authorization" => $user->api_basic_auth_token,
                        "user" => $user
                    ]
                );
            }

            $content = [
                "code" => $s['code'],
                "code_message" => $data['sosmed']=='apple' ? trans('register.successWithSosmed') : trans('register.success'),
                "code_type" => "success",
                "data" => $s['user']
            ];

            return response($content, $s['code']);

        } catch (FormValidationException $exception) {

            return $exception->getResponse(trans('register.validationFail'));

        }
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $form = new LoginUserForm($data);
        
        try {
            $user = $this->loginUserService->login($form);

            return successResponse(trans('login.success'),
                [
                    "authorization" => $user->api_basic_auth_token,
                    "user" => $user
                ]
            );

        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        } catch (LoginUserException $exception) {
            return $exception->getResponse();
        }

    }

    public function loginWithSosmed(Request $request)
    {
        $data = $request->all();
        $form = new LoginUserWithSosmedForm($data);

        try {
            $user = $this->loginUserService->loginWithSosmed($form);

            return successResponse(trans('login.success'),
                [
                    "authorization" => $user->api_basic_auth_token,
                    "user" => $user
                ]
            );
        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        } catch (SosmedLoginUserException $exception) {
            return $exception->getResponse();
        } catch (LoginUserException $exception) {
            return $exception->getResponse();
        }

    }

    public function loginWeb()
    {
        if (Auth::check()){
            return redirect()->route('movie.index');
        } else {
            return view('auth.login');
        }
    }

    public function loginWebAuth(Request $request)
    {
        $data = $request->all();
        $data['type'] = 'web';
        $form = new LoginUserForm($data);
        
        try {
            $this->loginUserService->login($form);
            
            return redirect()->route('movie.index');

        } catch (FormValidationException $exception) {
            return $exception->getResponse();
        } catch (LoginUserException $exception) {
            return $exception->getResponse();
        }
    }

    public function logout()
    {
        Auth::logout(); 
        return redirect()->route('movie.index');
    }
}
