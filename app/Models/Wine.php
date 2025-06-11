<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'variety',
        'vintage',
        'alcohol',
        'price',
        'color',
        'aroma',
        'sweetness',
        'acidity',
        'tannin',
        'body',
        'persistence',
        'score',
        'tasted_day'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTastedDayAttribute($value)
    {
        // Si ya viene en formato Y-m-d, lo dejamos como está
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            $this->attributes['tasted_day'] = $value;
            return;
        }

        // Si viene en formato d-m-Y, lo convertimos
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
            $date = \DateTime::createFromFormat('d-m-Y', $value);
            $this->attributes['tasted_day'] = $date ? $date->format('Y-m-d') : null;
            return;
        }

        // Si viene en otro formato no reconocido, lo dejamos como null (o podés lanzar una excepción si preferís)
        $this->attributes['tasted_day'] = null;
    }

}
