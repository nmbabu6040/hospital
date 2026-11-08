<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineSaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['medicine_sale_id', 'medicine_id', 'medicine_name', 'quantity', 'unit_price', 'line_total'];

    public function sale()
    {
        return $this->belongsTo(MedicineSale::class, 'medicine_sale_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}