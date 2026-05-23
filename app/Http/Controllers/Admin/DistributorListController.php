<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Distributor;
use Illuminate\Http\Request;

/**
 * Business Purpose: عرض قائمة الموزعين بواجهة مخصصة مع بحث وترتيب آمن.
 */
class DistributorListController
{
    private const SORTABLE_COLUMNS = [
        'id',
        'name',
        'phone',
        'balance',
    ];

    /**
     * Business Purpose: جلب قائمة الموزعين مع دعم البحث والترتيب والـ pagination.
     */
    public function index(Request $request)
    {
        $query = Distributor::query();

        // البحث
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        // الترتيب
        $sortBy = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'desc');
        $sortBy = in_array($sortBy, self::SORTABLE_COLUMNS, true) ? $sortBy : 'id';
        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDir);

        // Pagination
        $perPage = $request->get('per_page', 50);
        $distributors = $query->paginate($perPage);

        return view('admin.distributors_list', compact('distributors'));
    }
}

