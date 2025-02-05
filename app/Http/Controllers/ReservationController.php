<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Pricing;
use App\Models\Config;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
	public function getCalendarData()
	{
		$prices = Pricing::all();
		$config = Config::select('minimum_nights')->first();
		$reservations = Reservation::where('status', 'confirmed')->get();

		return response()->json(['prices' => $prices, 'reservations' => $reservations, 'minimum_nights' => $config['minimum_nights']]);
	}

	public function store(Request $request)
	{
		$data = $request->all();
		$reservation = Reservation::create($data);
		
		return response()->json(['reservation' => $reservation, 'error' => false], 201);
	}
}