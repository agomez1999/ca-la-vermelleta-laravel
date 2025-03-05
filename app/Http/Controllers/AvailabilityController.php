<?php

namespace App\Http\Controllers;

use App\Models\Availability;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
  public function store(Request $request)
  {
    $data = $request->validate([
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
      'availability' => 'required|in:available,not-available',
    ]);

    $startDate = Carbon::parse($data['start_date']);
    $endDate = Carbon::parse($data['end_date']);

    // Generamos el rango de fechas
    $dates = [];
    while ($startDate->lte($endDate)) {
      $dates[] = $startDate->copy()->toDateString();
      $startDate->addDay();
    }

    if ($data['availability'] === 'not-available') {
      // Insertar solo si la fecha no existe
      foreach ($dates as $date) {
        Availability::firstOrCreate(['date' => $date], ['is_available' => false]);
      }
    } else {
      // Si la disponibilidad es 'available', eliminamos los registros
      Availability::whereIn('date', $dates)->delete();
    }

    return response()->json(['message' => 'Disponibilidad actualizada'], 200);
  }
}
