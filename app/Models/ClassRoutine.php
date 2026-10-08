<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoutine extends Model
{
   protected $fillable = [
    'batch_no',
    'day',
    'course_title',
    'course_code',
    'course_teacher',
    'room',
    'class_time',
    'is_cancelled',
   ];

   public function cancellations()
{
    return $this->hasMany(ClassCancellation::class);
}

// Helper to check if cancelled on a specific date
public function isCancelledOn($date)
{
    return $this->cancellations()->where('cancelled_date', $date)->exists();
}

}
