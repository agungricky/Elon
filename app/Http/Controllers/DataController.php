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
        // Fuzzyfication
        // $fuzzy_nilai = max(0, min(1, ($x - batas_bawah) / rentang));
        // rentang di cari menggunakan rumus batas atas - batas bawah

        $co2 = max(0, min(1, ($co2_value - 1000) / 200));
        $hum = max(0, min(1, ($hum_value - 60) / 20));
        $temp = max(0, min(1, ($temp_value - 20) / 10));

        // Nilai Pembobotan
        // Sangat Penting 0.5
        // Penting 0.3
        // Tidak penting 0.2

        $pembobotan = ($temp * 0.5) + ($hum * 0.4) + ($co2 * 0.1);
        $hasil = round($pembobotan, 2);

        // dari terendah ke tertinggi seperti suhu ac, semakin rendah semakin dingin (Hujan)
        if ($hasil < 0.3) {
            $cuaca = 0;      // hujan
        } elseif ($hasil < 0.6) {
            $cuaca = 1;     // berawan
        } else {
            $cuaca = 2;      // cerah
        }

        return $cuaca;
    }


    public function cahaya($luminosity_value)
    {
        $luminosity = max(0, min(1, ($luminosity_value - 1000) / 3000));

        $hasil = number_format($luminosity, 2);
        if ($hasil < 0.3) {
            $cuaca = 0;      // mendung
        } elseif ($hasil < 0.6) {
            $cuaca = 1;     // berawan
        } else {
            $cuaca = 2;      // terik
        }
        return $cuaca;
    }

    public function tanah($conductivity_value, $moisture_value, $nitrogen_value, $ph_value, $phosphorus_value, $potassium_value, $temperature_value)
    {
        $conductivity = max(0, min(1, ($conductivity_value - 0.1) / 0.9));
        $moisture = max(0, min(1, ($moisture_value - 20) / 60));
        $nitrogen = max(0, min(1, ($nitrogen_value - 0.1) / 0.65));
        $ph = max(0, min(1, ($ph_value - 4.5) / 4));
        $phosphorus = max(0, min(1, ($phosphorus_value - 4) / 11));
        $potassium = max(0, min(1, ($potassium_value - 0.1) / 0.9));
        $temperature = max(0, min(1, ($temperature_value - 20) / 10));


        $pembobotan = ($temperature * 0.30) +  ($moisture * 0.25) + ($conductivity * 0.15) + ($ph * 0.10) + ($nitrogen * 0.08) + ($phosphorus * 0.06) + ($potassium * 0.06);
        $hasil = round($pembobotan, 2);

        if ($hasil < 0.3) {
            $cuaca = 0;      // Basah
        } elseif ($hasil < 0.6) {
            $cuaca = 1;     // Lembab
        } else {
            $cuaca = 2;      // Kering
        }

        return $cuaca;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // --- Pakai nilai matang ---
        $udara = $this->udara($request->co2, $request->hum, $request->temp);
        $cahaya = $this->cahaya($request->luminosity);
        $tanah = $this->tanah(
            $request->conductivityValue,
            $request->moistureValue,
            $request->nitrogenValue,
            $request->phValue,
            $request->phosphorusValue,
            $request->potassiumValue,
            $request->temp
        );

        // 0 => 'Hujan', mendung, Basah,
        // 1 => 'Berawan', berawan, Lembab,
        // 2 => 'Cerah', terik, Kering,

        $Prediksicuaca = [
            000 => ['Dingin', 'Mendung', 'Basah', '🌧️ Hujan'],
            001 => ['Dingin', 'Mendung', 'Lembab', '🌧️ Hujan'],
            002 => ['Dingin', 'Mendung', 'Kering', '🌦️ Hujan ringan'],
            010 => ['Dingin', 'Berawan', 'Basah', '🌧️ Hujan'],
            011 => ['Dingin', 'Berawan', 'Lembab', '🌦️ Hujan ringan'],
            012 => ['Dingin', 'Berawan', 'Kering', '🌥️ Berawan cenderung hujan'],
            020 => ['Dingin', 'Cerah', 'Basah', '🌦️ Hujan ringan'],
            021 => ['Dingin', 'Cerah', 'Lembab', '🌤️ Cerah lembab'],
            022 => ['Dingin', 'Cerah', 'Kering', '🌤️ Cerah cenderung hujan'],
            100 => ['Normal', 'Mendung', 'Basah', '🌧️ Hujan'],
            101 => ['Normal', 'Mendung', 'Lembab', '🌦️ Hujan ringan'],
            102 => ['Normal', 'Mendung', 'Kering', '🌥️ Mendung'],
            110 => ['Normal', 'Berawan', 'Basah', '🌦️ Hujan ringan'],
            111 => ['Normal', 'Berawan', 'Lembab', '🌥️ Berawan'],
            112 => ['Normal', 'Berawan', 'Kering', '⛅ Berawan ringan'],
            120 => ['Normal', 'Cerah', 'Basah', '🌤️ Cerah lembab'],
            121 => ['Normal', 'Cerah', 'Lembab', '🌤️ Cerah lembab'],
            122 => ['Normal', 'Cerah', 'Kering', '🌤️ Cerah'],
            200 => ['Panas', 'Mendung', 'Basah', '🌦️ Hujan ringan'],
            201 => ['Panas', 'Mendung', 'Lembab', '🌥️ Mendung lembab'],
            202 => ['Panas', 'Mendung', 'Kering', '🌥️ Mendung'],
            210 => ['Panas', 'Berawan', 'Basah', '🌤️ Cerah lembab'],
            211 => ['Panas', 'Berawan', 'Lembab', '🌤️ Cerah lembab'],
            212 => ['Panas', 'Berawan', 'Kering', '🌤️ Cerah'],
            220 => ['Panas', 'Cerah', 'Basah', '☀️ Cerah lembab'],
            221 => ['Panas', 'Cerah', 'Lembab', '☀️ Cerah lembab'],
            222 => ['Panas', 'Cerah', 'Kering', '☀️ Panas Terik'],
        ];

        $kesimpulanIndex = $udara . $cahaya . $tanah;

        $kesimpulan = [];
        foreach ($Prediksicuaca as $key => $value) {
            if ($key == $kesimpulanIndex) {
                $kesimpulan[$key] = $value;
                break;
            }
        }

        $firstKey = array_key_first($kesimpulan); 

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
            'udara' => $kesimpulan[$firstKey][0],
            'cahaya' => $kesimpulan[$firstKey][1],
            'tanah' => $kesimpulan[$firstKey][2],
            'kesimpulan' => $kesimpulan[$firstKey][3],
        ]);

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
