<?php

namespace App\Http\Controllers\Api\Professional;

use App\Http\Controllers\Controller;
use App\Repositories\AppointmentRepository;
use Illuminate\Http\Request;

class ProfessionalAppointmentController extends Controller
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function index()
    {
        $user = auth()->guard('api')->user();
        return $this->appointmentRepository->getAppointmentsByProfessional($user->id);
    }
}
