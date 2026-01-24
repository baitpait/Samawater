<?php

// app/Http/Controllers/Api/DriverLocationController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Events\DriverLocationUpdated;

class DriverLocationController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $loc = Distributor::updateOrCreate(
            ['id' => $request->id],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'last_update' => now(),
            ]
        );

        // بث للايف
        broadcast(new DriverLocationUpdated($loc))->toOthers();

        return response()->json(['ok' => true]);
    }

    public function index()
    {
        return Distributor::all();
    }
}