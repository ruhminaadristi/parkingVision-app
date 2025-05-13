<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'slot_index',
        'slot_label',
        'vehicle_type',
        'entry_time',
        'exit_time',
        'status'
    ];
    
    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
    ];
    
    /**
     * Hitung durasi parkir dalam menit
     *
     * @return int|null
     */
    public function getDurationInMinutes()
    {
        if (!$this->exit_time) {
            return null;
        }
        
        return $this->entry_time->diffInMinutes($this->exit_time);
    }
    
    /**
     * Format durasi parkir dalam format "Xj Ym"
     *
     * @return string
     */
    public function getFormattedDuration()
    {
        if (!$this->exit_time) {
            return '-';
        }
        
        $minutes = $this->getDurationInMinutes();
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        return "{$hours}j {$remainingMinutes}m";
    }
}
