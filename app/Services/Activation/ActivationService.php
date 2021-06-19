<?php

namespace App\Services\Activation;

use App\Repositories\Activation\ActivationRepository;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Activation;
use App\Services\Activation\Notification\ActivationNotification;

class ActivationService 
{
    protected $activationRepository;

	protected $resendAfter = 1; // hour

	public function __construct(ActivationRepository $activations)
	{
		$this->activationRepository = $activations;
    }

    public function sendMail(User $user)
    {
        //check user data in activations    
    	$activation = $this->activationRepository->getUserActivation($user);

        //if user not should send (because already send) then break
        if (!$this->shouldSend($user, $activation)) {
            return;
        }

        //create user's activations data
        $token = $this->create($user, $activation);

        // Notify to user
        //$user->notify($this->getNotification());
    }

    public function createAndActivate(User $user)
    {
        $activation = $this->activationRepository->getUserActivation($user);

        if (!$this->shouldSend($user, $activation)) {
            return;
        }

        $token = $this->create($user, $activation);

        $this->activate($token);
    }

    public function activate($token)
    {
        $activation = $this->activationRepository->requireByToken($token);

        $activation->completed = true;
        $activation->completed_at = Carbon::now();

        $this->activationRepository->save($activation);
    }

    private function shouldSend(User $user, Activation $activation = null)
    {
        return is_null($activation) || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

    public function create(User $user, Activation $activation = null)
	{
		$activation = $this->activationRepository->getUserActivation($user);

        //if user activation is null then create new one
		if (!$activation) {
            return $this->activationRepository->createToken($user);
        }

        //if already regenerate token
        return $this->activationRepository->regenerateToken($user);
	}

    protected function getNotification()
    {
        return new ActivationNotification;
    }
}