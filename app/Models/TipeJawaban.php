<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipeJawaban extends Model
{
    use HasFactory;

    protected $fillable = ['keterangan'];

    public function opsi()
    {
        return $this->hasMany(OpsiJawaban::class);
    }
}
