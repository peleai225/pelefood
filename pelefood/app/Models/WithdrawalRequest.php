<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'request_number',
        'amount',
        'fees',
        'net_amount',
        'status',
        'payment_method',
        'bank_details',
        'rejection_reason',
        'admin_notes',
        'processed_at',
        'approved_at',
        'processed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fees' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'bank_details' => 'array',
        'processed_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // Relations
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByRestaurant($query, int $restaurantId)
    {
        return $query->where('restaurant_id', $restaurantId);
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', ' ') . ' FCFA';
    }

    public function getFormattedNetAmountAttribute(): string
    {
        return number_format($this->net_amount, 0, ',', ' ') . ' FCFA';
    }

    public function getFormattedFeesAttribute(): string
    {
        return number_format($this->fees, 0, ',', ' ') . ' FCFA';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'blue',
            'processed' => 'green',
            'rejected' => 'red',
            'cancelled' => 'gray',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente',
            'approved' => 'Approuvé',
            'processed' => 'Traité',
            'rejected' => 'Rejeté',
            'cancelled' => 'Annulé',
            default => 'Inconnu'
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'pending' => 'fas fa-clock',
            'approved' => 'fas fa-check-circle',
            'processed' => 'fas fa-check-double',
            'rejected' => 'fas fa-times-circle',
            'cancelled' => 'fas fa-ban',
            default => 'fas fa-question-circle'
        };
    }

    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status === 'approved';
    }

    public function getIsProcessedAttribute(): bool
    {
        return $this->status === 'processed';
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->status === 'rejected';
    }

    public function getIsCancelledAttribute(): bool
    {
        return $this->status === 'cancelled';
    }

    public function getCanBeApprovedAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getCanBeRejectedAttribute(): bool
    {
        return in_array($this->status, ['pending', 'approved']);
    }

    public function getCanBeProcessedAttribute(): bool
    {
        return $this->status === 'approved';
    }

    public function getCanBeCancelledAttribute(): bool
    {
        return $this->status === 'pending';
    }

    // Methods
    public function approve(User $admin, string $notes = null): void
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'processed_by' => $admin->id,
            'admin_notes' => $notes,
        ]);
    }

    public function reject(User $admin, string $reason, string $notes = null): void
    {
        $this->update([
            'status' => 'rejected',
            'processed_by' => $admin->id,
            'rejection_reason' => $reason,
            'admin_notes' => $notes,
        ]);
    }

    public function process(User $admin, string $notes = null): void
    {
        $this->update([
            'status' => 'processed',
            'processed_at' => now(),
            'processed_by' => $admin->id,
            'admin_notes' => $notes,
        ]);
    }

    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    // Static methods
    public static function generateRequestNumber(): string
    {
        do {
            $number = 'WR-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (static::where('request_number', $number)->exists());

        return $number;
    }

    public static function createRequest(int $restaurantId, float $amount, array $bankDetails = []): self
    {
        $fees = 500; // Fixed withdrawal fee
        $netAmount = $amount - $fees;

        return static::create([
            'restaurant_id' => $restaurantId,
            'request_number' => static::generateRequestNumber(),
            'amount' => $amount,
            'fees' => $fees,
            'net_amount' => $netAmount,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'bank_details' => $bankDetails,
        ]);
    }
}