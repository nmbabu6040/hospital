<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'invoice_id', 'package_id', 'patient_id',
        'payer_name', 'payer_email', 'payer_phone',
        'amount', 'currency', 'status', 'payment_method', 'card_type',
        'gateway_response', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'gateway_response' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function generateTransactionId(): string
    {
        return 'TXN-' . now()->format('YmdHis') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
    }
}