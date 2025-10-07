<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'subject',
        'content',
        'priority',
        'type',
        'is_read',
        'is_urgent',
        'parent_id',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
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

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    // Accessors
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
            'urgent' => 'Urgent',
            'high' => 'Élevée',
            'normal' => 'Normale',
            'low' => 'Faible',
            default => 'Inconnue'
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'support' => 'blue',
            'billing' => 'green',
            'technical' => 'purple',
            'general' => 'gray',
            default => 'gray'
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'support' => 'Support',
            'billing' => 'Facturation',
            'technical' => 'Technique',
            'general' => 'Général',
            default => 'Inconnu'
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
            return 'Urgent';
        }

        if (!$this->is_read) {
            return 'Non lu';
        }

        return 'Lu';
    }

    public function getShortContentAttribute(): string
    {
        return strlen($this->content) > 100 
            ? substr($this->content, 0, 100) . '...' 
            : $this->content;
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

    public function hasReplies(): bool
    {
        return $this->replies()->exists();
    }

    public function isReply(): bool
    {
        return !is_null($this->parent_id);
    }

    public function getThread(): \Illuminate\Database\Eloquent\Collection
    {
        if ($this->isReply()) {
            return Message::where('id', $this->parent_id)
                ->orWhere('parent_id', $this->parent_id)
                ->orderBy('created_at')
                ->get();
        }

        return Message::where('id', $this->id)
            ->orWhere('parent_id', $this->id)
            ->orderBy('created_at')
            ->get();
    }
} 