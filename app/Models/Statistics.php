<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    //

    protected $fillable = [
        'graduate_students',
        'retired_students',
        'enrolled_students',
        'admited_students',
        'career_id',
        'academic_period_id'

    ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }
}
