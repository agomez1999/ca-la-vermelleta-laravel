<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
	public function store(Request $request)
	{
		$data = $request->all();
		Reservation::insert($data);
	}
}