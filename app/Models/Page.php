<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'featured_image',
        'meta_title', 'meta_description',
        'show_in_menu', 'menu_location', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'show_in_menu' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}