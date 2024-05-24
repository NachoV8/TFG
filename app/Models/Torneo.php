<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    use HasFactory;

    protected $table = 'torneos';
    protected $primaryKey = 'id_torneo'; // Si el nombre de la clave primaria es diferente de 'id', especifícalo aquí

    protected $fillable = [
        'nombre',
        'descripcion',
        'premios',
        'precio',
        'cant_max',
        'hora_inicio',
        'id_pista'
        // Agrega aquí los otros campos que deseas que sean asignables en masa
    ];

    public $timestamps = false;

    public function pistas()
    {
        return $this->belongsToMany(Pista::class, 'torneo_pista', 'id_torneo', 'id_pista');
    }

}
