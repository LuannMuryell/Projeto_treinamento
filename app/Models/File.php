<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class File extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'files';
    protected $fillable = [
        'file_ins_municipal',
        'file_name',
        'file_path',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'file_ins_municipal', 'ins_municipal');
    }
}
