<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;
    
    protected $table = 'peserta';
    
    protected $fillable = [
        'name',
        'email',
        'jabatan',
        'departemen'
    ];
    
    public function formOtherAstras()
    {
        return $this->hasMany(FormOtherAstra::class, 'name_id');
    }
    
    public function ratedBy()
    {
        return $this->hasMany(FormOtherAstra::class, 'rater_for_id');
    }
}
