<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian_opd extends Model
{
    use HasFactory;

    protected $table = 'penilaian_opds';
    protected $fillable = [
        'periode_id',
        'opd_id',
        'user_id',
        'penilai_id',
        'status',
        'tgl_submit_opd',
        'pm_a1_s',
        'pm_a1_n',
        'pm_a2_s',
        'pm_a2_n',
        'pm_a3_s',
        'pm_a3_n',
        'pm_a_skor',
        'pm_a_nilai',
        'pm_b1_s',
        'pm_b1_n',
        'pm_b2_s',
        'pm_b2_n',
        'pm_b3_s',
        'pm_b3_n',
        'pm_b_skor',
        'pm_b_nilai',
        'pm_c1_s',
        'pm_c1_n',
        'pm_c2_s',
        'pm_c2_n',
        'pm_c3_s',
        'pm_c3_n',
        'pm_c_skor',
        'pm_c_nilai',
        'pm_d1_s',
        'pm_d1_n',
        'pm_d2_s',
        'pm_d2_n',
        'pm_d3_s',
        'pm_d3_n',
        'pm_d_skor',
        'pm_d_nilai',
        'ev_a1_s',
        'ev_a1_n',
        'ev_a2_s',
        'ev_a2_n',
        'ev_a3_s',
        'ev_a3_n',
        'ev_a_skor',
        'ev_a_nilai',
        'ev_b1_s',
        'ev_b1_n',
        'ev_b2_s',
        'ev_b2_n',
        'ev_b3_s',
        'ev_b3_n',
        'ev_b_skor',
        'ev_b_nilai',
        'ev_c1_s',
        'ev_c1_n',
        'ev_c2_s',
        'ev_c2_n',
        'ev_c3_s',
        'ev_c3_n',
        'ev_c_skor',
        'ev_c_nilai',
        'ev_d1_s',
        'ev_d1_n',
        'ev_d2_s',
        'ev_d2_n',
        'ev_d3_s',
        'ev_d3_n',
        'ev_d_skor',
        'ev_d_nilai',
        'skor_by_opd',
        'nilai_by_opd',
        'skor_by_penilai',
        'nilai_by_penilai',
        'predikat',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }

    // public function evaluasi()
    // {
    //     return $this->hasMany(Evaluasi::class, 'penilaian_opd_id', 'id');
    // }
}
