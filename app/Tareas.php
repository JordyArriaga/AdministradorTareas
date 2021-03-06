<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tareas extends Model{
	use SoftDeletes;
    protected $fillable = [
    	"id",
    	"idUser",
    	"Nombre",
    	"Descripcion",
    	"Estado",
    ];
}
