<?php

namespace  App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    /**
     * @var user
     */

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getNew($attributes = [])
    {
        return $this->model->newInstance($attributes);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getByEmail($email)
	{
		return $this->model->where('email', $email)->first();
	}

    public function getByFbToken($fbToken)
    {
        return $this->model->where('fb_token', $fbToken)->first();
    }

    public function getByGoogleToken($googleToken)
    {
        return $this->model->where('google_token', $googleToken)->first();
    }

    public function getByUserName($username)
    {
        return $this->model->where('username', $username)->first();
    }

    public function getByPhoneNumber($phoneNumber)
    {
        return $this->model->where('phone_number', $phoneNumber)->first();
    }

    public function requiredById($id)
    {
        return $this->model->findOrFail($id)->first();
    }

    public function getByPhoneNumberAndEmail($phoneNumber, $email)
    {
        return $this->model->where('phone_number', $phoneNumber)->where('email', $email)->first();
    }

    public function save($data)
    {
        if ($data instanceOf Model) {
            return $this->storeEloquentModel($data);
        } elseif (is_array($data)) {
            return $this->storeArray($data);
        }
    }

    protected function storeEloquentModel($model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    protected function storeArray($data)
    {
        $model = $this->getNew($data);
        
        return $this->storeEloquentModel($model);
    }
}