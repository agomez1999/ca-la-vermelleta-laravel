<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'dni',
        'start_date',
        'end_date',
        'num_people',
        'status',
    ];

    // Relación con Payment (1 a 1)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Método para verificar disponibilidad para la reserva
    public function isAvailable()
    {
        $dates = \App\Models\Availability::whereBetween('date', [$this->start_date, $this->end_date])
                    ->where('is_available', true)
                    ->count();

        return $dates == ($this->end_date->diffInDays($this->start_date) + 1); // Compara días de la reserva con días disponibles
    }
}

