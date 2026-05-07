<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case WaitingForCustomer = 'waiting_for_customer';
    case Resolved = 'resolved';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Open',
            self::InProgress => 'In behandeling',
            self::WaitingForCustomer => 'Wacht op klant',
            self::Resolved => 'Opgelost',
        };
    }

    public function isClosed(): bool
    {
        return $this === self::Resolved;
    }
}
