<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SpecialtyRepository;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    protected $specialtyRepository;

    public function __construct(SpecialtyRepository $specialtyRepository)
    {
        $this->specialtyRepository = $specialtyRepository;
    }

    public function index()
    {
        return $this->specialtyRepository->all();
    }
}
