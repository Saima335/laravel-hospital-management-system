<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PrescribedMedicine extends Pivot
{
    use HasFactory;
    protected $table='prescribed_medicines';

    protected $fillable = [
        'treatment_id',
        'medicine_id',
        'dosage',
        'days',
    ];
}
