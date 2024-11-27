<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AvailabilityRepository;
use App\Repositories\HealthProfessionalRepository;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    protected $availabilityRepository;
    protected $healthProfessionalRepository;

    public function __construct(AvailabilityRepository $availabilityRepository, HealthProfessionalRepository $healthProfessionalRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
        $this->healthProfessionalRepository = $healthProfessionalRepository;
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'date' => 'required|date',
            'available_from' => 'required|date_format:H:i',
            'available_to' => 'required|date_format:H:i',
        ]);

        $user = auth()->guard('api')->user();

        $userIsProfessional = $this->healthProfessionalRepository->findProfessionalByUser($user->id);

        if (!$userIsProfessional) {
            return response()->json(['error' => 'User is not a health professional'], 400);
        }

        $validate['health_professional_id'] = $userIsProfessional->id;

        $availabilityExists = $this->availabilityRepository->findAvailabilityByDate($validate['date'], $validate['health_professional_id'], $validate['available_from'], $validate['available_to']);

        if ($availabilityExists->count() > 0) {
            // Reemplazar total() con count()
            return response()->json(['message' => 'Availability already exists'], 409);
        }

        $overlappingAvailability = $this->availabilityRepository->findOverlappingAvailability($validate['date'], $validate['health_professional_id'], $validate['available_from'], $validate['available_to']);

        if ($overlappingAvailability->count() > 0) {
            return response()->json(['message' => 'The availability time overlaps with an existing one'], 409);
        }

        $availability = $this->availabilityRepository->create($validate);

        return response()->json(['message' => 'Availability created', 'data' => $availability], 201);
    }

    public function index()
    {
        $availabilities = $this->availabilityRepository->all();

        if ($availabilities->isEmpty()) {
            return response()->json(['message' => 'No availabilities found'], 404);
        }

        return response()->json($availabilities, 200);
    }

    public function getByProfessionDateHour(Request $request)
    {
        $validate = $request->validate([
            'specialty_id' => 'required|integer',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $professionals = $this->healthProfessionalRepository->findAvailabilityByDateAndProfessional($validate);

        if ($professionals->isEmpty()) {
            return response()->json(['message' => 'No availability found with this data'], 404);
        }

        return response()->json($professionals, 200);
    }
}
