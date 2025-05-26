<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wine extends Model
{
    protected $fillable = ['name', 'winery', 'variety','vintage','country'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
