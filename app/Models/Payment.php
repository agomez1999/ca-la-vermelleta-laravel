<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'amount',
        'payment_date',
        'method',
        'status',
    ];

    // Relación con Reservation (1 a 1 inversa)
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
