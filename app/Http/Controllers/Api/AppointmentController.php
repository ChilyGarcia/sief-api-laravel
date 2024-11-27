<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AppointmentRepository;
use App\Repositories\AvailabilityRepository;
use App\Service\AvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    const STATUS_CANCELLED = 'canceled';

    protected $appointmentRepository;
    protected $availabilityRepository;
    protected $availabilityService;

    public function __construct(AppointmentRepository $appointmentRepository, AvailabilityRepository $availability, AvailabilityService $availabilityService)
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->availabilityRepository = $availability;
        $this->availabilityService = $availabilityService;
    }

    public function index()
    {
        $user = auth()->guard('api')->user();
        return $this->appointmentRepository->all($user->id);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'health_professional_id' => 'required|exists:health_professionals,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient = auth()->guard('api')->user();

        $data = $validator->validated();
        $data['patient_id'] = $patient->id;
        $data['status'] = 'scheduled';

        $availability = $this->availabilityRepository->findAvailabilityByDate($request->date, $request->health_professional_id, $request->start_time, $request->end_time);

        if ($availability->isEmpty()) {
            return response()->json(['message' => 'No availability found for the selected date and time'], 404);
        }

        $this->appointmentRepository->create($data);

        $this->availabilityService->adjustAvailability($request->health_professional_id, $request->date, $request->start_time, $request->end_time);

        return response()->json(['message' => 'Appointment created successfully'], 201);
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = $this->appointmentRepository->find($appointmentId);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        if ($appointment->status == self::STATUS_CANCELLED) {
            return response()->json(['message' => 'Appointment already cancelled'], 400);
        }

        $appointment->update(['status' => self::STATUS_CANCELLED]);

        $this->availabilityService->restoreAvailability($appointment);

        return response()->json(['message' => 'Appointment cancelled'], 200);
    }
}
