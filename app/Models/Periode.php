<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = [
        'tahun',
        'keterangan',
        'tgl_start',
        'tgl_end',
    ];

    public function penilaianOpd()
    {
        return $this->hasMany(Penilaian_opd::class, 'periode_id', 'id');
    }
}
