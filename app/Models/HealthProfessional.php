<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProfessional extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialty_id', 'description'];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
}
