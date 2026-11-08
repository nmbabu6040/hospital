<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'generic_name', 'manufacturer', 'category',
        'price', 'stock_quantity', 'low_stock_threshold', 'expiry_date',
        'description', 'requires_prescription', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'requires_prescription' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function isExpiringSoon(): bool
    {
        return $this->expiry_date && $this->expiry_date->diffInDays(now(), false) >= -30 && $this->expiry_date->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }
}