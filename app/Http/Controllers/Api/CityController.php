<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index()
    {
        $cities = DB::table('cities')
            ->select('id', 'city_name')
            ->orderBy('city_name')
            ->get();

        return response()->json([
            'status' => true,
            'cities' => $cities,
        ]);
    }
}