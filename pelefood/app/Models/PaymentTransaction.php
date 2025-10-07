<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'amount',
        'currency',
        'payment_method',
        'status',
        'transaction_id',
        'gateway_transaction_id',
        'description',
        'metadata',
        'commission',
        'commission_rate',
        'processed_at',
        'refunded_at',
        'refund_amount',
        'refund_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission' => 'decimal:2',
        'commission_rate' => 'decimal:4',
        'metadata' => 'array',
        'processed_at' => 'datetime',
        'refunded_at' => 'datetime',
        'refund_amount' => 'decimal:2',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    // Scopes
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', ' ') . ' ' . ($this->currency ?? 'FCFA');
    }

    public function getFormattedCommissionAttribute(): string
    {
        return number_format($this->commission ?? 0, 0, ',', ' ') . ' ' . ($this->currency ?? 'FCFA');
    }

    public function getIsRefundableAttribute(): bool
    {
        return $this->status === 'successful' && !$this->refunded_at;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'successful' => 'green',
            'failed' => 'red',
            'pending' => 'yellow',
            'refunded' => 'gray',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'successful' => 'Réussi',
            'failed' => 'Échoué',
            'pending' => 'En attente',
            'refunded' => 'Remboursé',
            default => 'Inconnu'
        };
    }

    // Methods
    public function markAsSuccessful(): void
    {
        $this->update([
            'status' => 'successful',
            'processed_at' => now(),
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update([
            'status' => 'failed',
            'processed_at' => now(),
        ]);
    }

    public function refund(float $amount = null, string $reason = null): void
    {
        $refundAmount = $amount ?? $this->amount;
        
        $this->update([
            'status' => 'refunded',
            'refunded_at' => now(),
            'refund_amount' => $refundAmount,
            'refund_reason' => $reason,
        ]);
    }

    public function calculateCommission(float $rate = null): float
    {
        $commissionRate = $rate ?? $this->commission_rate ?? 0.05; // 5% par défaut
        return $this->amount * $commissionRate;
    }
} 