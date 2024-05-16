<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table="productos";// Tabla de base de datos
    protected $primaryKey = 'id_producto'; // Si el nombre de la clave primaria es diferente de 'id', especifícalo aquí
    protected $fillable=['nombre','precio','cantidad','tipo']; // Sirve para mandar un array para no ir campo a campo
    public $timestamps = false;
}
