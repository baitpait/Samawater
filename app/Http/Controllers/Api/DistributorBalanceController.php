<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DistributorBalance;

class DistributorBalanceController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => DistributorBalance::all()
        ]);
    }

    public function show($id)
    {
        $balance = DistributorBalance::where('distributor_id', $id)->first();

        if (!$balance) {
            return response()->json([
                'status' => false,
                'message' => 'Distributor not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $balance
        ]);
    }
}