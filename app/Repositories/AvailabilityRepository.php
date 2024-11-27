<?php

namespace App\Repositories;

use App\Models\Availability;

class AvailabilityRepository
{
    protected $model;

    public function __construct(Availability $availability)
    {
        $this->model = $availability;
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
        return $this->model->findOrFail($id);
    }

    public function findAvailabilityByProfessional($professional_id)
    {
        return $this->model->where('health_professional_id', $professional_id)->paginate(15);
    }

    public function findAvailabilityByDate($date, $healthProfessionalId, $startTime, $endTime)
    {
        return Availability::where('health_professional_id', $healthProfessionalId)->where('date', $date)->where('available_from', '<=', $startTime)->where('available_to', '>=', $endTime)->get();
    }



    public function findOverlappingAvailability($date, $healthProfessionalId, $availableFrom, $availableTo)
    {
        return $this->model
            ->where('date', $date)
            ->where('health_professional_id', $healthProfessionalId)
            ->where(function ($query) use ($availableFrom, $availableTo) {
                $query->where(function ($q) use ($availableFrom, $availableTo) {
                    $q->where('available_from', '<=', $availableTo)->where('available_to', '>=', $availableFrom);
                });
            })
            ->get();
    }

    public static function findAvailableSlot($date, $healthProfessionalId, $start_time, $end_time)
    {
        return Availability::where('date', $date)->where('health_professional_id', $healthProfessionalId)->where('available_from', '<=', $start_time)->where('available_to', '>=', $end_time)->first();
    }

    public static function findAdjacentAvailability($healthProfessionalId, $date, $time, $direction = 'before')
    {
        if ($direction == 'before') {
            return Availability::where('date', $date)->where('health_professional_id', $healthProfessionalId)->where('available_to', '=', $time)->first();
        } else {
            return Availability::where('date', $date)->where('health_professional_id', $healthProfessionalId)->where('available_from', '=', $time)->first();
        }
    }

    public function delete($id)
    {
        $availability = $this->model->findOrFail($id);
        return $availability->delete();
    }

    public function update($id, array $data)
    {
        $availability = $this->model->findOrFail($id);
        $availability->update($data);

        return $availability;
    }
}
