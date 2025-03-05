<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Pricing;
use App\Models\Config;
use App\Models\Availability;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
	public function getCalendarData()
	{
		$config = Config::select('minimum_nights')->first();
		$prices = Pricing::all();
		$reservations = Reservation::where('status', 'confirmed')->get();
		$not_available = Availability::where('is_available', '0')->get();

		return response()->json(['prices' => $prices, 'reservations' => $reservations, 'not_available' => $not_available, 'minimum_nights' => $config['minimum_nights']]);
	}

	public function store(Request $request)
	{
		$data = $request->all();
		$reservation = Reservation::create($data);
		
		return response()->json(['reservation' => $reservation, 'error' => false], 201);
	}

	public function insertOrDelete(Request $request)
	{
		$data = $request->all();
		
		if (strcmp($data['availability'], 'available') == 0) { // Delete
      
		} else if (strcmp($data['availability'], 'not-available') == 0) { // Insert
      $insert_data = array(
        "name" => "not-available",
        "start_date" => $data['start_date'],
        "end_date" => $data['end_date'],
        "num_people" => 0,
        "status" => "confirmed",
        "type" => "not-available"
      );

      $reservation = Reservation::create($insert_data);
		}
	}
}