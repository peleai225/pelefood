<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'title',
        'content',
        'type',
        'priority',
        'is_read',
        'is_urgent',
        'action_url',
        'action_text',
        'metadata',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_urgent' => 'boolean',
        'metadata' => 'array',
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
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }

    // Accessors
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'success' => 'green',
            'warning' => 'yellow',
            'error' => 'red',
            'info' => 'blue',
            default => 'gray'
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'success' => 'Succès',
            'warning' => 'Avertissement',
            'error' => 'Erreur',
            'info' => 'Information',
            default => 'Inconnu'
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'normal' => 'blue',
            'low' => 'gray',
            default => 'gray'
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'Urgente',
            'high' => 'Élevée',
            'normal' => 'Normale',
            'low' => 'Faible',
            default => 'Inconnue'
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->is_urgent) {
            return 'bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full';
        }

        if (!$this->is_read) {
            return 'bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full';
        }

        return 'bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full';
    }

    public function getStatusTextAttribute(): string
    {
        if ($this->is_urgent) {
            return 'Urgente';
        }

        if (!$this->is_read) {
            return 'Non lue';
        }

        return 'Lue';
    }

    public function getShortContentAttribute(): string
    {
        return strlen($this->content) > 100 
            ? substr($this->content, 0, 100) . '...' 
            : $this->content;
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    // Methods
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    public function markAsUnread(): void
    {
        $this->update(['is_read' => false]);
    }

    public function markAsUrgent(): void
    {
        $this->update([
            'is_urgent' => true,
            'is_read' => false,
        ]);
    }

    public function hasAction(): bool
    {
        return !empty($this->action_url) && !empty($this->action_text);
    }

    public function isForUser(int $userId): bool
    {
        return $this->user_id === $userId;
    }

    public function isForTenant(int $tenantId): bool
    {
        return $this->tenant_id === $tenantId;
    }

    public function isGlobal(): bool
    {
        return is_null($this->user_id) && is_null($this->tenant_id);
    }

    // Static methods
    public static function createForUser(int $userId, array $data): self
    {
        return static::create(array_merge($data, ['user_id' => $userId]));
    }

    public static function createForTenant(int $tenantId, array $data): self
    {
        return static::create(array_merge($data, ['tenant_id' => $tenantId]));
    }

    public static function createGlobal(array $data): self
    {
        return static::create($data);
    }

    public static function createUrgent(array $data): self
    {
        return static::create(array_merge($data, [
            'priority' => 'urgent',
            'is_urgent' => true,
            'is_read' => false,
        ]));
    }
} 