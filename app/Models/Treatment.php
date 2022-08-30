<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'fees',
        'data',
        'note',
    ];

    public function patient(){
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }

    public function medicines(){
        //withTimestamps give value to timestamps in pivot table (post_tag)
        //withPivot to add additional columns of pivot to $post->tags->first()->pivot->status (additional column)
        //using will be to handle attach detach events
        return $this->belongsToMany(Medicine::class,'prescribed_medicines','treatment_id','medicine_id')
        ->using(PrescribedMedicine::class)
        ->withTimestamps()
        ->withPivot('dosage','days');
    }

    public function laboratorytests(){
        return $this->hasMany(LaboratoryTest::class,'treatment_id','id');
    }
}
