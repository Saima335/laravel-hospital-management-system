<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    public function treatments(){
        //withTimestamps give value to timestamps in pivot table (post_tag)
        //withPivot to add additional columns of pivot to $post->tags->first()->pivot->status (additional column)
        //using will be to handle attach detach events
        return $this->belongsToMany(Treatment::class,'prescribed_medicines','medicine_id','treatment_id')
        ->using(PrescribedMedicine::class)
        ->withTimestamps()
        ->withPivot('dosage','days');
    }
}
