<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Otp\OtpService;
use App\Services\Otp\Form\verificationOtpForm;
use App\Services\Otp\Form\ResendOtpForm;
use App\Foundation\Validation\FormValidationException;

class OtpController extends Controller
{
    protected $otpService;

    public function __construct(Otpservice $otpService)
    {
        $this->otpService = $otpService;
    }

    public function verification(Request $request)
    {
        $data = $request->all();
        $form = new VerificationOtpForm($data);

        try {
            $user = $this->otpService->verification($form);

            return successResponse(trans('otp.verified'), [
                "authorization" => $user->api_basic_auth_token,
                "user"          => $user
            ]);
        } catch (FormValidationException $exception) {
            return $exception->getResponse(trans('otp.verificationFail'));
        }
    }

    public function resend(Request $request)
    {
        $data = $request->all();
        $form = new ResendOtpForm($data);

        try {
            $otp = $this->otpService->resend($form);

            return successResponse(trans('otp.resent'), $otp);
        } catch (FormValidationException $exception) {
            return $exception->getResponse(trans('otp.resendFail'));
        }
    }
}
