<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RestaurantWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'balance',
        'pending_balance',
        'total_earnings',
        'total_withdrawals',
        'total_commission',
        'currency',
        'is_active',
        'last_transaction_at',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'total_withdrawals' => 'decimal:2',
        'total_commission' => 'decimal:2',
        'is_active' => 'boolean',
        'last_transaction_at' => 'datetime',
    ];

    // Relations
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class, 'restaurant_id', 'restaurant_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balance, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function getFormattedTotalEarningsAttribute(): string
    {
        return number_format($this->total_earnings, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function getFormattedTotalWithdrawalsAttribute(): string
    {
        return number_format($this->total_withdrawals, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function getFormattedTotalCommissionAttribute(): string
    {
        return number_format($this->total_commission, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function getAvailableBalanceAttribute(): float
    {
        return $this->balance - $this->pending_balance;
    }

    public function getFormattedAvailableBalanceAttribute(): string
    {
        return number_format($this->available_balance, 0, ',', ' ') . ' ' . $this->currency;
    }

    // Methods
    public function credit(float $amount, string $description = null): void
    {
        $this->increment('balance', $amount);
        $this->increment('total_earnings', $amount);
        $this->update(['last_transaction_at' => now()]);

        // Log the transaction
        $this->logTransaction('credit', $amount, $description);
    }

    public function debit(float $amount, string $description = null): bool
    {
        if ($this->balance < $amount) {
            return false; // Insufficient funds
        }

        $this->decrement('balance', $amount);
        $this->update(['last_transaction_at' => now()]);

        // Log the transaction
        $this->logTransaction('debit', $amount, $description);

        return true;
    }

    public function addPending(float $amount): void
    {
        $this->increment('pending_balance', $amount);
    }

    public function removePending(float $amount): void
    {
        $this->decrement('pending_balance', $amount);
    }

    public function addCommission(float $amount): void
    {
        $this->increment('total_commission', $amount);
    }

    public function canWithdraw(float $amount): bool
    {
        return $this->balance >= $amount && $amount >= 1000; // Minimum 1000 FCFA
    }

    public function getWithdrawalFees(): float
    {
        return 500; // Fixed withdrawal fee
    }

    public function calculateNetWithdrawal(float $amount): float
    {
        return $amount - $this->getWithdrawalFees();
    }

    private function logTransaction(string $type, float $amount, string $description = null): void
    {
        // TODO: Implement transaction logging
        // This could be stored in a separate transactions table
    }

    // Static methods
    public static function getOrCreate(int $restaurantId): self
    {
        return static::firstOrCreate(
            ['restaurant_id' => $restaurantId],
            [
                'balance' => 0,
                'pending_balance' => 0,
                'total_earnings' => 0,
                'total_withdrawals' => 0,
                'total_commission' => 0,
                'currency' => 'XOF',
                'is_active' => true,
            ]
        );
    }
}