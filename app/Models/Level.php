<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';
    protected $primaryKey = 'id_level';

    protected $fillable = [
        'nama_level'
    ];

    public function pointRules()
    {
        return $this->hasMany(PointRules::class, 'id_level');
    }
}
