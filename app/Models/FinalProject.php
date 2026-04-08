<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalProject extends Model
{
    protected $fillable = [
        'student_name',
        'npm',
        'study_program',
        'title',
        'year',
        'abstract',
        'file_url',
        'category_final_project_id'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryFinalProject::class, 'category_final_project_id');
    }
}
