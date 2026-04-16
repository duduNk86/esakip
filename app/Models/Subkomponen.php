<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subkomponen extends Model
{
    use HasFactory;

    protected $fillable = ['komponen_id', 'kode', 'tipe_jawaban_id', 'pertanyaan', 'nilai_subkomponen_max', 'keterangan', 'url_contoh'];

    public function komponen()
    {
        return $this->belongsTo(Komponen::class);
    }

    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class);
    }

    public function tipeJawaban()
    {
        return $this->belongsTo(TipeJawaban::class);
    }

}
