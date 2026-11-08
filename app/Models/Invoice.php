<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no', 'patient_name', 'phone', 'email',
        'appointment_id', 'package_id', 'hospital_id',
        'subtotal', 'discount', 'total',
        'payment_status', 'payment_method', 'invoice_date', 'notes', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'invoice_date' => 'date',
        ];
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('sort_order');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public static function generateInvoiceNo(): string
    {
        $year = now()->format('Y');
        $lastInvoice = self::whereYear('created_at', $year)->orderByDesc('id')->first();
        $nextNumber = $lastInvoice ? ((int) substr($lastInvoice->invoice_no, -5)) + 1 : 1;

        return 'INV-' . $year . '-' . str_pad((string) $nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function recalculateTotal(): void
    {
        $subtotal = $this->items()->sum('line_total');
        $this->subtotal = $subtotal;
        $this->total = max(0, $subtotal - $this->discount);
        $this->save();
    }
}