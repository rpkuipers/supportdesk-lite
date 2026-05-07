<?php

namespace App\Policies;

use App\Enums\TicketStatus;
use App\Models\Ticket;

class TicketPolicy
{
    public function resolve(?object $user, Ticket $ticket): bool
    {
        return $ticket->status !== TicketStatus::Resolved;
    }

    public function reopen(?object $user, Ticket $ticket): bool
    {
        return $ticket->status === TicketStatus::Resolved;
    }
}
