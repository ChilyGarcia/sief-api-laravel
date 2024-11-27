<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'available_from', 'available_to', 'health_professional_id'];

    public function healthProfessional()
    {
        return $this->belongsTo(HealthProfessional::class);
    }
}
