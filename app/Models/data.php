<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    protected $table = 'data';
    protected $fillable = [
        'id',
        'index_id',
        'location_name',
        'lat',
        'lng',
        // Tanah
        'co2',
        'hum',
        'temp',
        // cahaya
        'luminosity',
        // Udara
        'airHumidity',
        'conductivityValue',
        'moistureValue',
        'nitrogenValue',
        'phValue',
        'phosphorusValue',
        'potassiumValue',
        'temperatureValue',
        'udara',
        'cahaya',
        'tanah',
        'kesimpulan',
        'created_at',
        'updated_at',
    ];

    public function index(){
        return $this->belongsTo(Index::class, 'index_id', 'id');
    
    }
}
