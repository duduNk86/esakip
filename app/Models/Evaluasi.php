<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'penilaian_opd_id',
        'subkomponen_id',
        'jawaban_opd',
        'url_bukti',
        'nilai_penilai',
        'catatan',
        'saran'
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian_opd::class);
    }

    public function subkomponen()
    {
        return $this->belongsTo(Subkomponen::class);
    }
}
