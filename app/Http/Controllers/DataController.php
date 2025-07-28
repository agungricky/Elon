<?php

namespace App\Http\Controllers;

use App\Models\data;
use App\Models\Index;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = data::with('index')->get();
        return response()->json($data);     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Index::truncate(); 
        // data::truncate();


        if ($request->co2 < 1000) {
            $co2 = "Rendah";
        } else if ($request->co2 >= 1000 && $request->co2 <= 1200) {
            $co2 = "Normal";
        } else if ($request->co2 > 1200) {
            $co2 = "Tinggi";
        }


        $index = Index::create([
            'tanggal' => $request->tanggal,
            'color' => $request->color
        ]);

        data::create([
            'index_id' => $index,
            'location_name' => $request->lokasi,
            'lat' => $request->latitude,
            'lng' => $request->longitude,
            'co2' => $request->co2,
            'hum' => $request->hum,
            'temp' => $request->temp,
            'luminosity' => $request->luminosity,
            'airHumidity' => $request->airHumidity,
            'conductivityValue' => $request->conductivityValue,
            'moistureValue' => $request->moistureValue,
            'nitrogenValue' => $request->nitrogenValue,
            'phValue' => $request->phValue,
            'phosphorusValue' => $request->phosphorusValue,
            'potassiumValue' => $request->potassiumValue,
            'temperatureValue' => $request->temp,
        ]);


        return response()->json($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(data $data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(data $data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, data $data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(data $data)
    {
        //
    }
}
