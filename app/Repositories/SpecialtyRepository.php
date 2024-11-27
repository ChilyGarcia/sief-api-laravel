<?php

namespace App\Repositories;

use App\Models\Specialty;

class SpecialtyRepository
{
    protected $model;

    public function __construct(Specialty $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findByName($specialty)
    {
        return $this->model->where('name', $specialty)->first();
    }
}
