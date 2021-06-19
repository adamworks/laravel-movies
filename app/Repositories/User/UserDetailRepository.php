<?php

namespace  App\Repositories\User;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Model;

class UserDetailRepository
{
    /**
     * @var user
     */

    protected $model;

    public function __construct(UserDetail $user)
    {
        $this->model = $user;
    }

    public function getNew($attributes = [])
    {
        return $this->model->newInstance($attributes);
    }

    public function getById($id)
    {
        return $this->model->find($id)->first();
    }

    public function destroy($model)
    {
        return $model->delete();
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