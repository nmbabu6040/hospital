<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'md_name', 'md_designation', 'md_image', 'md_message',
        'about_text', 'about_image',
        'patients_count', 'staff_count', 'doctors_count',
    ];

    public static function get()
    {
        return self::first() ?? new self();
    }
}