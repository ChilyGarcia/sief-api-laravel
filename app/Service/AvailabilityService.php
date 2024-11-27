<?php

namespace App\Service;

use App\Repositories\AvailabilityRepository;
use Carbon\Carbon;

class AvailabilityService
{
    protected $availabilityRepository;

    public function __construct(AvailabilityRepository $availabilityRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
    }

    public function adjustAvailability($healthProfessionalId, $date, $startTime, $endTime)
    {
        $availability = $this->availabilityRepository->findAvailabilityByDate($date, $healthProfessionalId, $startTime, $endTime);

        if ($availability->isNotEmpty()) {
            $availabilityItem = $availability->first();
            $availableFrom = Carbon::parse($availabilityItem->available_from);
            $availableTo = Carbon::parse($availabilityItem->available_to);

            if ($availableFrom->equalTo(Carbon::parse($startTime)) && $availableTo->equalTo(Carbon::parse($endTime))) {
                $this->availabilityRepository->delete($availabilityItem->id);
            } elseif ($availableFrom->equalTo(Carbon::parse($startTime))) {
                $this->availabilityRepository->update($availabilityItem->id, [
                    'available_from' => $endTime,
                ]);
            } elseif ($availableTo->equalTo(Carbon::parse($endTime))) {
                $this->availabilityRepository->update($availabilityItem->id, [
                    'available_to' => $startTime,
                ]);
            } else {
                $this->availabilityRepository->update($availabilityItem->id, [
                    'available_to' => $startTime,
                ]);

                $this->availabilityRepository->create([
                    'date' => $date,
                    'available_from' => $endTime,
                    'available_to' => $availabilityItem->available_to,
                    'health_professional_id' => $healthProfessionalId,
                ]);
            }
        }
    }

    public function restoreAvailability($appointment)
    {
        $availabilityBefore = $this->availabilityRepository->findAdjacentAvailability($appointment->health_professional_id, $appointment->date, $appointment->start_time, 'before');

        $availabilityAfter = $this->availabilityRepository->findAdjacentAvailability($appointment->health_professional_id, $appointment->date, $appointment->end_time, 'after');

        if ($availabilityBefore && $availabilityAfter) {
            $this->availabilityRepository->update($availabilityBefore->id, [
                'available_to' => $availabilityAfter->available_to,
            ]);
            $this->availabilityRepository->delete($availabilityAfter->id);
        } elseif ($availabilityBefore) {
            $this->availabilityRepository->update($availabilityBefore->id, [
                'available_to' => $appointment->end_time,
            ]);
        } elseif ($availabilityAfter) {
            $this->availabilityRepository->update($availabilityAfter->id, [
                'available_from' => $appointment->start_time,
            ]);
        } else {
            $this->availabilityRepository->create([
                'date' => $appointment->date,
                'available_from' => $appointment->start_time,
                'available_to' => $appointment->end_time,
                'health_professional_id' => $appointment->health_professional_id,
            ]);
        }
    }
}
