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
        'gap_status',
        'gap_percentage'
    ];
    
    public function reviewedAssessments()
    {
        return $this->hasMany(FormOtherAstra::class, 'reviewee_id');
    }
    
    public function reviewerAssessments()
    {
        return $this->hasMany(FormOtherAstra::class, 'reviewer_id');
    }
}
