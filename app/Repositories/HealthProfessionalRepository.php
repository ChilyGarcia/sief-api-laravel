<?php

namespace App\Repositories;

use App\Models\HealthProfessional;

class HealthProfessionalRepository
{
    protected $model;

    public function __construct(HealthProfessional $healthProfessional)
    {
        $this->model = $healthProfessional;
    }

    public function all()
    {
        return $this->model->paginate(15);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function findProfessionalBySpecialty($specialty_id)
    {
        return $this->model->where('specialty_id', $specialty_id)->paginate(15);
    }

    public function findProfessionalByUser($user_id)
    {
        return $this->model->where('user_id', $user_id)->first();
    }

    public function findUserWithSpecialty($user_id, $specialty_id)
    {
        return $this->model->where('user_id', $user_id)->where('specialty_id', $specialty_id)->first();
    }

    public function findAvailabilityByDateAndProfessional($validate)
    {
        $professional = HealthProfessional::with(['specialty', 'availabilities'])
            ->whereHas('specialty', function ($query) use ($validate) {
                $query->where('id', $validate['specialty_id']);
            })
            ->whereHas('availabilities', function ($query) use ($validate) {
                $query
                    ->whereDate('date', $validate['date'])
                    ->whereTime('available_from', '<=', $validate['start_time'])
                    ->whereTime('available_to', '>=', $validate['end_time']);
            })
            ->get();

        return $professional;
    }
}
