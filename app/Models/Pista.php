<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pista extends Model
{
    use HasFactory;
    protected $table="pistas"; // Tabla de base de datos
    protected $primaryKey = 'id_pista';
    protected $fillable=['estado','pista','fecha','hora_inicio','hora_fin','id_usuario']; // Sirve para mandar un array para no ir

    public $timestamps = false;

    public function clase()
    {
        return $this->hasOne(Clase::class, 'id_pista');
    }

    public function torneo()
    {
        return $this->belongsTo(Torneo::class, 'id_torneo');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }


}
