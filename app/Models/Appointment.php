<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'time',
        'description',
        'status',
    ];

    public function patient(){
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }
}
