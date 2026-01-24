<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\CashWithdraw;

class DistributorWithdrawController extends Controller
{
    public function index($id)
    {
        $distributor = Distributor::findOrFail($id);

        $withdraws = CashWithdraw::where('distributor_id', $id)
            ->latest()
            ->get();

        return view('distributors.withdraws', compact('distributor', 'withdraws'));
    }
}