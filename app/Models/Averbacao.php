<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Averbacao extends Model
{
    use HasFactory;

    protected $table = 'averbacoes';
    protected $fillable = [
        'evento',
        'medida',
        'descricao',
        'data_averbacao',
        'property_id'
    ];
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'ins_municipal'); 
    }
}
