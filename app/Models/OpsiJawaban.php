<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpsiJawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe_jawaban_id',
        'nilai',
        'label'
    ];

    public function tipeJawaban()
    {
        return $this->belongsTo(TipeJawaban::class);
    }
}
