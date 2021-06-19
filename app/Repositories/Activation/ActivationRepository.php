<?php

namespace  App\Repositories\Activation;

use App\Models\Activation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ActivationRepository
{
    /**
     * @var user
     */

    protected $model;

    public function __construct(Activation $activation)
    {
        $this->model = $activation;
    }

    public function getNew($attributes = [])
    {
        return $this->model->newInstance($attributes);
    }

    public function requireByToken($token)
	{
		return $this->model->where('code', $token)->where('completed', false)->firstOrFail();
	}

    public function getUserActivation(User $user)
    {
        return $this->model->where('user_id', $user->id)->first();
    }

    public function getByToken($token)
        {
        return $this->model->where('code', $token)->first();
    }

	protected function getToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    public function createToken(User $user)
    {
        $token = $this->getToken();

        $this->model->insert([
            'user_id'       => $user->id,
            'code'          => $token,
            'created_at'    => new Carbon()
        ]);

        return $token;
    }

    public function regenerateToken(User $user)
    {
        $token = $this->getToken();

        $this->model->where('user_id', $user->id)->update([
            'code'          => $token,
            'created_at'    => new Carbon()
        ]);

        return $token;
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