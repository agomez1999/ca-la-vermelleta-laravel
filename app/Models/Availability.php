<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'is_available',
    ];

    // Verificación de disponibilidad para un rango de fechas
    public function isAvailableBetween($start_date, $end_date)
    {
        return $this->whereBetween('date', [$start_date, $end_date])->where('is_available', true)->count() == $end_date->diffInDays($start_date) + 1;
    }
}
