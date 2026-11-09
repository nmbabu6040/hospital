<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = ['job_posting_id', 'applicant_name', 'email', 'phone', 'cv_file', 'cover_letter', 'status'];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}