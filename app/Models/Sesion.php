<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $table="sesiones"; // Tabla de base de datos
    protected $primaryKey = 'id_sesion';
    protected $fillable=['estado','pista','fecha','hora_inicio','hora_fin','id_usuario']; // Sirve para mandar un array para no ir

    public $timestamps = false;
}
