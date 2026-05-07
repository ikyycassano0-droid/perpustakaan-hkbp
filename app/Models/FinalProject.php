<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // pastikan ini import

class FinalProject extends Model
{
    protected $fillable = [
    'user_id', // 🔥 WAJIB
    'student_name',
    'npm',
    'study_program',
    'title',
    'year',
    'abstract',
    'file_url',
    'category_final_project_id',
    'first_supervisor_id',
    'second_supervisor_id',
    'status' // 🔥 WAJIB
];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(CategoryFinalProject::class, 'category_final_project_id');
    }

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Supervisor pertama
    public function firstSupervisor()
    {
        return $this->belongsTo(User::class, 'first_supervisor_id');
    }

    // Supervisor kedua (opsional)
    public function secondSupervisor()
    {
        return $this->belongsTo(User::class, 'second_supervisor_id');
    }
}
