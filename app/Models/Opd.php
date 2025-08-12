<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $fillable = [
        'nama_opd',
        'nama_singkat_opd',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
