<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'cpf'
    ];

    public function telefones()
    {
        return $this->hasMany(Telefone::class, 'agenda_id');
    }
}
