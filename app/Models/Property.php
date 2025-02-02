<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Property extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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

    public function files()
    {
        return $this->hasMany(File::class,'file_ins_municipal', 'ins_municipal');
    }
    public function averbacoes()
    {
        return $this->hasMany(Averbacao::class, 'property_id', 'ins_municipal');
    }
}

