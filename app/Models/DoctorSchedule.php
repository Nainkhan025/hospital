<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorSchedule extends Model
{
    protected $fillable = [
        'doctor_profile_id',
        'day_of_week',
        'specific_date',
        'start_time',
        'end_time',
        'slot_duration_minutes',
        'is_available',
    ];

    protected $casts = [
        'specific_date'         => 'date',
        'is_available'          => 'boolean',
        'slot_duration_minutes' => 'integer',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_profile_id');
    }

    /**
     * Get day label for display.
     */
    public function getDayLabelAttribute(): string
    {
        if ($this->specific_date) {
            return $this->specific_date->format('D, M j Y');
        }

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return $days[$this->day_of_week] ?? 'Unknown';
    }
}
