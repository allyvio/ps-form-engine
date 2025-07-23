<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormOtherAstra extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'form_id',
        'name',
        'name_id',
        'rater_for',
        'rater_for_id',
        'departemen',
        'fungsi',
        'peran',
        'question_1_value',
        'question_1_text',
        'question_2_value',
        'question_2_text',
        'question_3_value',
        'question_3_text',
        'question_4_value',
        'question_4_text',
        'question_5_value',
        'question_5_text',
        'question_6_value',
        'question_6_text',
        'question_7_value',
        'question_7_text',
        'question_8_value',
        'question_8_text',
        'question_9_value',
        'question_9_text',
        'question_10_value',
        'question_10_text',
        'question_11_value',
        'question_11_text',
        'question_12_value',
        'question_12_text',
        'question_13_value',
        'question_13_text',
        'question_14_value',
        'question_14_text',
        'question_15_value',
        'question_15_text',
        'date_created'
    ];
    
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'name_id');
    }
    
    public function rater()
    {
        return $this->belongsTo(Peserta::class, 'rater_for_id');
    }
}
