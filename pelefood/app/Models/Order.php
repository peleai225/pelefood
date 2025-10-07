<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'order_number',
        'status',
        'type',
        'subtotal',
        'delivery_fee',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'customer_info',
        'delivery_address',
        'customer_name',
        'customer_phone',
        'customer_email',
        'special_instructions',
        'estimated_delivery_time',
        'actual_delivery_time',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payment_details',
        'assigned_driver_id',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'customer_info' => 'array',
        'delivery_address' => 'array',
        'payment_details' => 'array',
        'estimated_delivery_time' => 'datetime',
        'actual_delivery_time' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Relations
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function assignedDriver()
    {
        return $this->belongsTo(User::class, 'assigned_driver_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePreparing($query)
    {
        return $query->where('status', 'preparing');
    }

    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }

    // Méthodes
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function getFormattedDeliveryFeeAttribute()
    {
        return number_format($this->delivery_fee, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'preparing' => 'En préparation',
            'ready' => 'Prête',
            'out_for_delivery' => 'En livraison',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée',
            'refunded' => 'Remboursée',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'preparing' => 'primary',
            'ready' => 'success',
            'out_for_delivery' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getTypeTextAttribute()
    {
        return $this->type === 'delivery' ? 'Livraison' : 'Retrait';
    }

    public function getPaymentStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'En attente',
            'paid' => 'Payé',
            'failed' => 'Échoué',
            'refunded' => 'Remboursé',
        ];

        return $statuses[$this->payment_status] ?? $this->payment_status;
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function getItemsCountAttribute()
    {
        return $this->items()->sum('quantity');
    }

    public function getEstimatedDeliveryTimeTextAttribute()
    {
        if (!$this->estimated_delivery_time) {
            return 'Non spécifié';
        }

        return $this->estimated_delivery_time->format('H:i');
    }

    public function getActualDeliveryTimeTextAttribute()
    {
        if (!$this->actual_delivery_time) {
            return 'Non livré';
        }

        return $this->actual_delivery_time->format('H:i');
    }

    public function getDeliveryDurationAttribute()
    {
        if (!$this->actual_delivery_time || !$this->created_at) {
            return null;
        }

        return $this->created_at->diffInMinutes($this->actual_delivery_time);
    }

    /**
     * Calculer le pourcentage de progression de la commande
     */
    public function getProgressPercentage()
    {
        $statuses = [
            'pending' => 0,
            'confirmed' => 25,
            'preparing' => 50,
            'ready' => 75,
            'out_for_delivery' => 90,
            'delivered' => 100,
            'cancelled' => 0,
            'refunded' => 0,
        ];

        return $statuses[$this->status] ?? 0;
    }

    /**
     * Obtenir l'étape actuelle de la commande
     */
    public function getCurrentStep()
    {
        $steps = [
            'pending' => 1,
            'confirmed' => 2,
            'preparing' => 3,
            'ready' => 4,
            'out_for_delivery' => 5,
            'delivered' => 6,
        ];

        return $steps[$this->status] ?? 1;
    }

    /**
     * Vérifier si une étape est complétée
     */
    public function isStepCompleted($step)
    {
        $currentStep = $this->getCurrentStep();
        return $currentStep > $step;
    }

    /**
     * Vérifier si une étape est active
     */
    public function isStepActive($step)
    {
        $currentStep = $this->getCurrentStep();
        return $currentStep === $step;
    }
}
