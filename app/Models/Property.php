<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $table = 'properties';
    protected $primaryKey = 'ins_municipal';
    protected $fillable = [
        'ins_municipal',
        'tipo',
        'area_terreno',
        'area_edificacao',
        'logradouro',
        'numero',
        'bairro',
        'complemento',
        'contribuinte_id',
        'situacao',
    ];

    public function contribuinte()
    {
        return $this->belongsTo(Person::class, 'contribuinte_id'); 
    }
}

