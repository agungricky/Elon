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

    public function udara($co2_value, $hum_value, $temp_value)
    {
        // | Kategori | Skor Normalisasi |
        // | -------- | ---------------- |
        // | Rendah   | 0.0              |
        // | Normal   | 0.5              |
        // | Tinggi   | 1.0              |

        // CO2
        if ($co2_value < 1000) {
            $co2 = 0.0;
        } else if ($co2_value >= 1000 && $co2_value <= 1200) {
            $co2 = 0.5;
        } else if ($co2_value > 1200) {
            $co2 = 1.0;
        }

        // Hum
        if ($hum_value < 60) {
            $hum = 0.0;
        } else if ($hum_value >= 60 && $hum_value <= 80) {
            $hum = 0.5;
        } else if ($hum_value > 80) {
            $hum = 1.0;
        }

        if ($temp_value < 20) {
            $temp = 0.0;
        } else if ($temp_value >= 20 && $temp_value <= 30) {
            $temp = 0.5;
        } else if ($temp_value > 30) {
            $temp = 1.0;
        }

        // Nilai Pembobotan
        // Sangat Penting 0.5
        // Penting 0.3
        // Tidak penting 0.2

        // | CO2    | Humidity | Temp   | Kesimpulan Fuzzy                |
        // | ------ | -------- | ------ | ------------------------------- |
        // | Rendah | Normal   | Sejuk  | Udara Baik & Nyaman             |
        // | Tinggi | Normal   | Sejuk  | Udara Kurang Sehat (CO2 Tinggi) |
        // | Normal | Tinggi   | Panas  | Udara Lembap & Panas            |
        // | Tinggi | Tinggi   | Panas  | Udara Buruk & Panas             |
        // | Rendah | Rendah   | Dingin | Udara Kering & Dingin           |
        // | Normal | Normal   | Normal | Udara Normal                    |
        // | Tinggi | Rendah   | Dingin | Udara Buruk & Kering            |

        $pembobotan = ($co2 * 0.5) + ($temp * 0.3) + ($hum * 0.2);
        $hasil = number_format($pembobotan, 2);
        return $hasil;
    }


    public function cahaya($luminosity_value)
    {
        if ($luminosity_value < 1000) {
            $luminosity = 0.0;
        } else if ($luminosity_value >= 1000 && $luminosity_value <= 4000) {
            $luminosity = 0.5;
        } else if ($luminosity_value > 4000) {
            $luminosity = 1.0;
        }

        $pembobotan = $luminosity;
        $hasil = number_format($pembobotan, 2);
        return $hasil;
    }

    public function tanah($conductivity_value, $moisture_value, $nitrogen_value, $ph_value, $phosphorus_value, $potassium_value, $temperature_value)
    {
        if ($conductivity_value < 0.1) {
            $conductivity = 0.0;
        } else if ($conductivity_value >= 0.1 && $conductivity_value <= 1.0) {
            $conductivity = 0.5;
        } else if ($conductivity_value > 1.0) {
            $conductivity = 1.0;
        }

        // | Kategori      | Skor Normalisasi |
        // | ------------- | ---------------- |
        // | Sangat Rendah | 0.0              |
        // | Rendah        | 0.25             |
        // | Normal        | 0.5              |
        // | Tinggi        | 0.75             |
        // | Sangat Tinggi | 1.0              |

        if ($moisture_value < 20) {
            $moisture = 0.0;
        } else if ($moisture_value >= 20 && $moisture_value <= 40) {
            $moisture = 0.25;
        } else if ($moisture_value >= 41 && $moisture_value <= 60) {
            $moisture = 0.5;
        } else if ($moisture_value >= 61 && $moisture_value <= 80) {
            $moisture = 0.75;
        } else if ($moisture_value >= 81) {
            $moisture = 1.0;
        }

        if ($nitrogen_value < 0.1) {
            $nitrogen = 0.0;
        } else if ($nitrogen_value >= 0.1 && $nitrogen_value <= 0.2) {
            $nitrogen = 0.25;
        } else if ($nitrogen_value > 0.2 && $nitrogen_value <= 0.5) {
            $nitrogen = 0.5;
        } else if ($nitrogen_value > 0.5 && $nitrogen_value <= 0.75) {
            $nitrogen = 0.75;
        } else if ($nitrogen_value > 0.75) {
            $nitrogen = 1.0;
        }

        // | Kategori      | Skor Normalisasi |
        // | ------------- | ---------------- |
        // | Sangat Rendah | 0.0              |
        // | Rendah        | 0.166            |
        // | Cukup Rendah  | 0.333            |
        // | Normal        | 0.5              |
        // | Cukup Tinggi  | 0.666            |
        // | Tinggi        | 0.833            |
        // | Sangat Tinggi | 1.0              |

        if ($ph_value < 4.5) {
            $ph = 0.0;
        } else if ($ph_value >= 4.5 && $ph_value <= 5.5) {
            $ph = 0.166;
        } else if ($ph_value >= 5.5 && $ph_value <= 6.5) {
            $ph = 0.333;
        } else if ($ph_value >= 6.6 && $ph_value <= 7.5) {
            $ph = 0.5;
        } else if ($ph_value >= 7.6 && $ph_value <= 8.5) {
            $ph = 0.833;
        } else if ($ph_value > 8.5) {
            $ph = 1.0;
        }

        if ($phosphorus_value <= 4) {
            $phosphorus = 0.0;
        } else if ($phosphorus_value >= 5 && $phosphorus_value <= 7) {
            $phosphorus = 0.25;
        } else if ($phosphorus_value >= 8 && $phosphorus_value <= 10) {
            $phosphorus = 0.5;
        } else if ($phosphorus_value >= 11 && $phosphorus_value <= 15) {
            $phosphorus = 0.75;
        } else if ($phosphorus_value > 15) {
            $phosphorus = 1.0;
        }

        if ($potassium_value < 0.1) {
            $potassium = 0.0;
        } else if ($potassium_value >= 0.1 && $potassium_value <= 0.3) {
            $potassium = 0.25;
        } else if ($potassium_value >= 0.4 && $potassium_value <= 0.5) {
            $potassium = 0.5;
        } else if ($potassium_value >= 0.6 && $potassium_value <= 1.0) {
            $potassium = 0.75;
        } else if ($potassium_value > 1.0) {
            $potassium = 1.0;
        }

        // | Kategori | Skor Normalisasi |
        // | -------- | ---------------- |
        // | Rendah   | 0.0              |
        // | Normal   | 0.5              |
        // | Tinggi   | 1.0              |

        if ($temperature_value < 20) {
            $temperature = 0.0;
        } else if ($temperature_value >= 20 && $temperature_value <= 30) {
            $temperature = 0.5;
        } else if ($temperature_value > 30) {
            $temperature = 1.0;
        }

        $pembobotan = ($moisture * 0.20) + ($nitrogen * 0.20) + ($conductivity * 0.15) + ($ph * 0.15) + ($temperature * 0.10) +
            ($phosphorus * 0.10) + ($potassium * 0.10);
        $hasil = number_format($pembobotan, 2);
        return $hasil;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // --- Pakai nilai matang ---
        // $udara = $this->udara($request->co2, $request->hum, $request->temp);
        // $cahaya = $this->cahaya($request->luminosity);
        // $tanah = $this->tanah(
        //     $request->conductivityValue,
        //     $request->moistureValue,
        //     $request->nitrogenValue,
        //     $request->phValue,
        //     $request->phosphorusValue,
        //     $request->potassiumValue,
        //     $request->temp
        // );

        $tanggal = Index::where('tanggal', $request->tanggal)->first();

        if ($tanggal == null) {
            $tanggal = Index::create([
                'tanggal' => $request->tanggal,
                'color' => $request->color
            ]);
        }



        data::create([
            'index_id' => $tanggal->id,
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
            'kesimpulan' => null,
        ]);


        // return response()->json(
        //     [
        //         'message' => 'Data berhasil disimpan',
        //         'status' => 'success',
        //     ],
        //     201
        // );

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'status' => 'success',
        ], 201);
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
    public function destroy(data $data) {}

    public function reset()
    {
        Index::truncate();
        data::truncate();

        return redirect()->back()->with('success', 'Data berhasil direset');
    }
}
