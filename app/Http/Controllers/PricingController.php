<?php

namespace App\Http\Controllers;

use App\Models\Pricing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
  public function index()
  {
    $pricings = Pricing::all();
    return response()->json(["pricings" => $pricings]);
  }

  public function store(Request $request)
  {
    $data = $request->all();
    $start_date = Carbon::parse($data['start_date']);
    $end_date = Carbon::parse($data['end_date']);

    // Suponiendo que tienes una tabla llamada 'pricing' donde se insertarán los registros
    DB::beginTransaction();  // Inicia la transacción

    try {
      $records = [];
      
      while ($start_date <= $end_date) {
        $existingRecord = Pricing::where('date', $start_date->toDateString())->first();

        if ($existingRecord) {
          $existingRecord->delete();
        }

        $records[] = [
            'date' => $start_date->toDateString(),
            'price_per_night' => $data['price_per_night'],
            'season' => $data['season']
        ];

        // Incrementa un día
        $start_date->addDay();
      }

      Pricing::insert($records);

      DB::commit();

      return response()->json(['message' => 'Registros insertados correctamente', 'error' => false], 201);
    } catch (\Exception $e) {
      DB::rollBack();  // Si ocurre un error, revierte la transacción
      return response()->json(['message' => 'Error al insertar los registros', 'error' => true], 500);
    }
  }
}