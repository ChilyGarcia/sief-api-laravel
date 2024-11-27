<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = ['health_professional_id', 'patient_id', 'date', 'start_time', 'end_time', 'status'];

    // Relaciones
    public function healthProfessional()
    {
        return $this->belongsTo(HealthProfessional::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class);
    }


}
