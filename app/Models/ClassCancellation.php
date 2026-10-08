<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassCancellation extends Model
{
    protected $fillable = ['class_routine_id', 'cancelled_date'];

    // Add this relationship method
    public function routine()
    {
        return $this->belongsTo(ClassRoutine::class, 'class_routine_id');
    }
}