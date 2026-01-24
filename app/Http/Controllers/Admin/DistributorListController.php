<?php

namespace App\Http\Controllers\Admin;

use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DistributorListController
{
    public function index(Request $request)
    {
        $query = Distributor::query();

        // البحث
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        // الترتيب
        $sortBy = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Pagination
        $perPage = $request->get('per_page', 25);
        $distributors = $query->paginate($perPage);

        return view('admin.distributors_list', compact('distributors'));
    }
}

