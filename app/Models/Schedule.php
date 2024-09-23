<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;


    protected $fillable = [
        'starts_at',
        'ends_at',
        'monday_starts_at',
        'monday_ends_at',
        'tuesday_starts_at',
        'tuesday_ends_at',
        'wednesday_starts_at',
        'wednesday_ends_at',
        'thursday_starts_at',
        'thursday_ends_at',
        'friday_starts_at',
        'friday_ends_at',
        'saturday_starts_at',
        'saturday_ends_at',
        'sunday_starts_at',
        'sunday_ends_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];
    

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getWorkingHoursForDate(Carbon $date)
    {
        $hours = array_filter([
            $this->{strtolower($date->format('l')) . '_starts_at'},
            $this->{strtolower($date->format('l')) . '_ends_at'},
        ]);

        return empty($hours) ? null : $hours;
    }
}
