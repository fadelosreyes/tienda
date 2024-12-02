<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'fecha', 'user_id'];

    // Relación con el modelo User (una factura pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class); // Relación de pertenencia a un usuario
    }

    // Relación con el modelo Articulo (muchos artículos pueden estar en una factura)
    public function articulos()
    {
        return $this->belongsToMany(Articulo::class);
    }
}
