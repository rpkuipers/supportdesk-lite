<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use app\Enums\TicketStatus;

class TicketHistory extends Model
{
    protected $fillable = [
        'ticket_id',    
        'user_id',
        'old_status',
        'new_status',
    ];
    
    protected function casts(): array
    {
        return [
            'old_status' => TicketStatus::class,
            'new_status' => TicketStatus::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}