<?php

namespace App\Models\LandingPage;

use App\Models\User;
use App\Models\Penyakit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LandingPagePostPenyakit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class, 'id_penyakit', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
