<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;


    protected $table="reservas"; // Tabla de base de datos
    protected $primaryKey = 'id_reserva';
    protected $fillable = ['id_usuario', 'id_producto', 'cantidad'];

    public $timestamps = false;


    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
