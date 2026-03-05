<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> a75180779893d6656ed670e232e6ac83b6f2f8f6
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'fichier_path',
=======
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'chemin_fichier',
        'categorie',
>>>>>>> a75180779893d6656ed670e232e6ac83b6f2f8f6
    ];
}
