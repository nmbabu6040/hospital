<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowcaseItem extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'title', 'image', 'description', 'link_url', 'item_date', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'item_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type)->where('is_active', true)->orderBy('sort_order');
    }
}