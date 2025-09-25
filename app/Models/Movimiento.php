<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'producto_id',
        'tipo',
        'cantidad',
        'referencia',
        'observaciones',
        'user_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}