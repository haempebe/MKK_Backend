<?php

namespace App\Models;

use App\Models\Film;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;
    protected $table = 'genres';
    protected $fillable = ['nama_genre'];

    public function film()
    {
        return $this->hasMany(Film::class);
    }
}
