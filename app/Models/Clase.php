<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table="clases"; // Tabla de base de datos
    protected $primaryKey = 'id_clase';
    protected $fillable = [
        'id_profesor',
        'id_pista',
        'id_alumno',
        'descripcion',
        'precio',
        'fecha',
        'hora_inicio'
    ];

    public $timestamps = false;

    public function pista()
    {
        return $this->belongsTo(Pista::class, 'id_pista');
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'id_alumno');
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'id_profesor');
    }


}
