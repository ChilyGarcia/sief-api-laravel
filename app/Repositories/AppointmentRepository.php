<?php

namespace App\Repositories;

use App\Models\Appointment;

class AppointmentRepository
{
    protected $model;

    public function __construct(Appointment $model)
    {
        $this->model = $model;
    }

    public function all($user)
    {
        return $this->model->where('patient_id', $user)->with('healthProfessional.specialty', 'healthProfessional.user')->get();
    }

    public function getAppointmentsByProfessional($professionalId)
    {
        return $this->model->where('health_professional_id', $professionalId)
            ->whereNotIn('status', ['canceled', 'completed'])
            ->with('patient')
            ->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}
