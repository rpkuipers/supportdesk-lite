<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Traits\HasTicketReference;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;
    use HasTicketReference;

    protected $fillable = [
        'customer_id',
        'category_id',
        'reference',
        'title',
        'description',
        'priority',
        'status',
        'created_by',
        'assigned_to',
        'due_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'priority' => TicketPriority::class,
            'status' => TicketStatus::class,
            'due_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function notes(): HasMany
    {
        return $this->hasMany(TicketNote::class)->latest();
    }
    public function statusHistories(): HasMany
    {
        return $this->hasMany(TicketHistory::class)->latest();
    }
    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', '!=', TicketStatus::Resolved->value);
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->whereNull('resolved_at')->where('due_at', '<', now());
    }

    public function isOverdue(): bool
    {
        return $this->resolved_at === null && $this->due_at?->isPast();
    }
}
