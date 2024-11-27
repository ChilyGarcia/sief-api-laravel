<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function updateRoleById(int $id, string $role)
    {
        return $this->model->where('id', $id)->update(['role' => $role]);
    }
}
