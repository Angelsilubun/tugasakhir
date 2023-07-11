<?php

namespace App\Models;

use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rule extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'rules';

    // protected $fillable = [
    //     'id_penyakit',
    //     'id_gejala',
    // ];

    protected $guarded = [];

    // public function gejala()
    // {
    //     return $this->belongsTo(Gejala::class, 'id_gejala');
    // }

    public function penyakit()
    {
        return $this->BelongsTo(Penyakit::class, 'id_penyakit', 'id');
    }
    public function gejalaDiagnosa()
    {
        return $this->BelongsTo(Gejala::class, 'id_gejala', 'id');
    }

    public function gejala()
{
    return $this->hasMany(Gejala::class, 'id', 'daftar_gejala');
}



    // public function ambilGejala($id_penyakit)
    // {
    //     return $this->where("id_penyakit", $id_penyakit)->get();
    // }
}
