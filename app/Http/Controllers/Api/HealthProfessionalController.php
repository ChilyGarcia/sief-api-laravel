<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\HealthProfessionalRepository;
use App\Repositories\SpecialtyRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class HealthProfessionalController extends Controller
{
    protected $healthProfessionalRepository;
    protected $userRepository;
    protected $specialtyRepository;

    public function __construct(HealthProfessionalRepository $healthProfessionalRepository, UserRepository $userRepository, SpecialtyRepository $specialtyRepository)
    {
        $this->healthProfessionalRepository = $healthProfessionalRepository;
        $this->userRepository = $userRepository;
        $this->specialtyRepository = $specialtyRepository;
    }

    public function index(Request $request)
    {
        $healthProfessionals = $this->healthProfessionalRepository->all($request->user()->id);

        if ($healthProfessionals->isEmpty()) {
            return response()->json(['message' => 'No health professionals found'], 404);
        }

        return response()->json($healthProfessionals, 200);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'description' => 'required|string',
        ]);

        $user = auth()->guard('api')->user();

        $validate['user_id'] = $user->id;

        $existingRecord = $this->healthProfessionalRepository->findUserWithSpecialty($validate['user_id'], $validate['specialty_id']);

        if ($existingRecord) {
            return response()->json(['message' => 'Specialty already exists, you cannot have two records of the same specialty'], 409);
        }

        $this->userRepository->updateRoleById($user->id, 'professional');

        $healthProfessional = $this->healthProfessionalRepository->create($validate);

        return response()->json($healthProfessional, 201);
    }

    public function findProfessionalBySpecialty($specialty)
    {
        $specialty = $this->specialtyRepository->findByName($specialty);

        $healthProfessionals = $this->healthProfessionalRepository->findProfessionalBySpecialty($specialty->id);

        if ($healthProfessionals->isEmpty()) {
            return response()->json(['message' => 'No health professionals found'], 404);
        }

        return response()->json($healthProfessionals, 200);
    }
}
