<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'description',
        'date',
        'result',
    ];

    public function laboratorytest(){
        return $this->belongsTo(LaboratoryTest::class,'test_id','id');
    }
}
