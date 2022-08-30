<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatment_id',
        'name',
        'date',
        'amount',
    ];

    public function treatment(){
        return $this->belongsTo(Treatment::class,'treatment_id','id');
    }

    public function laboratoryreport(){
        return $this->hasOne(LaboratoryReport::class,'test_id','id');
    }   
}
