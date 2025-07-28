<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $table = 'indexdata';
    protected $fillable = [
        'id', 
        'tanggal',
        'color',
        'created_at',
        'updated_at',
    ];

    public function data(){
        return $this->hasMany(Data::class, 'index_id', 'id');
    }
}
