<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Statistics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatisticController extends Controller
{
    public function index()
    {
        $statistics = Statistics::with(['career', 'academicPeriod'])
            ->get()
            ->makeHidden(['career_id', 'academic_period_id']);

        return response()->json($statistics);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'graduate_students' => 'required',
            'retired_students' => 'required',
            'enrolled_students' => 'required',
            'admited_students' => 'required',
            'career_id' => 'required:exists:careers,id',
            'academic_period_id' => 'required:exists:academic_periods,id',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $statisticsExists = Statistics::where('career_id', $request->career_id)
            ->where('academic_period_id', $request->academic_period_id)
            ->first();

        if ($statisticsExists) {
            return response()->json(['message' => 'This statistics already exists'], 400);
        }

        $newData = Statistics::create($request->all());

        return response()->json($newData, 201);
    }
}
