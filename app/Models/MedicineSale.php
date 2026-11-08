<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineSale extends Model
{
    use HasFactory;

    protected $fillable = ['sale_no', 'customer_name', 'customer_phone', 'total_amount', 'discount', 'grand_total', 'sold_by'];

    public function items()
    {
        return $this->hasMany(MedicineSaleItem::class);
    }

    public function soldBy()
    {
        return $this->belongsTo(Admin::class, 'sold_by');
    }

    public static function generateSaleNo(): string
    {
        $today = now()->format('Ymd');
        $count = self::whereDate('created_at', now()->format('Y-m-d'))->count();

        return 'SALE-' . $today . '-' . str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
    }
}