<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use Illuminate\Support\Facades\Hash;

class DistributorController extends Controller
{
    public function index()
    {
        return response()->json(Distributor::orderBy('id', 'desc')->get());
    }

    public function show($id)
    {
        $distributor = Distributor::find($id);
        if (!$distributor) {
            return response()->json(['message' => 'الموزع غير موجود'], 404);
        }
        return response()->json($distributor);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:distributors',
            'username' => 'required|unique:distributors',
            'password' => 'required|min:6',
        ]);

        $distributor = Distributor::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'username' => $request->username,
            'password_hash' => Hash::make($request->password),
            'status' => $request->status ?? 1,
            'notes' => $request->notes ?? '',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم إضافة الموزع بنجاح',
            'distributor' => $distributor,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $distributor = Distributor::find($id);
        if (!$distributor) {
            return response()->json(['message' => 'الموزع غير موجود'], 404);
        }

        $distributor->update($request->only(['name', 'phone', 'username', 'status', 'notes']));

        if ($request->filled('password')) {
            $distributor->update(['password_hash' => Hash::make($request->password)]);
        }

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث بيانات الموزع',
            'distributor' => $distributor,
        ]);
    }

    public function destroy($id)
    {
        $distributor = Distributor::find($id);
        if (!$distributor) {
            return response()->json(['message' => 'الموزع غير موجود'], 404);
        }

        $distributor->delete();
        return response()->json(['message' => 'تم حذف الموزع بنجاح']);
    }
    
    public function updateLocation(Request $request)
{
    $driver = Distributor::find($request->id);

    if (!$driver)
        return response()->json(['status' => false, 'message' => 'Driver not found']);

    $driver->update([
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'last_update' => now(),
    ]);

    return response()->json(['status' => true]);
}
}