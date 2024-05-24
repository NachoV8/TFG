<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table="inscripciones"; // Tabla de base de datos
    protected $primaryKey = 'id_inscripción';
    protected $fillable=['id_usuario','id_torneo']; // Sirve para mandar un array para no ir

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación: Un torneo puede tener varias inscripciones de usuarios
    public function torneo()
    {
        return $this->belongsTo(Torneo::class, 'id_torneo');
    }

}
