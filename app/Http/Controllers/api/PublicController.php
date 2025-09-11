<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function getCities(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
        ]);

        $cities = City::where('province_id', $request->province_id)
            ->select('id', 'name')
            ->get()
            ->map(function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name,
                ];
            });

        return response()->json($cities, 200);
    }
}
