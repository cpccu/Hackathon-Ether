<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['event_category_id', 'title', 'banner', 'date_time', 'location', 'description', 'tags', 'custom_fields'];

    protected $casts = ['custom_fields' => 'array'];

    
    public function category() { return $this->belongsTo(EventCategory::class, 'event_category_id'); }
    public function registrations() { return $this->hasMany(EventRegistration::class); }
}
