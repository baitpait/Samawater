<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class DiagnosisController extends Controller
{
    public function index()
    {
        $data = [
            'invoices_count' => \App\Models\Invoice::count(),
            'clients_count' => \App\Models\Client::count(),
            'subscription_statuses_count' => \App\Models\SubscriptionStatus::count(),
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
        ];
        
        return view('admin.diagnosis', compact('data'));
    }
}
