<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Averbacao extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
