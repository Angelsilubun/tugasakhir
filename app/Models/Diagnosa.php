<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;

    protected $table = 'diagnosas';
    protected $guarded = [];

    public function penyakits()
    {
        return $this->belongsTo(Penyakit::class, 'hasil', 'id');
    }

    public function gejalas()
    {
        return $this->belongsTo(Gejala::class, 'gejala_diagnosa', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
