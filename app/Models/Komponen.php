<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Komponen extends Model
{
    use HasFactory;

    protected $fillable = ['aspek_id', 'kode', 'keterangan', 'bobot'];

    public function aspek()
    {
        return $this->belongsTo(Aspek::class);
    }

    public function subkomponen()
    {
        return $this->hasMany(Subkomponen::class);
    }
}
