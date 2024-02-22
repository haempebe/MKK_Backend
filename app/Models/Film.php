<?php

namespace App\Models;

use App\Models\User;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Film extends Model
{
    use HasFactory;
    protected $table = 'films';
    protected $fillable = ['user_id','genre_id','judul','deskripsi','cover'];
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
