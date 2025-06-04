<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wine extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'winery', 'variety','vintage','country'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
